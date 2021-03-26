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
use Illuminate\Support\Facades\DB;

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
                    'tanggal_upload' => date('Y-m-d'),
                ]
            );
        });
        return $this->sendResponse($data, 'File Rebate berhasil diupload');
    }
    public function rebate(Request $request){
        /*$traders = Trader::orderBy('nama_lengkap')->whereHas('transaksi')->withCount([
            'transaksi AS volume' => function ($query) {
                $query->select(DB::raw("SUM(volume) as paidsum"));//->groupBy('tanggal_upload');
            },
            'transaksi AS rebate' => function ($query) {
                $query->select(DB::raw("SUM(rebate) as rebatea"));//->groupBy('tanggal_upload');
            }
        ])->whereNotNull('email')->paginate(10);*/
        $traders = Transaksi::whereHas('trader', function($query){
            $query->whereNotNull('email');
        })
        ->with('trader')
        ->selectRaw('trader_id')
        ->selectRaw('tanggal_upload')
        ->selectRaw("SUM(volume) as paidsum")
        ->selectRaw("SUM(rebate) as rebatea")
        ->groupBy('trader_id')
        ->groupBy('tanggal_upload')
        ->paginate(10);
        return $this->sendResponse($traders, 'Data Rebate Trader');
    }
}
