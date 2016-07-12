<?php
/**
 * KYSS Event Service Provider file.
 *
 * @package KYSS\Providers
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Providers;

use KYSS\Models\User;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Event Service Provider.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 0.1.0
 */
class EventServiceProvider extends ServiceProvider {
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    'KYSS\Events\SomeEvent' => [
      'KYSS\Listeners\EventListener',
    ],
  ];

  /**
   * Register any other events for your application.
   *
   * @param  \Illuminate\Contracts\Events\Dispatcher  $events
   * @return void
   */
  public function boot(DispatcherContract $events) {
    parent::boot($events);
  }
}
