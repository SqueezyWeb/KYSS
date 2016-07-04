<?php
/**
 * Role and Permission Update Request file.
 *
 * @package KYSS\Http\Requests
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Http\Requests;

/**
 * Role and Permission Update Request.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
class UpdateRequest extends Request {
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
    $id = ($this->route('permission')) ?: $this->route('role');

    $table = str_plural($this->route()->parameterNames()[0]);

    return [
      'slug' => 'required|unique:'.$table.',slug,'.$id.'|max:255|min:4',
      'name' => 'required|unique:'.$table.',name,'.$id.'|max:255|min:4'
    ];
  }
}
