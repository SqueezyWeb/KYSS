<?php
/**
 * KYSS Role Model file.
 *
 * @package KYSS\Models
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Role Model.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
class Role extends Model {
  /**
   * Attributes that should be mass-assignable.
   *
   * @since 1.0.0
   * @access protected
   * @var array
   */
  protected $fillable = ['name', 'slug', 'description', 'special'];

  /**
   * Users that belong to the role.
   *
   * @since 1.0.0
   * @access public
   *
   * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function users() {
    return $this->belongsToMany('KYSS\Models\User');
  }

  /**
   * Permissions that belong to the role.
   *
   * @since 1.0.0
   * @access public
   *
   * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function permissions() {
    return $this->belongsToMany('KYSS\Models\Permission');
  }
}
