<?php

namespace Core\Loans\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * @param array $fillable
     * @return $this
     */

    protected $fillable = [
        'firstName',
        'lastName',
        'middleName',
        'amount',
        'interval',
        'status',
        'id',
    ];

}
