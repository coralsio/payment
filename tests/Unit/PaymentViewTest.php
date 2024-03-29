<?php

namespace Tests\Feature;

use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PaymentViewTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $user = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'superuser');
        })->first();

        Auth::loginUsingId($user->id);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_payment_view()
    {
        $response = $this->get('/payments/settings');

        $response->assertStatus(200)->assertViewIs('Payment::settings');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_webhook_calls_view()
    {
        $response = $this->get('/webhook-calls');

        $response->assertStatus(200)->assertViewIs('Payment::webhook_calls');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_invoices_view()
    {
        $response = $this->get('/invoices');

        $response->assertStatus(200)->assertViewIs('Payment::invoices.index');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_currencies_view()
    {
        $response = $this->get('/currencies');

        $response->assertStatus(200)->assertViewIs('Payment::currencies.index');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_transactions_view()
    {
        $response = $this->get('/transactions');

        $response->assertStatus(200)->assertViewIs('Payment::transactions.index');
    }
}
