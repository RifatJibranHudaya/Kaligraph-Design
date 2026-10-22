<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Anyone can view active products (public catalog).
     * Admin/staff can view all products.
     */
    public function view(?User $user, Product $product): bool
    {
        if ($product->is_active) {
            return true;
        }

        return $user && $user->isAdminUser();
    }

    /**
     * Only admin/staff can create products.
     */
    public function create(User $user): bool
    {
        return $user->isAdminUser();
    }

    /**
     * Only admin/staff can update products.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->isAdminUser();
    }

    /**
     * Only admin/staff can delete products.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->isAdminUser();
    }
}
