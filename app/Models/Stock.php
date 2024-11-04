<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public $timestamps = true;
    //use HasFactory;
    // fillableに指定したプロパティは入力可能になる
    protected  $fillable = [
      'name',
      'amount',
      'price',
    ];
}
