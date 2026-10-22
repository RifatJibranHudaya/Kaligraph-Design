<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Admin/staff can view any order.
     * Customers can only view their own orders.
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->isAdminUser()) {
            return true;
        }

        return $user->id === $order->user_id;
    }

    /**
     * Only admin/staff can create orders on behalf of customers.
     * Customers create orders through the cart checkout flow.
     */
    public function create(User $user): bool
    {
        return $user->isAdminUser() || $user->isCustomer();
    }

    /**
     * Admin/staff can update any order.
     * Customers cannot directly update orders.
     */
    public function update(User $user, Order $order): bool
    {
        return $user->isAdminUser();
    }

    /**
     * Only admin/staff can update order status.
     */
    public function updateStatus(User $user, Order $order): bool
    {
        return $user->isAdminUser();
    }

    /**
     * Only admin/staff can delete orders.
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->isAdminUser();
    }

    /**
     * Customers can cancel their own orders (only if still 'order' status).
     * Admin/staff can cancel any order.
     */
    public function cancel(User $user, Order $order): bool
    {
        if ($user->isAdminUser()) {
            return true;
        }

        return $user->id === $order->user_id && $order->status === Order::STATUS_ORDER;
    }

    /**
     * Customer can upload receipt for their own order.
     * Admin/staff can upload for any order.
     */
    public function uploadReceipt(User $user, Order $order): bool
    {
        if ($user->isAdminUser()) {
            return true;
        }

        return $user->id === $order->user_id;
    }

    /**
     * Only admin/staff can verify receipts.
     */
    public function verifyReceipt(User $user, Order $order): bool
    {
        return $user->isAdminUser();
    }

    /**
     * Customer can send WhatsApp for their own order.
     * Admin/staff can send for any order.
     */
    public function sendWhatsapp(User $user, Order $order): bool
    {
        if ($user->isAdminUser()) {
            return true;
        }

        return $user->id === $order->user_id;
    }
}
