<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Numeral extends Model
{
    protected $fillable = ['roman_numeral', 'number_requested', 'total_number_requested'];
}
