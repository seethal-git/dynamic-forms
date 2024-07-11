<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\InputElement;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = Hash::make('admin@123'); 
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => $password,
            'role' => 'admin', // Set role to 'admin'
        ]);
        InputElement::create([
            'name' => 'Text',
            'type' => 'text',
            'has_options' => false
        ]);
        InputElement::create([
            'name' => 'Number',
            'type' => 'number',
            'has_options' => false
        ]);
        
        InputElement::create([
            'name' => 'Dropdown',
            'type' => 'select',
            'has_options' => true
        ]);
       
    }
}
