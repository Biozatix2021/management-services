<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaans';
    protected $fillable = ['nama', 'alamat', 'telp', 'email', 'website', 'logo'];
}
