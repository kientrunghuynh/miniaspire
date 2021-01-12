<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerControllerTest extends TestCase
{
    private $_endpoint = '/api/customers';

    private $_default_payload = [
        'name' => 'name001',
        'email' => 'email001@gmail.com'
    ];

    private function _convertToArray($response)
    {
        return json_decode($response->getContent());
    }

    public function test_can_get_customer_list()
    {
        $this->json('GET', 'api/customers')
            ->assertStatus(200);
    }

    public function test_can_show_customer ()
    {
        $fakeCustomer = Customer::factory($this->_default_payload)->create();
        
        $response = $this->json('GET', $this->_endpoint . '/' . $fakeCustomer->id);
        $responseArray = $this->_convertToArray($response);
        $this->assertEquals($response->getStatusCode(), '200');
        $this->assertEquals($responseArray->customer->name, $fakeCustomer->name);
    }

    public function test_can_create_customer () 
    {
        $payload = [
            'name' => 'Trung Huynh',
            'email' => 'email@gmail.com'
        ];
        $response = $this->json('POST', $this->_endpoint, $payload);
        $responseArray = $this->_convertToArray($response);

        $this->assertEquals($responseArray->customer->name, $payload['name']);
        $this->assertEquals($responseArray->customer->email, $payload['email']);
        $this->assertEquals($response->getStatusCode(), '201');
    }

    public function test_can_not_create_user_without_name () 
    {
        $response = $this->json('POST', $this->_endpoint, [
            'name' => ''
        ]);        
        $this->assertEquals($response->getStatusCode(), '400');
    }

    public function test_can_update_customer ()
    {
        $fakeCustomer = Customer::factory($this->_default_payload)->create();

        $payload = [
            'name' => 'name002',
            'email' => 'email002@gmail.com'
        ];

        $response = $this->json('PUT', $this->_endpoint . '/' . $fakeCustomer->id, $payload);
        $responseArray = $this->_convertToArray($response);

        $this->assertEquals($response->getStatusCode(), '200');
        $this->assertEquals($responseArray->customer->name, $payload['name']);
    }

    public function test_can_delete_customer ()
    {
        $this->expectException(ModelNotFoundException::class);

        $fakeCustoemr = Customer::factory($this->_default_payload)->create();

        $response = $this->json('DELETE', $this->_endpoint . '/' . $fakeCustoemr->id);

        $this->assertEquals($response->getStatusCode(), '204');
        $deletedCustomer = Customer::findOrFail($fakeCustoemr->id);
    }
}
