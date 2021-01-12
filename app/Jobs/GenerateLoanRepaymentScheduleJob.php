<?php

namespace App\Jobs;

use App\Models\InterestCalculations\StraightLineInterestCalculationStrategy;
use App\Models\Loan;
use App\Models\LoanRepayment;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

class GenerateLoanRepaymentScheduleJob
{
    use Dispatchable;

    /**
     * var Loan
     */
    private $loan;

    private $strategy;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
        $this->strategy = new StraightLineInterestCalculationStrategy($this->loan);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): Collection
    {
        // drop all repayments for this loan (if any) before re/generating
        $this->loan->schedule()->delete();
        return $this->strategy->schedule();
    }
}
