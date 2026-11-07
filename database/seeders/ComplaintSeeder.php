<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if ($user) {
            Complaint::create([
                'user_id'     => $user->id,
                'jenis_aduan' => 'Sistem / Bug',
                'prioritas'   => 'high',
                'text'        => 'Aplikasi mendadak force close saat menekan tombol checkout.',
            ]);

            Complaint::create([
                'user_id'     => $user->id,
                'jenis_aduan' => 'Layanan Pelanggan',
                'prioritas'   => 'medium',
                'text'        => 'Admin belum membalas chat terkait konfirmasi stok barang.',
            ]);
        }
    }
}