<?php

namespace NocWorx\Api\Middleware;

use NocWorx\Api\Middleware;

class RateLimiter extends Middleware {

  /** {@inheritDoc} */
  public function process(Request $request, Handler $next) : Response {
    // @todo implement rate limiting
    return $next->handle($request);
  }
}
