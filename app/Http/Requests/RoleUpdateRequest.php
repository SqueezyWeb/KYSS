<?php
/**
 * Role and Permission Update Request file.
 *
 * @package KYSS\Http\Requests
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Http\Requests;

use Shinobi;

/**
 * Role and Permission Update Request.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
class RoleUpdateRequest extends Request {
  /**
   * Determine if user is authorized to make this request.
   *
   * @since 1.0.0
   * @access public
   *
   * @return bool
   */
  public function authorize() {
    return Shinobi::can('manage.users', false);
  }

  /**
   * Get validation rules that apply to the request.
   *
   * @since 1.0.0
   * @access public
   *
   * @return array
   */
  public function rules() {
    return [
      'slug' => 'required|unique:roles,slug,'.$this->role->id.'|max:255|min:4',
      'name' => 'required|unique:roles,name,'.$this->role->id.'|max:255|min:4'
    ];
  }
}
