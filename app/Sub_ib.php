<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_ib extends Model
{
    protected $fillable = ['nama_lengkap', 'nomor_akun', 'email', 'telepon', 'bank', 'nomor_rekening', 'sub_ib'];
}
