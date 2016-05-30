<?php
/**
 * KYSS Permissions Table Seeder.
 *
 * @package KYSS\Database\Seeds
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Database\Seeds;

use Illuminate\Database\Seeder;
use DB;

/**
 * Permissions Table Seeder.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
class PermissionsTableSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @since 1.0.0
   * @access public
   */
  public function run() {
    $permissions = [
      [
        'name' => 'Show Widgets',
        'slug' => 'show.widget',
        'description' => 'View a generic widget'
      ]
    ];

    DB::table('permissions')->insert($permissions);
  }
}
