<?php

namespace App\Http\Controllers;

use App\Models\BPKB;
use App\Models\Customer;
use App\Models\STNK;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        })->except(['index']);
    }

    public function dashboard()
    {
        $customers = Customer::all();
        $bpkb_diterima = BPKB::where('status', 'Data diterima')->count();
        $bpkb_diproses = BPKB::where('status', 'Diproses')->count();
        $bpkb_selesai = BPKB::where('status', 'Selesai')->count();

        $stnk_diterima = STNK::where('status', 'Data diterima')->count();
        $stnk_diproses = STNK::where('status', 'Diproses')->count();
        $stnk_selesai = STNK::where('status', 'Selesai')->count();

        $diterima = $bpkb_diterima + $stnk_diterima;
        $diproses = $bpkb_diproses + $stnk_diproses;
        $selesai = $bpkb_selesai + $stnk_selesai;
        return view('admin.dashboard', compact('customers', 'diterima', 'diproses', 'selesai'));
    }
}
