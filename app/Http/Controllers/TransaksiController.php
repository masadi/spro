<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Transaksi;
use App\Trader;
use App\Setting;

class TransaksiController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function upload_file(Request $request)
    {
        $messages = [
            'file.required'	=> 'File Upload tidak boleh kosong',
            'file.mimes'	=> 'File Upload harus berekstensi .XLSX',
        ];
        $validator = Validator::make(request()->all(), [
            'file' => 'required|mimes:xlsx',
            //'file' => 'required',
        ],
        $messages
        )->validate();
        $setting = Setting::where('key', 'dollar')->first();
        $file = $request->file('file');
        $fileExcel = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads', $fileExcel);
        $data = (new FastExcel)->import('uploads/'.$fileExcel, function ($item) use ($setting) {
            $trader = Trader::updateOrCreate(
                [
                    'nama_lengkap' => $item['Klien'],
                    'nomor_akun' => $item['Akun'],
                ],
                [
                    'nilai_rebate' => 8,
                ]
            );
            $tanggal = strtotime($item['Tanggal']);
            $volume = str_replace(' lots', '', $item['Volume Trading']);
            $rebate = (($volume / $trader->nilai_rebate) * $trader->nilai_rebate)  * $setting->value;
            //=((E2/F2)*F2)*14000
            Transaksi::updateOrCreate(
                [
                    'trader_id' => $trader->id,
                    'tanggal' => $item['Tanggal'],
                ],
                [
                    'volume' => $volume,
                    'komisi' => $trader->nilai_rebate,
                    'dollar' => $setting->value,
                    'rebate' => $rebate,
                ]
            );
        });
        return $this->sendResponse($data, 'File Rebate berhasil diupload');
    }
}
