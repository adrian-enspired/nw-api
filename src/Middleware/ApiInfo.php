<?php

namespace NocWorx\Api\Middleware;

use NocWorx\Api\Middleware;

class ApiInfo extends Middleware {

  /** {@inheritDoc} */
  public function process(Request $request, Handler $next) : Response {
    return $next->handle($request)
      ->withHeader('NocWorx-Api-Version', '1.0');
  }
}
