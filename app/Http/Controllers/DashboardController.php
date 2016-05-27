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
   * @return void
   */
  public function __construct() {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    Widget::group('dashboard')->addWidget('dashboard.Welcome');
    Widget::group('dashboard')->addWidget('dashboard.Welcome', ['title' => 'Lorem ipsum']);
    return view('dashboard');
  }
}
