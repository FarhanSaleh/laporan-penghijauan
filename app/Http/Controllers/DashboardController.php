<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Laporan;
use App\Models\Berita;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        $totalUsers = User::count();
        $totalLaporan = Laporan::count();
        // $totalBerita = Berita::count();
        
        return view('dashboard.index', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'totalLaporan' => $totalLaporan,
            // 'totalBerita' => $totalBerita,
        ]);
    }
}
