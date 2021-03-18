<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trader extends Model
{
    protected $guarded = [];
    /**
     * Get the Sub_ib associated with the Trader
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sub_ib()
    {
        return $this->hasOne('App\Sub_ib', 'trader_id', 'id');
    }
    /**
     * Get all of the afiliasi for the Trader
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function afiliasi()
    {
        return $this->hasMany('App\Trader', 'sub_ib_id', 'id');
    }
    public function transaksi()
    {
        return $this->hasMany('App\Transaksi', 'trader_id', 'id');
    }
}
