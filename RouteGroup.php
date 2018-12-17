<?php

namespace NocWorx\Api;

use NocWorx\Api\ {
  Api,
  Http\NotImplemented
};

interface RouteGroup {

  /**
   * Tuple keys for items in a route definition (@see RouteGroup::routes()).
   *
   * @var int ROUTE_METHODS List of HTTP verbs mapped to route
   * @var int ROUTE_PATTERN Pattern route is matched against
   * @var int ROUTE_HANDLER Route handler FQCN
   * @var int ROUTE_MIDDLEWARES List of middleware FQCNs
   */
  public const ROUTE_METHODS = 0;
  public const ROUTE_PATTERN = 1;
  public const ROUTE_HANDLER = 2;
  public const ROUTE_MIDDLEWARES = 3;

  /**
   * Lists this Group's child Groups.
   *
   * @return iterable<RouteGroup>
   */
  public function childGroups() : iterable;

  /**
   * Registers routes, child routing groups, and group-level middleware.
   */
  public function register() : void;

  /**
   * Lists definitions for this Group's routes.
   *
   * Each definition is a tuple (an array), like:
   *  - string[]        0 (required): List of HTTP verb(s) to use
   *  - string          1 (required): URI pattern to match against
   *  - callable|string 2 (optional): Request handler (501 if omitted)
   *  - callable|string 3 (optional): List of middleware (empty if omitted)
   *
   * @example
   * ```php
   *  [
   *    ['GET'],                      // ROUTE_METHODS
   *    '/example/route-definition',  // ROUTE_PATTERN
   *    ExampleHandler::class,        // ROUTE_HANDLER
   *    [                             // ROUTE_MIDDLEWARES
   *      ExampleMiddlewareA::class,
   *      ExampleMiddlewareB::class
   *    ]
   *  ];
   * ```
   *
   * @return iterable<array>
   */
  public function routes() : iterable;
}
