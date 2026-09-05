<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminCustomerRoutesTest extends TestCase
{
    public function test_customer_routes_expose_the_expected_http_methods(): void
    {
        $routes = app('router')->getRoutes();

        $this->assertContains('GET', $routes->getByName('admin.customers.index')->methods());
        $this->assertContains('GET', $routes->getByName('admin.customers.show')->methods());
        $this->assertContains('PUT', $routes->getByName('admin.customers.update-status')->methods());
        $this->assertContains('DELETE', $routes->getByName('admin.customers.destroy')->methods());
    }

    public function test_customer_list_renders_filter_and_status_forms(): void
    {
        Auth::guard('admin')->setUser((new Admin())->forceFill([
            'name' => 'Test Admin',
            'avatar' => 'admin.png',
            'birthday' => '2000-01-01',
            'level' => 1,
            'status' => 1,
        ]));

        $customer = (new Customer())->forceFill([
            'id' => 42,
            'name' => 'Test Customer',
            'phone_number' => '0900000000',
            'money_payment_transactions' => 0,
            'score_awards' => 0,
            'status' => 1,
        ]);

        $view = $this->view('user.customers_list', [
            'customers' => collect([$customer]),
            'parameter' => null,
        ]);

        $view->assertSee('action="'.route('admin.customers.index').'"', false);
        $view->assertSee('value="potential_customer"', false);
        $view->assertSee('action="'.route('admin.customers.update-status', 42).'"', false);
        $view->assertSee('name="_method" value="PUT"', false);
    }
}
