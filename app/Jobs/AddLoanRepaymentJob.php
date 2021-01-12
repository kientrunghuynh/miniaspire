<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Models\LoanRepayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AddLoanRepaymentJob
{
    use Dispatchable;

    /**
     * @var Request
     */
    private $request;

    private $repayment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, LoanRepayment $repayment = null)
    {
        $this->request = $request;
        $this->repayment = $repayment ?? new LoanRepayment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return DB::transaction(function () {
            return $this->saveLoanRepayment();
        });
    }

    private function saveLoanRepayment()
    {
        foreach ($this->repayment->getFillable() as $fillable) {
            if ($this->request->filled($fillable)) {
                $this->repayment->{$fillable} = $this->request->get($fillable);
            }
        }

        $this->repayment->save();

        return $this->repayment;
    }
}
