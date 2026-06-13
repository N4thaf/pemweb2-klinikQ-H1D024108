<?php

namespace Database\Seeders;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@klinikq.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Pendaftaran',
            'email' => 'petugas@klinikq.test',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        $poliData = [
            ['nama' => 'Poli Umum', 'kode' => 'PU', 'deskripsi' => 'Pelayanan kesehatan umum untuk semua keluhan.'],
            ['nama' => 'Poli Gigi', 'kode' => 'PG', 'deskripsi' => 'Pelayanan kesehatan gigi dan mulut.'],
            ['nama' => 'Poli Anak', 'kode' => 'PA', 'deskripsi' => 'Pelayanan kesehatan khusus anak-anak.'],
            ['nama' => 'Poli Kandungan', 'kode' => 'PK', 'deskripsi' => 'Pelayanan kesehatan kandungan dan kebidanan.'],
        ];

        foreach ($poliData as $data) {
            Poli::create($data);
        }

        $dokterData = [
            ['nama' => 'dr. Andi Pratama', 'spesialisasi' => 'Dokter Umum', 'no_hp' => '08111234501', 'poli_id' => 1],
            ['nama' => 'dr. Siti Rahayu', 'spesialisasi' => 'Dokter Umum', 'no_hp' => '08111234502', 'poli_id' => 1],
            ['nama' => 'drg. Budi Santoso', 'spesialisasi' => 'Dokter Gigi', 'no_hp' => '08111234503', 'poli_id' => 2],
            ['nama' => 'drg. Maya Dewi', 'spesialisasi' => 'Dokter Gigi', 'no_hp' => '08111234504', 'poli_id' => 2],
            ['nama' => 'dr. Rini Kusuma, Sp.A', 'spesialisasi' => 'Spesialis Anak', 'no_hp' => '08111234505', 'poli_id' => 3],
            ['nama' => 'dr. Hendra Wijaya, Sp.OG', 'spesialisasi' => 'Spesialis Kandungan', 'no_hp' => '08111234506', 'poli_id' => 4],
        ];

        foreach ($dokterData as $data) {
            Dokter::create($data);
        }

        $pasienData = [
            ['nik' => '3301010101800001', 'nama' => 'Agus Setiawan', 'tgl_lahir' => '1980-01-01', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Merdeka No. 1, Purwokerto', 'no_hp' => '08122345601'],
            ['nik' => '3301010201850002', 'nama' => 'Dewi Anggraeni', 'tgl_lahir' => '1985-02-01', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Sudirman No. 5, Purwokerto', 'no_hp' => '08122345602'],
            ['nik' => '3301010301900003', 'nama' => 'Fajar Nugroho', 'tgl_lahir' => '1990-03-01', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Diponegoro No. 10, Purwokerto', 'no_hp' => '08122345603'],
            ['nik' => '3301010401920004', 'nama' => 'Indah Permata', 'tgl_lahir' => '1992-04-01', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Ahmad Yani No. 15, Purwokerto', 'no_hp' => '08122345604'],
            ['nik' => '3301010501950005', 'nama' => 'Rizky Ramadhan', 'tgl_lahir' => '1995-05-01', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Gatot Subroto No. 20, Purwokerto', 'no_hp' => '08122345605'],
            ['nik' => '3301010601880006', 'nama' => 'Sari Wulandari', 'tgl_lahir' => '1988-06-01', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Veteran No. 25, Purwokerto', 'no_hp' => '08122345606'],
            ['nik' => '3301010701750007', 'nama' => 'Bambang Sutrisno', 'tgl_lahir' => '1975-07-01', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Pahlawan No. 30, Purwokerto', 'no_hp' => '08122345607'],
            ['nik' => '3301010801830008', 'nama' => 'Nurul Hidayah', 'tgl_lahir' => '1983-08-01', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Pemuda No. 35, Purwokerto', 'no_hp' => '08122345608'],
            ['nik' => '3301010901980009', 'nama' => 'Deni Prasetyo', 'tgl_lahir' => '1998-09-01', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Kartini No. 40, Purwokerto', 'no_hp' => '08122345609'],
            ['nik' => '3301011001910010', 'nama' => 'Fitri Handayani', 'tgl_lahir' => '1991-10-01', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Cut Nyak Dien No. 45, Purwokerto', 'no_hp' => '08122345610'],
        ];

        foreach ($pasienData as $data) {
            Pasien::create($data);
        }

        $today = now()->toDateString();
        $antrianData = [
            ['poli_id' => 1, 'pasien_id' => 1, 'nomor_antrian' => 1, 'tanggal' => $today, 'status' => 'selesai'],
            ['poli_id' => 1, 'pasien_id' => 2, 'nomor_antrian' => 2, 'tanggal' => $today, 'status' => 'sedang_dilayani'],
            ['poli_id' => 1, 'pasien_id' => 3, 'nomor_antrian' => 3, 'tanggal' => $today, 'status' => 'dipanggil'],
            ['poli_id' => 1, 'pasien_id' => 4, 'nomor_antrian' => 4, 'tanggal' => $today, 'status' => 'menunggu'],
            ['poli_id' => 1, 'pasien_id' => 5, 'nomor_antrian' => 5, 'tanggal' => $today, 'status' => 'menunggu'],
            ['poli_id' => 2, 'pasien_id' => 6, 'nomor_antrian' => 1, 'tanggal' => $today, 'status' => 'sedang_dilayani'],
            ['poli_id' => 2, 'pasien_id' => 7, 'nomor_antrian' => 2, 'tanggal' => $today, 'status' => 'menunggu'],
            ['poli_id' => 3, 'pasien_id' => 8, 'nomor_antrian' => 1, 'tanggal' => $today, 'status' => 'menunggu'],
        ];

        foreach ($antrianData as $data) {
            Antrian::create($data);
        }

        $kunjunganData = [
            ['pasien_id' => 1, 'dokter_id' => 1, 'tanggal' => now()->subDays(3)->toDateString(), 'keluhan' => 'Demam dan batuk sudah 3 hari', 'diagnosis' => 'ISPA ringan', 'catatan' => 'Istirahat cukup, minum air putih banyak'],
            ['pasien_id' => 2, 'dokter_id' => 2, 'tanggal' => now()->subDays(2)->toDateString(), 'keluhan' => 'Sakit kepala dan pusing', 'diagnosis' => 'Tension headache', 'catatan' => 'Kurangi stres, tidur teratur'],
            ['pasien_id' => 3, 'dokter_id' => 3, 'tanggal' => now()->subDays(1)->toDateString(), 'keluhan' => 'Gigi berlubang bagian bawah kanan', 'diagnosis' => 'Karies gigi', 'catatan' => 'Perlu penambalan gigi'],
            ['pasien_id' => 4, 'dokter_id' => 5, 'tanggal' => now()->subDays(5)->toDateString(), 'keluhan' => 'Anak demam 3 hari tidak turun', 'diagnosis' => 'Demam berdarah suspek', 'catatan' => 'Rujuk ke RS untuk cek darah'],
            ['pasien_id' => 5, 'dokter_id' => 1, 'tanggal' => $today, 'keluhan' => 'Nyeri perut bagian kanan bawah', 'diagnosis' => 'Gastroenteritis', 'catatan' => 'Diet lunak, antibiotik 5 hari'],
        ];

        foreach ($kunjunganData as $data) {
            Kunjungan::create($data);
        }
    }
}
