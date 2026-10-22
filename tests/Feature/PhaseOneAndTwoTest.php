<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhaseOneAndTwoTest extends TestCase
{
    /**
     * Test Security Headers middleware is active.
     */
    public function test_security_headers_are_present(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    /**
     * Test Shopping Cart and Checkout Flow with Server-Side Calculation and Stock Deduction.
     */
    public function test_cart_and_checkout_flow_deducts_stock_and_calculates_server_side(): void
    {
        $category = Category::create([
            'nama' => 'Advertising',
            'slug' => 'advertising',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'nama' => 'Neon Box Akrilik',
            'sku' => 'NB-001',
            'harga_default' => 500000,
            'harga_min' => 500000,
            'harga_max' => 1000000,
            'stock' => 10,
            'is_active' => true,
        ]);

        $customer = User::create([
            'username' => 'budi_santoso',
            'email' => 'budi@example.com',
            'password' => bcrypt('password123'),
            'level' => 'customer',
            'user_type' => 'customer',
            'phone' => '081234567890',
        ]);

        // Add item to cart
        $cartItem = CartService::addItem($customer, $product->id, 2);
        $this->assertEquals(2, $cartItem->quantity);
        $this->assertEquals(500000, $cartItem->unit_price);

        // Checkout
        $order = CartService::checkout($customer, [
            'alamat' => 'Jl. Merdeka No. 45',
            'keterangan' => 'Tolong pasang besok',
        ]);

        $this->assertInstanceOf(Order::class, $order);
        // Total should be server-calculated: 2 * 500,000 = 1,000,000
        $this->assertEquals(1000000, $order->total);

        // Verify stock deducted from 10 to 8
        $product->refresh();
        $this->assertEquals(8, $product->stock);

        // Verify order items table has product_id, quantity, unit_price
        $orderItem = $order->items()->first();
        $this->assertNotNull($orderItem);
        $this->assertEquals($product->id, $orderItem->product_id);
        $this->assertEquals(2, $orderItem->quantity);
        $this->assertEquals(500000, $orderItem->unit_price);
        $this->assertEquals(1000000, $orderItem->subtotal);

        // Verify cart is cleared
        $cart = Cart::where('user_id', $customer->id)->first();
        $this->assertEquals(0, $cart->items()->count());

        // Cancel order -> Stock should be returned to 10
        OrderService::updateStatus($order, Order::STATUS_CANCELLED);
        $product->refresh();
        $this->assertEquals(10, $product->stock);

        // Clean up
        $order->items()->delete();
        $order->delete();
        $product->delete();
        $category->delete();
        $customer->delete();
    }

    /**
     * Test Customer cannot access other customer's order (IDOR Protection).
     */
    public function test_customer_cannot_access_other_customer_order(): void
    {
        $customerA = User::create([
            'username' => 'cust_a',
            'email' => 'a@example.com',
            'password' => bcrypt('password123'),
            'level' => 'customer',
            'user_type' => 'customer',
        ]);

        $customerB = User::create([
            'username' => 'cust_b',
            'email' => 'b@example.com',
            'password' => bcrypt('password123'),
            'level' => 'customer',
            'user_type' => 'customer',
        ]);

        $orderA = Order::create([
            'user_id' => $customerA->id,
            'nama_pelanggan' => 'cust_a',
            'total' => 300000,
            'status' => 'order',
        ]);

        // Customer B tries to view Customer A's order detail
        $response = $this->actingAs($customerB, 'customer')
            ->get(route('customer.order.detail', $orderA->id));

        // Should redirect with error, not allow viewing
        $response->assertRedirect(route('customer.dashboard'));
        $response->assertSessionHas('error');

        // Clean up
        $orderA->delete();
        $customerA->delete();
        $customerB->delete();
    }
}
