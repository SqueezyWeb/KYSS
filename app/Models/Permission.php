<?php
/**
 * Permission Model file.
 *
 * @package KYSS\Models
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Permission Model.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
class Permission extends Model {
  /**
   * Attributes that should be mass-assignable.
   *
   * @since 1.0.0
   * @access protected
   * @var array
   */
  protected $fillable = ['name', 'slug', 'description'];

  /**
   * Roles that have the permissions.
   *
   * @since 1.0.0
   * @access public
   *
   * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function roles() {
    return $this->belongsToMany('KYSS\Models\Role');
  }
}
