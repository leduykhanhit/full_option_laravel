<?php

namespace App\Models\MongoDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Province extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'provinces';
    use HasFactory;
}
