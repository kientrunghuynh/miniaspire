<?php 

namespace App\Models\InterestCalculations;

use Illuminate\Support\Collection;

interface LoanInterestCalculationStrategyInterface
{
    public function schedule(): Collection;
    public function getRepaymentAmount();
}