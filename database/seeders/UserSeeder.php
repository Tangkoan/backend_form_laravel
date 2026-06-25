<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // កុំភ្លេច import User Model
use Illuminate\Support\Facades\Hash; // import សម្រាប់ Hash password

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'vc',
            'email' => 'vc@example.com', // Laravel ទាមទារ email ជាទូទៅ អាចដូរតាមចិត្តបាន
            'password' => Hash::make('Tangkoan@1100'), // Hash password ឱ្យមានសុវត្ថិភាព
        ]);
    }
}