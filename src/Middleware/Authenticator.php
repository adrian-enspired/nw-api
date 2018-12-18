<?php

namespace NocWorx\Api\Middleware;

use NocWorx\Api\Middleware;

class Authenticator extends Middleware {

  /** {@inheritDoc} */
  public function process(Request $request, Handler $next) : Response {
    // @todo read api token and set user on request
    return $next->handle($request);
  }
}
