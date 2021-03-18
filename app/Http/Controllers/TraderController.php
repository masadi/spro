<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sub_ib;
use App\Trader;
class TraderController extends BaseController
{
    protected $trader = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Trader $trader)
    {
        $this->middleware('auth:api');
        $this->trader = $trader;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $traders = $this->trader->orderBy('nama_lengkap')->paginate(10);

        return $this->sendResponse($traders, 'Data Trader');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $categories = $this->trader->pluck('nama_lengkap', 'id');

        return $this->sendResponse($categories, 'Category list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        
        $sub_ib_id = $request->get('sub_ib_id');
        $sub_ib = $request->get('sub_ib');
        $trader = $this->trader->create([
            'nama_lengkap' => $request->get('nama_lengkap'),
            'nomor_akun' => $request->get('nomor_akun'),
            'email' => $request->get('email'),
            'telepon' => $request->get('telepon'),
            'bank' => $request->get('bank'),
            'nomor_rekening' => $request->get('nomor_rekening'),
            'nilai_rebate' => $request->get('nilai_rebate'),
            'sub_ib' => $request->get('sub_ib'),
            'sub_ib_id' => $sub_ib_id['code'],
        ]);
        if($sub_ib['code'] == 'ya'){
            Sub_ib::create([
                'trader_id' => $trader->id
            ]);
        }
        return $this->sendResponse($trader, 'Data Trader berhasil ditambah');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if($request->sub_ib['code'] == 'ya'){
            Sub_ib::updateOrCreate([
                'trader_id' => $id
            ]);
        } else {
            Sub_ib::where('trader_id', $id)->delete();
        }
        $trader = $this->trader->findOrFail($id);

        //$tag->update($request->all());
        $trader->nama_lengkap = $request->nama_lengkap;
        $trader->nomor_akun = $request->nomor_akun;
        $trader->email = $request->email;
        $trader->telepon = $request->telepon;
        $trader->bank = $request->bank;
        $trader->nomor_rekening = $request->nomor_rekening;
        $trader->nilai_rebate = $request->nilai_rebate;
        $trader->sub_ib = $request->sub_ib['code'];
        $trader->sub_ib_id = $request->sub_ib_id['code'];
        $trader->save();

        return $this->sendResponse($trader, 'Data Trader berhasil diperbaharui');
    }
}
