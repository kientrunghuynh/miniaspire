<?php

use App\Jobs\AddLoanJob;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\LoanRepayment;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tests\TestCase;

class AddLoanJobTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->request->merge($this->getRequest());
    }

    /**
     * @return array
     */
    private function getRequest()
    {
        $customer = Customer::factory()->create([
            'name' => 'customer002',
            'email' => 'customer002@gmail.com'
        ]);

        $loan = Loan::factory()->create([
            'amount' => 6000,
            'loan_term' => 6,
            'customer_id' => $customer->id
        ])->toArray();
        
        return $loan;
    }

    /**
     * @group loans
     */
    public function test_add_a_new_loan_with_all_required_data()
    {
        $loan = $this->dispatch(new AddLoanJob($this->request));

        self::assertInstanceOf(Loan::class, $loan);
        self::assertEquals(6, $loan->loan_term);
        self::assertEquals(Loan::PENDING, $loan->status);

        $loan->schedule->each(function (LoanRepayment $schedule) {
            self::assertNull($schedule->status);
            self::assertNull($schedule->repayment_timestamp);
            self::assertFalse($schedule->has_been_paid);
        });
    }
}
