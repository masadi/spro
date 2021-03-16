<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use Validator;
class DollarController extends BaseController
{
    protected $setting = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Setting $setting)
    {
        $this->middleware('auth:api');
        $this->setting = $setting;
    }
    public function index()
    {
        $traders = $this->setting->where('key', 'dollar')->first();

        return $this->sendResponse($traders, 'Kurs Dollar');
    }
    public function store(Request $request)
    {
        $messages = [
            'dollar.required'	=> 'Kurs Dollar tidak boleh kosong',
            'dollar.numeric'	=> 'Kurs Dollar harus berupa angka',
        ];
        $validator = Validator::make(request()->all(), [
            'dollar' => 'required|numeric',
            //'file' => 'required',
        ],
        $messages
        )->validate();
        $tag = $this->setting->updateOrCreate(
            [
                'key' => 'dollar'
            ],
            [
                'value' => $request->get('dollar')
            ]
        );

        return $this->sendResponse($tag, 'Kurs Dollar berhasil disimpan');
    }
}
