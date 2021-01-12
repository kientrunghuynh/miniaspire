<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    const PENDING = 'pending';
    const APPROVED = 'approved';
    const NUMBER_OF_DAYS_PER_WEEK = 5;
    const NUMBER_OF_REPAYMENTS_PER_MONTH = 4;

    protected $fillable = [
        'customer_id', 'amount', 'loan_term', 'status'
    ];

    /**
     * Get the customer who request the loans.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repaymentPlan()
    {
        return $this->belongsTo(RepaymentPlan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedule()
    {
        return $this->hasMany(LoanRepayment::class)->withoutGlobalScope('paid');
    }

    public function getNextRepaymentDueDatePerPlan($dueDate)
    {
        return Carbon::parse($dueDate)->startOfDay()->addWeekdays(self::NUMBER_OF_DAYS_PER_WEEK);
    }

    /**
     * @return mixed
     */
    public function getNumberOfRepayments(): int
    {
        return $this->loan_term * self::NUMBER_OF_REPAYMENTS_PER_MONTH;
    }

    public function getPrincipalAmount($format = true)
    {
        return $format ? number_format($this->amount, 2) : $this->amount;
    }
}
