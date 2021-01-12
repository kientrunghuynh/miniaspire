<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\LoanRepayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanRepaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanRepayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $loan = Loan::factory()->create();
        
        return [
            'loan_id' => $loan->id,
            'amount' => $this->faker->randomNumber(4),
            'has_been_paid' => 0,
        ];
    }
}
