<?php

namespace Core\Loans\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class LoanModel extends Model
{
    public $table = 'loan';
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

    public function passport()
    {
        $this->hasOne(PassportModel::class, 'loan_id');
    }
}
