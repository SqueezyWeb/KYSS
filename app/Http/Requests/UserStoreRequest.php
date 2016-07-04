<?php
/**
 * User Store Request file.
 *
 * @package KYSS\Http\Requests
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Http\Requests;

/**
 * User Store Request.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 0.1.0
 */
class UserStoreRequest extends Request {
  /**
   * {@internal: missing description}
   *
   * @since 0.1.0
   * @access public
   *
   * @return array
   */
  public function all() {
    $atts = parent::all();

    if ($atts['password'] === $atts['password_confirmation']) {
      $crypted = bcrypt($atts['password']);
      $atts['password'] = $crypted;
      $atts['password_confirmation'] = $crypted;
    }

    return $atts;
  }

  /**
   * Determine if user is authorized to make this request.
   *
   * @since 0.1.0
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
   * @since 0.1.0
   * @access public
   *
   * @return array
   */
  public function rules() {
    return [
      'name' => 'required|max:255|unique:users',
      'email' => 'required|email|unique:users',
      'password' => 'required|confirmed|min:6'
    ];
  }
}
