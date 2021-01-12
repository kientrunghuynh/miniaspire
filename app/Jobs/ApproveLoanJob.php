<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Loan;

class ApproveLoanJob
{
    use Dispatchable;

    /**
     * @var Loan
     */
    private $loan;

    /**
     * @var Request
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, Loan $loan)
    {
        $this->loan = $loan;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return DB::transaction(function () {

            $this->updateLoan();

            return $this->loan;
        });
    }

    private function updateLoan()
    {
        // approving loans isn't allowed to be mass assigned
        $this->loan->forceFill([
            'approved_at' => $this->request->get('approved_at', Carbon::now()),
            'status' => Loan::APPROVED,
        ])->save();

        return $this->loan;
    }
}
