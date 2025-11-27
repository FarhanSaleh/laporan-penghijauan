<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Laporan;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            $data['users'] = User::with('role')->get();
            $data['totalUsers'] = User::count();
            $data['totalLaporan'] = Laporan::count();
            // $data['totalBerita'] = Berita::count();
            $data['laporan'] = Laporan::with('user', 'status')->latest()->get();
        } else if ($user->hasRole('petugas')) {
            $data['totalLaporan'] = Laporan::count();
            // $data['totalBerita'] = Berita::count();
            $data['laporan'] = Laporan::with('user', 'status')->latest()->get();
        } else if ($user->hasRole('user')) {
            $userId = Auth::id();
            $userLaporan = Laporan::where('user_id', $userId)->with('status')->latest()->get();

            $data['totalLaporanUser'] = $userLaporan->count();
            $data['laporanPending'] = $userLaporan->where('status_id', 1)->count();
            $data['laporanDiproses'] = $userLaporan->where('status_id', 2)->count();
            $data['laporanSelesai'] = $userLaporan->where('status_id', 3)->count();
            $data['laporanUser'] = $userLaporan;
        }

        return view('dashboard.index', $data);
    }
}
