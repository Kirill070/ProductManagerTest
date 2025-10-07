<?php

namespace App\Policies;

use App\Models\Product;

class ProductPolicy
{
    public function update(?object $user, Product $product): bool
    {
        return true; // редактировать можно всем (по ТЗ)
    }

    public function updateArticle(?object $user, Product $product): bool
    {
        return config('products.role') === 'admin';
    }

    public function delete(?object $user, Product $product): bool
    {
        return true;
    }
}
