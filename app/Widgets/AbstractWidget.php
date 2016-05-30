<?php
/**
 * KYSS Abstract Widget class file.
 *
 * @package KYSS
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Widgets;

use Arrilot\Widgets\AbstractWidget as ArrilotAbstractWidget;
use Illuminate\Support\Arr;

/**
 * Abstract Widget.
 *
 * Introduces Shinobi support in Arrilot Widgets.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 * @abstract
 */
abstract class AbstractWidget extends ArrilotAbstractWidget {
  /**
   * Constructor
   *
   * @param array $config Optional. User-provided configuration values. Default
   * empty.
   */
  public function __construct(array $config = []) {
    if (!Arr::has($this->config, 'permissions.view'))
      Arr::set($this->config, 'permissions.view', config('widgets.permissions.view'));

    parent::__construct($config);
  }
}
