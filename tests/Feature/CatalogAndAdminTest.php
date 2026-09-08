<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogAndAdminTest extends TestCase
{
    protected User $admin;
    protected Category $category;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $branch = Branch::firstOrCreate(
            ['nama_cabang' => 'Showroom Test'],
            ['alamat' => 'Alamat Test']
        );

        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            [
                'username' => 'admin_test',
                'password' => bcrypt('password'),
                'level' => 'superadmin',
                'user_type' => 'admin',
                'branch_id' => $branch->id,
            ]
        );

        $this->category = Category::firstOrCreate(
            ['slug' => 'neon-box-test'],
            [
                'nama' => 'Neon Box Test',
                'emoji' => '💡',
                'deskripsi' => 'Deskripsi test',
                'urutan' => 1,
                'is_active' => true,
            ]
        );

        $this->product = Product::firstOrCreate(
            ['nama' => 'Neon Box Test Product'],
            [
                'category_id' => $this->category->id,
                'harga_min' => 300000,
                'harga_max' => 600000,
                'harga_default' => 300000,
                'deskripsi' => 'Deskripsi produk test',
                'is_active' => true,
                'urutan' => 1,
            ]
        );
    }

    public function test_landing_page_renders(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Kaligraph Design');
        $response->assertSee('Neon Box Test');
    }

    public function test_katalog_page_renders(): void
    {
        $response = $this->get('/katalog');
        $response->assertStatus(200);
        $response->assertSee('Pilihan Kategori');
        $response->assertSee('Neon Box Test');
    }

    public function test_category_products_page_renders(): void
    {
        $response = $this->get('/katalog/' . $this->category->slug);
        $response->assertStatus(200);
        $response->assertSee('Neon Box Test Product');
    }

    public function test_product_detail_page_renders(): void
    {
        $response = $this->get('/katalog/' . $this->category->slug . '/' . $this->product->id);
        $response->assertStatus(200);
        $response->assertSee('Neon Box Test Product');
        $response->assertSee('Estimasi Biaya');
    }

    public function test_admin_dashboard_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Analytics');
    }

    public function test_admin_kategori_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get('/kategori');
        $response->assertStatus(200);
        $response->assertSee('Kelola Kategori');
    }

    public function test_admin_produk_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get('/produk');
        $response->assertStatus(200);
        $response->assertSee('Kelola Produk');
    }

    public function test_admin_status_order_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get('/status-order');
        $response->assertStatus(200);
        $response->assertSee('Status Pengerjaan');
    }

    public function test_admin_pembayaran_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get('/pembayaran');
        $response->assertStatus(200);
        $response->assertSee('Data Pembayaran');
    }

    public function test_admin_activity_log_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get('/activity-log');
        $response->assertStatus(200);
        $response->assertSee('Log Aktivitas Sistem');
    }

    public function test_public_portfolio_accessible(): void
    {
        $response = $this->get('/portofolio');
        $response->assertStatus(200);
        $response->assertSee('Hasil Karya');
    }

    public function test_admin_portfolio_accessible_and_crud(): void
    {
        $response = $this->actingAs($this->admin)->get('/portfolio');
        $response->assertStatus(200);
        $response->assertSee('Kelola Portofolio');

        // Create portfolio
        $storeResponse = $this->actingAs($this->admin)->post('/portfolio', [
            'nama' => 'Test Project Neon Box',
            'client' => 'PT Test Klien',
            'lokasi' => 'Demak',
            'tahun' => '2025',
            'deskripsi' => 'Deskripsi test portofolio',
            'is_active' => '1',
        ]);
        $storeResponse->assertRedirect();
        $this->assertDatabaseHas('portfolios', ['nama' => 'Test Project Neon Box']);
    }

    public function test_order_creation_and_status_update(): void
    {
        $order = Order::create([
            'nama_pelanggan' => 'Budi Test',
            'no_hp' => '08123456789',
            'status' => 'order',
            'user_id' => $this->admin->id,
            'branch_id' => $this->admin->branch_id,
            'total' => 500000,
        ]);

        $this->assertDatabaseHas('orders', ['id' => $order->id]);

        $response = $this->actingAs($this->admin)->put('/status-order/' . $order->id . '/status', [
            'status' => 'on_progress',
        ]);

        $response->assertRedirect();
        $this->assertEquals('on_progress', $order->fresh()->status);
    }

    public function test_customer_registration_sets_customer_level(): void
    {
        $uniqueEmail = 'cust_' . time() . '@example.com';
        $response = $this->post('/register/customer', [
            'name' => 'Customer Baru Test',
            'email' => $uniqueEmail,
            'phone' => '08987654321',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('customer.dashboard'));

        $user = User::where('email', $uniqueEmail)->first();
        $this->assertNotNull($user);
        $this->assertEquals('customer', $user->level);
        $this->assertEquals('customer', $user->user_type);
        $this->assertTrue($user->isCustomer());
    }

    public function test_admin_pelanggan_management_and_crud(): void
    {
        $response = $this->actingAs($this->admin)->get('/pelanggan');
        $response->assertStatus(200);
        $response->assertSee('Data Pelanggan');

        // Create customer from admin
        $custEmail = 'admin_add_cust_' . time() . '@example.com';
        $storeResponse = $this->actingAs($this->admin)->post('/pelanggan', [
            'username' => 'cust_admin_' . time(),
            'email' => $custEmail,
            'phone' => '08123456780',
            'password' => 'password123',
        ]);

        $storeResponse->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => $custEmail, 'level' => 'customer']);
    }

    public function test_admin_akses_staff_matrix_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get('/akses');
        $response->assertStatus(200);
        $response->assertSee('Hak Akses Admin &amp; Staf', false);
    }

    public function test_admin_akses_pelanggan_level_accessible_and_update(): void
    {
        $response = $this->actingAs($this->admin)->get('/akses/pelanggan');
        $response->assertStatus(200);
        $response->assertSee('Hak Akses Level Pelanggan');

        $updateResponse = $this->actingAs($this->admin)->put('/akses/pelanggan', [
            'permissions' => [
                'cust_create_order' => ['read' => '1', 'create' => '1'],
                'cust_order_tracking' => ['read' => '1'],
            ],
        ]);

        $updateResponse->assertRedirect();
        $this->assertDatabaseHas('role_permissions', [
            'role' => 'customer',
            'feature' => 'cust_create_order',
            'can_create' => true,
        ]);
    }
}
