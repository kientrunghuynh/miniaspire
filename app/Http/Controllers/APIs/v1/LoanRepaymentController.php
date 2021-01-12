<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use App\Models\LoanRepayment;
use Illuminate\Http\Request;
use App\Jobs\RepayLoanRepaymentJob;

class LoanRepaymentController extends Controller
{
    /**
     * @param inteter $id
     */
    public function repay($id, Request $request)
    {
        $loanRepayment = LoanRepayment::withoutGlobalScope('paid')->findOrFail($id);
        
        try {
            $this->dispatch(new RepayLoanRepaymentJob($request, $loanRepayment));
        } catch (\Exception $exception) {
            logger()->error('Repay could not be processed', compact('exception'));
            return response([
                'error' => [
                    'code'=> $exception->getCode(),
                    'message'=> $exception->getMessage()
                ],  
                'message' => 'Repay could not be processed'
            ], 400);
        };

        return response([
            'message' => 'The Repay has been processed'
        ], 200);
    }
}
