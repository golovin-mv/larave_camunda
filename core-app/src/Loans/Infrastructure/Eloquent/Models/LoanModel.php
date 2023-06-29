<?php

namespace Core\Loans\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LoanModel extends Model
{
    public $table = 'loan';

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'firstName',
        'lastName',
        'middleName',
        'amount',
        'interval',
        'status',
        'id',
    ];

    /**
     * @return HasOne
     */
    public function passport(): HasOne
    {
        return $this->hasOne(PassportModel::class, 'loanId');
    }

    public function address(): HasOne
    {
        return $this->hasOne(AddressModel::class, 'loanId');
    }
}
