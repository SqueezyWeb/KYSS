<?php
/**
 * KYSS Roles Table Seeder file.
 *
 * @package KYSS\Database\Seeds
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Database\Seeds;

use DB;

use Illuminate\Database\Seeder;

use KYSS\Models\Permission;

/**
 * Roles Table Seeder.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
class RolesTableSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $roles = [
      [
        'name' => 'Administrators',
        'slug' => 'admin',
        'description' => 'Have all access to all areas.',
        'special' => 'all-access'
      ],
      [
        'name' => 'General Users',
        'slug' => 'user',
        'description' => 'No admin access',
        'special' => null
      ],
      [
        'name' => 'Banned',
        'slug' => 'banned',
        'description' => 'Have no access to any areas',
        'special' => 'no-access'
      ]
    ];

    // Insert roles.
    DB::table('roles')->insert($roles);
    // Create admin user.

    $user_id = DB::table('users')->insertGetId([
      'name' => 'admin',
      'email' => 'admin@change.me',
      'password' => bcrypt('password')
    ]);

    // Associate admin user with admin role.
    DB::table('role_user')->insert([
      'role_id' => 1,
      'user_id' => $user_id
    ]);

    // Associate roles with permissions.
    $permission = Permission::where('slug', 'show.dashboard')->first();

    DB::table('permission_role')->insert([
      'role_id' => 2,
      'permission_id' => $permission->id
    ]);
  }
}
