<?php

namespace App\Jobs;

use App\Models\LoanRepayment;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepayLoanRepaymentJob
{
    use Dispatchable;

    private $request;

    private $loanRepayment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, LoanRepayment $loanRepayment)
    {
        $this->request = $request;
        $this->loanRepayment = $loanRepayment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return DB::transaction(function () {

            $this->repayLoanRepayment();

            return $this->loanRepayment;
        });
    }

    private function repayLoanRepayment()
    {
        $this->loanRepayment->update([
            'has_been_paid' => true,
            'repayment_timestamp' => Carbon::now(),
            // 'user_id' => auth()->id(),
            'status' => LoanRepayment::PAID,
        ]);

        return $this->loanRepayment;
    }
}
