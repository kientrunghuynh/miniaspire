<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AddLoanJob
{
    use Dispatchable;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Loan
     */
    private $loan;

    /**
     * Create a new job instance.
     *
     * @param Request $request
     * @param Loan $loan
     * @return void
     */
    public function __construct(Request $request, Loan $loan = null)
    {
        $this->request = $request;
        $this->loan = $loan ?? new Loan([
            'status' => Loan::PENDING
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): Loan
    {
        return DB::transaction(function () {
            // save loan
            $this->addOrUpdateLoan();

            // generate repayment schedule
            dispatch_now(new GenerateLoanRepaymentScheduleJob($this->loan));

            return $this->loan;
        });
    }

    private function addOrUpdateLoan()
    {
        foreach ($this->loan->getFillable() as $fillable) {
            if ($this->request->filled($fillable)) {
                $this->loan->{$fillable} = $this->request->get($fillable);
            }
        }

        $this->loan->save();

        return $this->loan;
    }
}
