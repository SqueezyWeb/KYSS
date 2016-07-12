<?php
/**
 * User Model file.
 *
 * @package KYSS\Models
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Models;

use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
  /**
   * Include traits.
   *
   * @since 0.1.0
   */
  use Authenticatable, CanResetPassword, ShinobiTrait;

  /**
   * The attributes that are mass assignable.
   *
   * @since 0.1.0
   * @access protected
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @since 0.1.0
   * @access protected
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * Roles that have the user.
   *
   * @since 0.2.0
   * @access public
   *
   * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function roles() {
    return $this->belongsToMany('KYSS\Models\Role');
  }
}
