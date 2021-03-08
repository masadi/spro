<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trader extends Model
{
    protected $fillable = ['nama_lengkap', 'nomor_akun', 'email', 'telepon', 'bank', 'nomor_rekening', 'nilai_rebate', 'sub_ib_id'];
}
