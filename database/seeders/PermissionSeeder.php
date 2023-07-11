<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'lihat-absensi', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'validasi-absensi', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'lihat-penggajian', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'hitung-penggajian', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'lihat-pengeluaran', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'buat-pengeluaran', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ubah-pengeluaran', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'hapus-pengeluaran', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'lihat-pegawai', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'buat-pegawai', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ubah-pegawai', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'hapus-pegawai', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'lihat-jabatan', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'buat-jabatan', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ubah-jabatan', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'hapus-jabatan', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ];
        \DB::table('permissions')->insert($permissions);
    }
}
