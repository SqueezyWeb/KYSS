<?php

use Illuminate\Database\Seeder;
use KYSS\Database\Seeds\PermissionsTableSeeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(PermissionsTableSeeder::class);
  }
}
