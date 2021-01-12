<?php

use App\Models\Loan;
use App\Jobs\AddLoanJob;
use App\Jobs\ApproveLoanJob;
use App\Models\Customer;
use Tests\TestCase;

class ApproveLoanJobTest extends TestCase
{

    public function test_able_to_approve_loan()
    {
        $customer = Customer::factory()->create([
            'name' => 'customer001',
            'email' => 'customer001@gmail.com'
        ]);

        $loan = Loan::factory()->create([
            'amount' => 6000,
            'loan_term' => 6,
            'customer_id' => $customer->id
        ])->toArray();
        $this->request->merge($loan);

        $loan = $this->dispatch(new AddLoanJob($this->request));

        $this->dispatch(new ApproveLoanJob($this->request, $loan));

        self::assertNotNull($loan->approved_at);
        self::assertEquals(Loan::APPROVED, $loan->status);
    }
}