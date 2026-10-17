<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_creation_generates_slug_from_name_when_missing(): void
    {
        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);

        $response = $this->postJson('/api/products', [
            'name' => 'Laptop',
            'description' => 'A gaming laptop.',
            'price' => 1500.00,
            'sku' => 'LP-001',
            'category_id' => 1,
            'stock' => 10,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.slug', 'laptop');
    }

    public function test_products_can_be_sorted_by_cached_rating(): void
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);

        $lowerRatedProduct = $category->products()->create([
            'name' => 'Budget Laptop',
            'slug' => 'budget-laptop',
            'description' => 'A lower-rated product.',
            'price' => 600.00,
            'sku' => 'LP-002',
            'stock' => 10,
            'is_active' => true,
            'rating' => 3.5,
            'rating_count' => 2,
        ]);

        $higherRatedProduct = $category->products()->create([
            'name' => 'Premium Laptop',
            'slug' => 'premium-laptop',
            'description' => 'A higher-rated product.',
            'price' => 1800.00,
            'sku' => 'LP-003',
            'stock' => 10,
            'is_active' => true,
            'rating' => 4.8,
            'rating_count' => 9,
        ]);

        $response = $this->getJson('/api/products?sort_by=rating&sort_order=desc');

        $response->assertOk()
            ->assertJsonPath('data.0.id', $higherRatedProduct->id)
            ->assertJsonPath('data.1.id', $lowerRatedProduct->id);
    }
}
