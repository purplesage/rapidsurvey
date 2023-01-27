<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();

    User::factory()->create([
      'name' => 'david',
      'email' => 'hectormza21@gmail.com',
      'password' => bcrypt(21133034)
    ]);
  }
}
