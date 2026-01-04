<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\SendProductCreatedNotification;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return $this->renderIndex();
    }

    public function create()
    {
        return $this->renderIndex(panel: 'create');
    }

    public function show(Product $product)
    {
        return $this->renderIndex(panel: 'show', product: $product);
    }

    public function edit(Product $product)
    {
        return $this->renderIndex(panel: 'edit', product: $product);
    }

    public function store(StoreProductRequest $request)
    {
        $payload = $request->validated();
        $payload['data'] = $this->normalizeAttributes($payload['data'] ?? null);

        $product = Product::create($payload);

        SendProductCreatedNotification::dispatch($product)->afterCommit();

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Продукт успешно создан');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $payload = $request->validated();
        $payload['data'] = $this->normalizeAttributes($payload['data'] ?? null);

        $product->update($payload);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Продукт успешно обновлен');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Продукт успешно удален');
    }

    private function renderIndex(?string $panel = null, ?Product $product = null)
    {
        $products = Product::query()
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products', 'panel', 'product'));
    }

    /**
     * UI отправляет: data[0][key], data[0][value] ...
     * В БД храним ассоц массив: { "Цвет": "черный", "Размер": "L" }
     */
    private function normalizeAttributes($data): ?array
    {
        if (!is_array($data)) {
            return null;
        }

        $assoc = [];
        foreach ($data as $row) {
            $key = trim((string)($row['key'] ?? ''));
            $value = (string)($row['value'] ?? '');

            if ($key === '') {
                continue;
            }

            $assoc[$key] = $value;
        }

        return $assoc ?: null;
    }
}
