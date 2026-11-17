<?php

namespace Tests\Feature\Api;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleGuardRoutesTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_super_admin_can_register_login_and_access_dashboard(): void
    {
        $payload = [
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'super_admin',
        ];

        $register = $this->postJson('/api/super-admin/register', $payload);
        $register->assertStatus(201)
            ->assertJsonPath('status', 'success');

        $admin = Admin::where('email', 'superadmin@example.com')->firstOrFail();
        $admin->forceFill(['email_verified_at' => now()])->save();

        $login = $this->postJson('/api/super-admin/login', [
            'email' => 'superadmin@example.com',
            'password' => 'Password123!',
        ]);

        $login->assertStatus(200)
            ->assertJsonPath('status', 'success');

        $token = $login->json('data.token');

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/super-admin/dashboard')
            ->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_manager_and_support_can_login_and_view_audit_routes(): void
    {
        $this->createProduct();

        User::create([
            'name' => 'Customer One',
            'email' => 'customer@example.com',
            'password' => 'Password123!',
        ]);

        $manager = Admin::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => 'Password123!',
            'role' => 'manager',
        ]);
        $manager->forceFill(['email_verified_at' => now()])->save();

        $managerLogin = $this->postJson('/api/manager/login', [
            'email' => 'manager@example.com',
            'password' => 'Password123!',
        ]);

        $managerLogin->assertStatus(200)
            ->assertJsonPath('status', 'success');

        $managerToken = $managerLogin->json('data.token');

        $this->withHeader('Authorization', 'Bearer ' . $managerToken)
            ->getJson('/api/manager/dashboard')
            ->assertStatus(200)
            ->assertJsonPath('success', true);

        $support = Admin::create([
            'name' => 'Support User',
            'email' => 'support@example.com',
            'password' => 'Password123!',
            'role' => 'support',
        ]);
        $support->forceFill(['email_verified_at' => now()])->save();

        $supportLogin = $this->postJson('/api/support/login', [
            'email' => 'support@example.com',
            'password' => 'Password123!',
        ]);

        $supportLogin->assertStatus(200)
            ->assertJsonPath('status', 'success');

        $supportToken = $supportLogin->json('data.token');

        $this->withHeader('Authorization', 'Bearer ' . $supportToken)
            ->getJson('/api/support/dashboard')
            ->assertStatus(200)
            ->assertJsonPath('success', true);
    }
}
