<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddLoanFormRequest;
use App\Http\Resources\LoanResource;
use App\Jobs\AddLoanJob;
use App\Jobs\ApproveLoanJob;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::paginate();
        return LoanResource::collection($loans);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddLoanFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddLoanFormRequest $request)
    {
        try {
            $this->dispatch(new AddLoanJob($request));
        } catch (\Exception $exception) {
            $error_message = 'Loan could not be created';
            logger()->error($error_message, compact('exception'));
            return response([
                'error' => [
                    'code'=> $exception->getCode(),
                    'message'=> $exception->getMessage()
                ],  
                'message' => $error_message
            ], 400);
        }
        return response([
            'message' => 'The loan has been created pending approval'             
        ], 201);
    }

    public function approve(Request $request, Loan $loan)
    {
        try {
            dispatch(new ApproveLoanJob($request, $loan));
        } catch (\Exception $exception) {
            logger('Error occurred approving loan', ['error' => $exception->getMessage()]);
            return response([
                'error' => [
                    'code'=> $exception->getCode(),
                    'message'=> $exception->getMessage()
                ],  
                'message' => 'Loan could not be created'             
            ], 400);
        }
        return response([
            'message' => 'The loan is approved'             
        ], 200);
    }
}
