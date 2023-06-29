<?php

namespace Core\Loans\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PassportModel extends Model
{
    use HasUuids;

    public $table = 'passport';

    protected $fillable = [
      'number',
      'series',
    ];
}
