<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTranscation extends Model
{
    use HasFactory;


    public function balanceTranscation()
    {
        return $this->belongsTo('App\Models\Player');
    }
}
