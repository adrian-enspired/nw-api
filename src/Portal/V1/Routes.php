<?php

namespace NocWorx\Api\Portal\V1;

use NocWorx\Api\ {
  Api,
  Portal\V1\Authentication\Routes as Authentication,
  Portal\V1\Invoice\Routes as Invoices,
  Routes as RouteGroup
};

/**
 * Top-level routing group for version 1 portal.
 */
class Routes extends RouteGroup {

  /** {@inheritDoc} */
  protected const _CHILD_GROUPS = [
    Authentication::class,
    Invoices::class
  ];

  /** {@inheritDoc} */
  protected const _GROUP = '/v1';

  /** {@inheritDoc} */
  protected const _MIDDLEWARES = [];

  /** {@inheritDoc} */
  protected const _ROUTES = [];
}
