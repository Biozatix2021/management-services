<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teknisi extends Model
{
    protected $table = 'teknisis';
    protected $fillable = ['nama', 'no_hp', 'color'];
}
