<?php

namespace App\Models\InterestCalculations;

use App\Models\Loan;
use App\Jobs\AddLoanRepaymentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;


class StraightLineInterestCalculationStrategy implements LoanInterestCalculationStrategyInterface
{
    use DispatchesJobs;
    
    /**
     * @var Loan
     */
    private $loan;

    /**
     * StraightLineInterestCalculationStrategy constructor.
     * @param Loan $loan
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Generate a repayment schedule for this Loan using Straight
     * Line to calculate interest
     *
     * @return Collection
     */
    public function schedule(): Collection
    {
        $dueDate = $this->loan->created_at;

        $repayments = collect([]);

        for ($i = 1; $i <= $this->loan->getNumberOfRepayments(); $i++) {
            $dueDate = $this->loan->getNextRepaymentDueDatePerPlan($dueDate);
            $repaymentAmount = $this->getRepaymentAmount();

            $request = new Request([
                'loan_id' => $this->loan->id,
                'amount' => $repaymentAmount,
                'due_date' => $dueDate
            ]);

            $repayments->push($this->dispatch(new AddLoanRepaymentJob($request)));
        }

        return $repayments;
    }

    /**
     * @return float
     */
    public function getRepaymentAmount()
    {
        return $this->loan->getPrincipalAmount(false) / $this->loan->getNumberOfRepayments();
    }
}