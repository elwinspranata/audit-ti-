<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Midtrans\Snap;

class PaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed packages
        Package::create([
            'name' => 'Test Package',
            'price' => 100000,
            'description' => 'Test',
            'duration_days' => 30,
        ]);
    }

    public function test_user_without_subscription_cannot_access_audit()
    {
        $user = User::factory()->create(['role' => 'user']);
        $package = Package::first();
        $assessment = \App\Models\Assessment::create([
            'user_id' => $user->id,
            'name' => 'Test Assessment',
            'package_id' => $package->id,
            'status' => \App\Models\Assessment::STATUS_PENDING_SUBMISSION
        ]);

        $response = $this->actingAs($user)->get(route('audit.index', $assessment));

        $response->assertRedirect(route('pricing.index'));
    }

    public function test_user_can_view_checkout_page_and_create_transaction()
    {
        $user = User::factory()->create(['role' => 'user']);
        $package = Package::first();

        // 1. User views pricing
        $response = $this->actingAs($user)->get(route('pricing.index'));
        $response->assertStatus(200);
        $response->assertSee($package->name);
    }

    public function test_admin_can_approve_payment_and_give_access()
    {
        $user = User::factory()->create(['role' => 'user']);
        $package = Package::first();

        // Simulate a transaction that has been "Paid" at Midtrans but pending Admin
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'transaction_code' => 'TEST-' . time(),
            'amount' => $package->price,
            'payment_status' => 'paid', // User already paid via Midtrans
            'admin_status' => 'pending', // Waiting for admin
            'payment_method' => 'midtrans',
        ]);

        $assessment = \App\Models\Assessment::create([
            'user_id' => $user->id,
            'name' => 'Test Assessment',
            'package_id' => $package->id,
            'transaction_id' => $transaction->id,
            'status' => \App\Models\Assessment::STATUS_PENDING_SUBMISSION
        ]);

        // 1. User still cannot access audit
        $response = $this->actingAs($user)->get(route('audit.index', $assessment));
        $response->assertRedirect(route('pricing.index'));

        // 2. Admin approves it
        $admin = User::factory()->create(['role' => 'admin', 'is_approved' => true]);
        
        // Admin views the transaction
        $response = $this->actingAs($admin)->get(route('admin.payments.show', $transaction->id));
        $response->assertStatus(200);

        // Admin submits approval
        $response = $this->actingAs($admin)->patch(route('admin.payments.verify', $transaction->id), [
            'admin_status' => 'approved',
        ]);
        
        $response->assertRedirect(route('admin.payments.index'));

        // Check DB
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'admin_status' => 'approved',
        ]);

        // 3. User should now have access
        $user->refresh();
        // audit.index redirects to user.assessments.show
        $response = $this->actingAs($user)->get(route('audit.index', $assessment));
        $response->assertRedirect(route('user.assessments.show', $assessment));
        
        $response = $this->actingAs($user)->get(route('user.assessments.show', $assessment));
        $response->assertStatus(200); // Success!        
    }
}
