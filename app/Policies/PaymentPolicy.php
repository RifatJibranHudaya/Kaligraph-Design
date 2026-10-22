<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Admin/staff can view any payment.
     * Customers can only view payments of their own orders.
     */
    public function view(User $user, Payment $payment): bool
    {
        if ($user->isAdminUser()) {
            return true;
        }

        return $payment->order && $user->id === $payment->order->user_id;
    }

    /**
     * Only admin/staff can record payments.
     */
    public function create(User $user): bool
    {
        return $user->isAdminUser();
    }

    /**
     * Only admin/staff can delete payments.
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $user->isAdminUser();
    }

    /**
     * Admin/staff can view the payment receipt/nota.
     * Customers can view for their own orders.
     */
    public function viewNota(User $user, Payment $payment): bool
    {
        if ($user->isAdminUser()) {
            return true;
        }

        return $payment->order && $user->id === $payment->order->user_id;
    }
}
