<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Admin::create([
        'nama_admin' => 'Administrator Utama',
        'username' => 'admin',
        'password' => Hash::make('admin123'), // Password default
        'hak_akses' => 'admin'
    ]);
}
}
