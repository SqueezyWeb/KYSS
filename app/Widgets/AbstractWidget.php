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
    // Avoid multiple sets if there's user-defined configs.
    if (!array_has($config, 'permissions.view'))
      $this->config = array_add($this->config, 'permissions.view', config('widgets.permissions.view'));
    if (!array_has($config, 'style'))
      $this->config = array_add($this->config, 'style', config('widgets.style'));

    parent::__construct($config);
  }
}
