<?php

namespace Tests\Feature\Api;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function createVerifiedAdmin(array $attributes = []): Admin
    {
        $admin = Admin::create([
            'name' => $attributes['name'] ?? 'Admin User',
            'email' => $attributes['email'] ?? 'admin@example.com',
            'password' => $attributes['password'] ?? 'Password123!',
        ]);

        $admin->forceFill(['email_verified_at' => now()])->save();

        return $admin;
    }

    protected function createProduct(): Product
    {
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test category',
            'is_active' => true,
        ]);

        return Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'A sample product',
            'price' => 100.00,
            'stock_quantity' => 10,
            'sku' => 'TEST-' . uniqid(),
            'category_id' => $category->id,
            'brand' => 'Acme',
            'stock' => 10,
            'is_active' => true,
        ]);
    }

    public function test_admin_auth_routes_work(): void
    {
        $payload = [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ];

        $register = $this->postJson('/api/admin/register', $payload);
        $register->assertStatus(201)
            ->assertJsonPath('status', 'success');

        $admin = Admin::where('email', 'admin@example.com')->firstOrFail();
        $admin->forceFill(['email_verified_at' => now()])->save();

        $login = $this->postJson('/api/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'Password123!',
        ]);

        $login->assertStatus(200)
            ->assertJsonPath('status', 'success');

        $token = $login->json('data.token');

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/admin/logout')
            ->assertStatus(200)
            ->assertJsonPath('status', 'success');
    }

    public function test_admin_review_routes_work(): void
    {
        $admin = $this->createVerifiedAdmin();
        $product = $this->createProduct();
        $user = User::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => 'Password123!',
        ]);

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'title' => 'Great product',
            'comment' => 'Very happy with it.',
            'is_verified_purchase' => true,
            'status' => 'pending',
        ]);

        $token = $admin->createToken('admin-auth')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/admin/reviews')
            ->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/admin/reviews/pending/count')
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.pending_reviews', 1);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->patchJson('/api/admin/reviews/' . $review->id . '/moderate', [
                'status' => 'approved',
                'note' => 'Looks good',
            ])
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'approved');

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson('/api/admin/reviews/' . $review->id)
            ->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_admin_email_verification_routes_work(): void
    {
        Notification::fake();

        $admin = Admin::create([
            'name' => 'Verifier',
            'email' => 'verify-admin@example.com',
            'password' => 'Password123!',
        ]);

        $token = $admin->createToken('admin-auth')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/admin/email/verification-notification')
            ->assertStatus(200)
            ->assertJsonPath('status', 'success');

        $verifyUrl = URL::signedRoute('admin.verification.verify', [
            'id' => $admin->getKey(),
            'hash' => sha1($admin->getEmailForVerification()),
        ]);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson($verifyUrl)
            ->assertStatus(200)
            ->assertJsonPath('status', 'success');
    }
}
