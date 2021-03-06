<?php

use Illuminate\Database\Seeder;
use KYSS\Database\Seeds\PermissionsTableSeeder;
use KYSS\Database\Seeds\RolesTableSeeder;

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
    $this->call(RolesTableSeeder::class);
  }
}
