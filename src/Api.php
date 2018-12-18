<?php

namespace NocWorx\Api;

use NocWorx\Api\ {
  Container,
  Middleware\ApiInfo,
  Middleware\Authenticator,
  Middleware\RateLimiter,
  Portal\V1\Routes as Portal,
  RequestHandler,
  RouteGroup
};

use NocWorx\App as NocWorx;

use NocWorx\Lib\App\Registry;

use Slim\App as Slim;

/**
 * NocWorx Api application.
 *
 * @example
 * ```php
 *  $api = new Api(new NocWorx(NocWorx::ENTRY_POINT_EXTRANET));
 *  $api->run();
 * ```
 */
class Api extends Slim {

  /** @var array[] Map of entry point:[top level routegroups]. */
  protected const _ENTRY_GROUPS_MAP = [
    // @todo Admin not yet supported.
    //NocWorx::ENTRY_POINT_ADMIN => [Admin::class],
    NocWorx::ENTRY_POINT_EXTRANET => [Portal::class]
  ];

  protected $_Nw;

  /**
   * {@inheritDoc}
   * @param NocWorx $nw The NocWorx core application instance
   * @param array $settings
   */
  public function __construct(NocWorx $nw, array $settings = []) {
    $this->_Nw = $nw;
    parent::__construct($this->_configure($settings));
    $this->_initialize();
  }

  /**
   * Adds default configuration to settings and creates container.
   *
   * @param array $settings Map of name:value pairs to set on container
   * @return Container
   */
  protected function _configure(array $settings) : Container {
    return new Container($this->_Nw, $settings);
  }

  /**
   * Registers route groups and middleware for the given entry point.
   */
  protected function _initialize() : void {
    // boot nocworx
    Registry::setApp($this->_Nw)->boot();

    // route groups
    $route_groups = static::_ENTRY_GROUP_MAP[$this->_Nw->getEntryPoint()] ??
      [];
    foreach ($route_groups as $route_group) {
      assert($route_group instanceof RouteGroup);
      (new $route_group($this))->register();
    }

    // app middlewares
    $this->add(new ApiInfo($this->getContainer()));
    $this->add(new Authenticator($this->getContainer()));
    $this->add(new RateLimiter($this->getContainer()));
  }
}
