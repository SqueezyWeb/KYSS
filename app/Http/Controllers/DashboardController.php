<?php
/**
 * KYSS Dashboard Controller.
 *
 * @package KYSS\Http\Controllers
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace App\Http\Controllers;

use Widget;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
    $layout = config('dashboard.layout', 'two-columns'); // Config option, default.
    $layout = 'layouts.dashboard.'.trim($layout);
    view()->share('layout', $layout);

    Widget::group('dashboard')->addWidget('dashboard.Welcome', Arr::add([], 'permissions.view', 'view.widget.welcome'));
    Widget::group('dashboard')->addWidget('dashboard.Welcome', ['title' => 'Lorem ipsum', 'content' => 'Dolor sit amet']);

    return view('dashboard');
  }
}
