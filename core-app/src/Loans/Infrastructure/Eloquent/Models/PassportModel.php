<?php

namespace Core\Loans\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class PassportModel extends Model
{
    public $table = 'passport';

    protected $fillable = [
      'number',
      'series',
    ];
}
