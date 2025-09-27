<?php

namespace App\Http\Controllers;

use App\Models\Tarik;
use App\Models\Nasabah;
use App\Models\Setoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function index()
    {
        $user = Auth::user();

        if($user->role == 'nasabah') {
            $nasabah = Nasabah::where('user_id', $user->id)->first();
            $data_setoran = 0;
            $data_tarik = 0;
            if($nasabah) {
                $data_setoran = Setoran::where('nasabah_id', $nasabah->id)->sum('jumlah_uang');
                $data_tarik = Tarik::where('nasabah_id', $nasabah->id)->sum('jumlah_uang_tarik');
            }

            $data = [
                'title'   => 'Dashboard Nasabah',
                'setoran' => $data_setoran,
                'tarik'   => $data_tarik,
                'saldo'   => $data_setoran-$data_tarik,
                'page'    => 'NasabahDashboard'
            ];

            return view('NasabahDashboard', $data);
        } else {
            $data_setoran = Setoran::sum('jumlah_uang');
            $data_setoran_kg = Setoran::sum('berat_setor');
            $data_tarik = Tarik::sum('jumlah_uang_tarik');
            $data_nasabah = Nasabah::count('id');
    
            $grafik_setoran = Setoran::select(
                                    DB::raw('DATE(tanggal_setoran) as tanggal'),
                                    DB::raw('SUM(jumlah_uang) as jumlah_uang')
                                )
                                ->groupBy('tanggal')
                                ->orderBy('tanggal', 'asc')
                                ->pluck('jumlah_uang', 'tanggal'); 
                                // hasil: ['2025-09-01' => 5000, '2025-09-02' => 3000, ...]
    
            $grafik_tarik = Tarik::select(
                                    DB::raw('DATE(tanggal_tarik) as tanggal'),
                                    DB::raw('SUM(jumlah_uang_tarik) as jumlah_uang')
                                )
                                ->groupBy('tanggal')
                                ->orderBy('tanggal', 'asc')
                                ->pluck('jumlah_uang', 'tanggal');
    
            $tanggal = $grafik_setoran->keys()->merge($grafik_tarik->keys())->unique()->sort()->values();
            
    
            // siapkan dataset sesuai tanggal
            $setoran = $tanggal->map(fn($t) => $grafik_setoran[$t] ?? 0);
            $tarik   = $tanggal->map(fn($t) => $grafik_tarik[$t] ?? 0);
    
            $data_grafik = [
                'tanggal' => $tanggal,
                'setoran' => $setoran,
                'tarik'   => $tarik,
            ];
    
            $data = [
                'title' => 'Admin Dashboard',
                'totalUsers' => \App\Models\User::count(),
                'recentActivities' => $this->getRecentActivities(),
                'page' => 'AdminDashboard',
                'data' => [
                    'setoran' => $data_setoran,
                    'setoran_berat' => $data_setoran_kg,
                    'tarik' => $data_tarik,
                    'nasabah' => $data_nasabah,
                    'grafik' => $data_grafik,
                ]
            ];
    
            return view('AdminDashboard', $data);
        }

    }

    /**
     * Menampilkan manajemen user
     */
    public function userManagement()
    {
        $users = \App\Models\User::with('roles')->paginate(10);

        return view('admin.users.index', [
            'title' => 'Manajemen User',
            'users' => $users,
            'page' => 'user-management'
        ]);
    }

    /**
     * Menampilkan laporan statistik
     */
    public function reports()
    {
        // Logic untuk laporan admin
        return view('admin.reports', [
            'title' => 'Laporan Admin',
            'page' => 'reports'
        ]);
    }

    /**
     * Method untuk mendapatkan aktivitas terkini
     */
    protected function getRecentActivities()
    {
        // Contoh data aktivitas, bisa diganti dengan model Activity Log
        return [
            ['user' => 'Admin', 'action' => 'Login', 'time' => now()->subMinutes(5)],
            ['user' => 'User123', 'action' => 'Registrasi', 'time' => now()->subHours(1)],
            ['user' => 'Admin', 'action' => 'Update settings', 'time' => now()->subHours(2)]
        ];
    }

    /**
     * Method untuk API data dashboard (jika diperlukan)
     */
    public function getDashboardData()
    {
        $data = [
            'total_users' => \App\Models\User::count(),
            'active_users' => \App\Models\User::where('is_active', true)->count(),
            'new_users_today' => \App\Models\User::whereDate('created_at', today())->count(),
            'stats' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                'data' => [65, 59, 80, 81, 56]
            ]
        ];

        return response()->json($data);
    }
}
