<?php
/**
 * Dashboard Welcome Widget file.
 *
 * @package KYSS\Widgets\Dashboard
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace App\Widgets\Dashboard;

use Arrilot\Widgets\AbstractWidget;

/**
 * Dashboard Welcome Widget.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 0.1.0
 */
class Welcome extends AbstractWidget {
  /**
   * The configuration array.
   *
   * @since 0.1.0
   * @access protected
   * @var array
   */
  protected $config = [
    'title' => 'Welcome!'
  ];

  /**
   * Treat this method as a controller action.
   * Return view() or other content to display.
   *
   * @since 0.1.0
   *
   * @return View
   */
  public function run() {
    return view("widgets.welcome", [
      'widget' => $this->config,
    ]);
  }
}
