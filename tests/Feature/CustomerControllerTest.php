<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;

class CustomerControllerTest extends TestCase
{
    public function test_can_get_customer_list()
    {
        $this->json('GET', 'api/customers')
            ->assertStatus(200);
    }

    public function test_can_create_customer () 
    {
        $payload = [
            'name' => 'Trung Huynh',
            'email' => 'email@gmail.com'
        ];
        $response = $this->json('POST', '/api/customers', $payload);

        // convert JSON response string to Array
        $responseArray = json_decode($response->getContent());

        $this->assertEquals($responseArray->customer->name, $payload['name']);
        $this->assertEquals($responseArray->customer->email, $payload['email']);
        $this->assertEquals($response->getStatusCode(), '201');
    }

    public function test_can_not_create_user_without_name () 
    {
        $response = $this->json('POST', '/api/customers', [
            'name' => ''
        ]);        
        $this->assertEquals($response->getStatusCode(), '400');
    }
}
