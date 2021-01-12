<?php

namespace Tests\Unit;

use App\Jobs\RepayLoanRepaymentJob;
use App\Models\LoanRepayment;
use Tests\TestCase;

class RepayLoanRepaymentJobTest extends TestCase
{
    private function _createFakeLoanRepayment () 
    {
        return LoanRepayment::factory()->create();
    }
    /**
     * @return void
     */
    public function test_able_to_repay_loan_repayment()
    {
        $fakeLoanRepayment = LoanRepayment::factory()->create();

        $loanRepayment = $this->dispatch(new RepayLoanRepaymentJob($this->request, $fakeLoanRepayment));

        self::assertTrue($loanRepayment->has_been_paid);
        self::assertNotEmpty($loanRepayment->repayment_timestamp);
        self::assertEquals(LoanRepayment::PAID,$loanRepayment->status);
    }

    public function test_can_mark_the_repayment_as_paid () 
    {
        $fakeLoanRepayment = $this->_createFakeLoanRepayment();

        $fakeLoanRepayment->markAsPaid();

        self::assertTrue($fakeLoanRepayment->has_been_paid);
        self::assertNotEmpty($fakeLoanRepayment->repayment_timestamp);
        self::assertEquals(LoanRepayment::PAID,$fakeLoanRepayment->status);
    }
}
