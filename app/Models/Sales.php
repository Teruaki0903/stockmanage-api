<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    //use HasFactory;
    // fillableに指定したプロパティは入力可能になる
    protected  $fillable = [
      'name',
      'sales',
    ];
}
