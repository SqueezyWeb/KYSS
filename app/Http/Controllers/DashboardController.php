<?php
/**
 * KYSS Dashboard Controller.
 *
 * @package KYSS\Http\Controllers
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Http\Controllers;

use Hook;
use Widget;
use KYSS\Http\Requests;
use Illuminate\Http\Request;

/**
 * Dashboard Controller.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 0.1.0
 */
class DashboardController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @since 0.1.0
   * @access public
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @since 0.1.0
   * @access public
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    Widget::group('dashboard.main')->addWidget('dashboard.Welcome');
    Widget::group('dashboard.left')->addWidget('dashboard.Welcome');
    Widget::group('dashboard.right')->addWidget('dashboard.Welcome');

    /**
     * Add additional widgets.
     *
     * Usage:
     * Hook::add('widgets.dashboard', $group) {
     *  $group->addWidget('foo');
     * }
     *
     * @since 0.1.0
     *
     * @param WidgetGroup
     */
    foreach (['main', 'left', 'right'] as $position)
      Hook::run('widgets.dashboard.'.$position, Widget::group('dashboard.'.$position));

    return view('dashboard');
  }
}
