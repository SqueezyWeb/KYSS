<?php
/**
 * Role and Permission Store Request file.
 *
 * @package KYSS\Http\Requests
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Http\Requests;

/**
 * Role and Permission Store Request.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
class StoreRequest extends Request {
  /**
   * Determine if user is authorized to make this request.
   *
   * @since 1.0.0
   * @access public
   *
   * @return bool
   */
  public function authorize() {
    return true;
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
    $name = $this->route()->getName();
    $table = (str_contains($name, 'role')) ? 'roles' : 'permissions';

    return [
      'name' => 'required|unique:'.$table.'|max:255|min:4',
      'slug' => 'required|unique:'.$table.'|max:255|min:4'
    ];
  }
}
