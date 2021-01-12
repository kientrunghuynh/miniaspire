<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    use HasFactory;

    const PAID = 'Paid';

    protected $fillable = [
        'loan_id', 'amount', 'has_been_paid',
        'repayment_timestamp', 'due_date', 'status'
    ];

    protected $dates = ['repayment_timestamp', 'due_date'];

    protected $casts = [
        'has_been_paid' => 'boolean',
        'amount' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();

        // get actual payments
        static::addGlobalScope('paid', function (Builder $builder) {
            return  $builder->where('has_been_paid', 1)
                            ->whereNotNull('repayment_timestamp');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Update a repayment to indicate it is fully paid
     *
     * @return bool
     */
    public function markAsPaid()
    {
        return $this->update([
            'has_been_paid' => true,
            'repayment_timestamp' => Carbon::now(),
            'status' => self::PAID,
        ]);
    }
}
