<?php

namespace NocWorx\Api;

use NocWorx\Api\ {
  Api,
  Http\NotImplemented
};

abstract class Routes implements RouteGroup {

  /** @var RouteGroup[] Routing groups to set up as child groups. */
  protected const _CHILD_GROUPS = [];

  /** @var string Group routing prefix pattern. */
  protected const _GROUP = '';

  /** @var callable[] List of Middlewares for this group. */
  protected const _MIDDLEWARES = [];

  /** @var array List of route definitions (@see RouteGroup::routes()). */
  protected const _ROUTES = [];

  /**
   * @param Api $api The NocWorx Api
   */
  public function __construct(Api $api) {
    $this->_api = $api;
  }

  /** {@inheritDoc} */
  public function childGroups() : iterable {
    foreach (static::_CHILD_GROUPS as $child) {
      yield $child;
    }
  }

  /** {@inheritDoc} */
  public function register() {
    $routes = $this;
    $group = $this->_app->group(static::_GROUP, function () use ($routes) {
      $routes->_registerRoutes();
      $routes->_registerGroups();
    });
    foreach (static::_MIDDLEWARES as $middleware) {
      $group->add($middleware);
    }
  }

  /** {@inheritDoc} */
  public function routes() : iterable {
    foreach (static::_ROUTES as $route) {
      yield $route + [
        RouteGroup::ROUTE_HANDLER => NotImplemented::class,
        RouteGroup::ROUTE_MIDDLEWARE => []
      ];
    }
  }

  /**
   * Registers child route groups.
   */
  protected function _registerGroups() : void {
    foreach ($this->_childGroups() as [$child, ]) {
      $this->_api->group();
    }
  }

  /**
   * Registers individual routes.
   */
  protected function _registerRoutes() : void {
    foreach ($this->_routes as [$methods, $pattern, $handler, $middles]) {
      $route = $this->_api->map($methods, $pattern, $handler)
        ->setName($handler::NAME);
      foreach ($middles as $middleware) {
        $route->add($middleware);
      }
    }
  }
}
