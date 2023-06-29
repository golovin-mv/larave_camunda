<?php

namespace Core\Loans\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AddressModel extends Model
{
    use HasUuids;

    public $table = 'address';

    protected $fillable = [
        'address',
        'postalCode',
    ];
}
