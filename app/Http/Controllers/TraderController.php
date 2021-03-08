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
        $traders = $this->trader->latest()->paginate(10);

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
        $data_sub_ib = $request->get('data_sub_ib');
        //dd($data_sub_ib);
        $tag = $this->trader->create([
            'nama_lengkap' => $request->get('nama_lengkap'),
            'nomor_akun' => $request->get('nomor_akun'),
            'email' => $request->get('email'),
            'telepon' => $request->get('telepon'),
            'bank' => $request->get('bank'),
            'nomor_rekening' => $request->get('nomor_rekening'),
            'nilai_rebate' => $request->get('rebate'),
            'sub_ib_id' => $data_sub_ib['code'],
        ]);

        return $this->sendResponse($tag, 'Data Trader berhasil ditambah');
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
        $tag = $this->trader->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'Data Trader berhasil diperbaharui');
    }
}
