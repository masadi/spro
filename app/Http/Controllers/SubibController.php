<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sub_ib;
class SubibController extends BaseController
{
    protected $sub_ib = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Sub_ib $sub_ib)
    {
        $this->middleware('auth:api');
        $this->sub_ib = $sub_ib;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_ibs = $this->sub_ib->latest()->paginate(10);

        return $this->sendResponse($sub_ibs, 'Data SUB IB');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $categories = $this->sub_ib->pluck('nama_lengkap', 'id');

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
        $tag = $this->sub_ib->create([
            'nama_lengkap' => $request->get('nama_lengkap'),
            'nomor_akun' => $request->get('nomor_akun'),
            'email' => $request->get('email'),
            'telepon' => $request->get('telepon'),
            'bank' => $request->get('bank'),
            'nomor_rekening' => $request->get('nomor_rekening'),
            'sub_ib' => ($request->get('sub_ib')) ? $request->get('sub_ib') : 'Tidak',
        ]);

        return $this->sendResponse($tag, 'Data SUB IB berhasil ditambah');
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
        $tag = $this->sub_ib->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'Data SUB IB berhasil diperbaharui');
    }
}
