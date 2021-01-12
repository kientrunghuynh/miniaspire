<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanControllerTest extends TestCase
{
    private $_endpoint = '/api/loans';

    private function _generate_fake_loan () 
    {
        $customer = Customer::factory([
            'name' => "name001",
            'email' => 'email@gmail.com'
        ])->create();

        return [
            "customer_id"   => $customer->id,
            "loan_term"     => 12,
            "amount"        => 6000
        ];
    }

    private function _convertToArray($response)
    {
        return json_decode($response->getContent());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_show_loans()
    {
        $response = $this->get($this->_endpoint);

        $response->assertStatus(200);
    }

    public function test_can_create_new_loan ()
    {
        $fakeLoan = $this->_generate_fake_loan();

        $response = $this->json('POST', $this->_endpoint, $fakeLoan);
        $this->assertEquals($response->getStatusCode(), '201');
    }

    public function test_can_not_create_new_loan ()
    {
        $fakeLoan = [
            "customer_id"   => 10000,
            "loan_term"     => 32,
            "amount"        => 1
        ];

        $response = $this->json('POST', $this->_endpoint, $fakeLoan);
        $this->assertEquals($response->getStatusCode(), '422');
    }

    public function test_can_approve_loan ()
    {
        $fakeLoan = Loan::factory($this->_generate_fake_loan())->create();

        $response = $this->json('POST', $this->_endpoint . '/' . $fakeLoan->id . '/approve');
        $this->assertEquals($response->getStatusCode(), '200');
    }

    public function test_can_not_approve_loan ()
    {
        $response = $this->json('POST', $this->_endpoint . '/10000/approve');
        $this->assertEquals($response->getStatusCode(), '404');
    }
}
