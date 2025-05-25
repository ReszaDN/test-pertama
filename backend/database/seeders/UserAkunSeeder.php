<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

use DB;

class UserAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $userId = DB::table('users')->insertGetId([
                'name' => 'USER PENDAFTARAN',
                'username' => 'pendaftaran',
                'email' => 'pendaftaran@admin.com',
                'password' => Hash::make('pendaftaran'),
                'jenis_pegawai' => 'pendaftaran',
                'created_at' => now(),
                'updated_at' => now(),
        ]);


        $userId = DB::table('users')->insertGetId([
                'name' => 'USER DOKTER',
                'username' => 'dokter',
                'email' => 'dokter@admin.com',
                'password' => Hash::make('dokter'),
                'jenis_pegawai' => 'dokter',
                'created_at' => now(),
                'updated_at' => now(),
        ]);

        $userId = DB::table('users')->insertGetId([
                'name' => 'USER PERAWAT',
                'username' => 'perawat',
                'email' => 'perawat@admin.com',
                'password' => Hash::make('perawat'),
                'jenis_pegawai' => 'perawat',
                'created_at' => now(),
                'updated_at' => now(),
        ]);

        $userId = DB::table('users')->insertGetId([
                'name' => 'USER APOTEKER',
                'username' => 'apoteker',
                'email' => 'apoteker@admin.com',
                'password' => Hash::make('apoteker'),
                'jenis_pegawai' => 'apoteker',
                'created_at' => now(),
                'updated_at' => now(),
        ]);
    }
}
