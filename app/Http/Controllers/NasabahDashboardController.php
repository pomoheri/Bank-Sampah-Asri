<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NasabahDashboardController extends Controller
{
    /**
     * Menampilkan dashboard nasabah
     */
    public function index()
    {
        $user = Auth::user();

        // Data khusus nasabah
        $data = [
            'title' => 'Dashboard Nasabah',
            'user' => $user,
            'saldo' => $this->getSaldo($user),
            'transaksiTerbaru' => $this->getTransaksiTerbaru($user),
            'tabungan' => $this->getDataTabungan($user),
            'page' => 'NasabahDashboard'
        ];

        return view('NasabahDashboard', $data);
    }

    /**
     * Menampilkan profil nasabah
     */
    public function profile()
    {
        $user = Auth::user();

        return view('nasabah.profile', [
            'title' => 'Profil Saya',
            'user' => $user,
            'page' => 'profile'
        ]);
    }

    /**
     * Menampilkan history transaksi
     */
    public function transactionHistory()
    {
        $user = Auth::user();
        $transactions = $this->getAllTransactions($user);

        return view('nasabah.transactions', [
            'title' => 'Riwayat Transaksi',
            'transactions' => $transactions,
            'page' => 'transactions'
        ]);
    }

    /**
     * Menampilkan detail tabungan
     */
    public function savings()
    {
        $user = Auth::user();

        return view('nasabah.savings', [
            'title' => 'Tabungan Saya',
            'savingsData' => $this->getDetailTabungan($user),
            'page' => 'savings'
        ]);
    }

    /**
     * Method helper untuk mendapatkan saldo
     */
    protected function getSaldo($user)
    {
        // Contoh logic, sesuaikan dengan model Anda
        // return \App\Models\Saldo::where('user_id', $user->id)->first()->amount ?? 0;
        return 5000000; // Contoh static
    }

    /**
     * Method helper untuk transaksi terbaru
     */
    protected function getTransaksiTerbaru($user)
    {
        // Contoh data transaksi
        return [
            ['type' => 'Setor', 'amount' => 1000000, 'date' => now()->subDays(1)],
            ['type' => 'Tarik', 'amount' => 500000, 'date' => now()->subDays(3)],
            ['type' => 'Setor', 'amount' => 2000000, 'date' => now()->subDays(5)]
        ];
    }

    /**
     * Method helper untuk data tabungan
     */
    protected function getDataTabungan($user)
    {
        return [
            'total' => 5000000,
            'monthly_interest' => 25000,
            'last_update' => now()->subDays(1)
        ];
    }

    /**
     * Method helper untuk semua transaksi
     */
    protected function getAllTransactions($user)
    {
        // Contoh data lengkap
        return [
            ['id' => 1, 'type' => 'deposit', 'amount' => 1000000, 'status' => 'success', 'date' => now()->subDays(1)],
            ['id' => 2, 'type' => 'withdraw', 'amount' => 500000, 'status' => 'success', 'date' => now()->subDays(3)],
            ['id' => 3, 'type' => 'deposit', 'amount' => 2000000, 'status' => 'pending', 'date' => now()->subDays(5)]
        ];
    }

    /**
     * Method helper untuk detail tabungan
     */
    protected function getDetailTabungan($user)
    {
        return [
            'regular' => 3000000,
            'gold' => 2000000,
            'platinum' => 0,
            'total' => 5000000
        ];
    }

    /**
     * Method untuk export data (jika diperlukan)
     */
    public function exportData(Request $request)
    {
        // Logic untuk export data nasabah
        $type = $request->get('type', 'pdf');

        // return export logic here
        return response()->json(['message' => 'Export feature coming soon']);
    }
}
