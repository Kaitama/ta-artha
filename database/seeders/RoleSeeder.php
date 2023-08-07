<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $kepala_sekolah = Role::create([
            'name'  => 'kepala-sekolah',
            'rate'  => 26000,
            'travel' => 600000,
            'bonus' => 800000,
            'absence_cut'   => 50000,
            'limit' => 500000,
            'priority'      => true,
        ]);
        $kepala_sekolah->syncPermissions([
            'lihat-absensi',
            'validasi-absensi',
            'lihat-pegawai',
        ]);
        $kasir = Role::create([
            'name'  => 'kasir',
            'rate'  => 26000,
            'travel' => 100000,
            'bonus' => 150000,
            'limit' => 500000,
            'absence_cut'   => 50000,
            'priority'      => true,
        ]);
        $kasir->syncPermissions([
            'lihat-penggajian',
            'hitung-penggajian',
            'lihat-pengeluaran',
            'buat-pengeluaran',
            'ubah-pengeluaran',
            'hapus-pengeluaran',
            'lihat-pegawai',
            'buat-pegawai',
            'ubah-pegawai',
            'hapus-pegawai',
            'lihat-jabatan',
            'buat-jabatan',
            'ubah-jabatan',
            'hapus-jabatan',
        ]);
        $guru_tetap = Role::create([
            'name'  => 'guru-tetap',
            'rate'  => 26000,
            'travel' => 100000,
            'bonus' => 150000,
            'limit' => 500000,
            'absence_cut'   => 50000,
            'priority'      => true,
        ]);
        $guru_honor = Role::create([
            'name'  => 'guru-honor',
            'rate'  => 40000,
            'absence_cut'   => 40000,
            'priority'      => true,
        ]);
        $bendahara = Role::create([
            'name' => 'bendahara',
            'base' => 500000,
            'limit' => 500000,
            'priority'      => true,
        ]);
        $bendahara->syncPermissions([
            'lihat-absensi',
            'lihat-penggajian',
            'lihat-pengeluaran',
            'lihat-pegawai',
            'lihat-jabatan',
        ]);
    }
}
