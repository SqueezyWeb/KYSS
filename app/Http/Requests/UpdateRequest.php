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
    $model = strpos($this->route()->getName(), 'permission') !== false ? 'permission' : 'role';
    $table = str_plural($model);

    return [
      'slug' => 'required|unique:'.$table.',slug,'.$this->{$model}->id.'|max:255|min:4',
      'name' => 'required|unique:'.$table.',name,'.$this->{$model}->id.'|max:255|min:4'
    ];
  }
}
