<?php

namespace Database\Seeders;

use App\Models\ComplaintType;
use Illuminate\Database\Seeder;

class ComplaintTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Layanan Pelanggan', 'code' => 'CS', 'description' => 'Aduan terkait respon staf'],
            ['name' => 'Sistem / Bug', 'code' => 'BUG', 'description' => 'Kendala teknis pada aplikasi'],
            ['name' => 'Pengiriman & Kurir', 'code' => 'SHIPPING', 'description' => 'Keterlambatan paket'],
            ['name' => 'Kualitas Produk', 'code' => 'PRODUCT', 'description' => 'Barang rusak atau cacat'],
            ['name' => 'Pembayaran & Transaksi', 'code' => 'PAYMENT', 'description' => 'Gagal verifikasi pembayaran'],
        ];
        foreach ($types as $type) {
            ComplaintType::create($type);
        }
    }
}