<?php

namespace NocWorx\Api\Http;

use NocWorx\Api\RequestHandler;

use Psr\Http\ {
  Message\ResponseInterface as Response,
  Message\ServerRequestInterface as Request
};

use Slim\Http\StatusCode;

class NotImplemented extends RequestHandler {

  /** {@inheritDoc} */
  public function handle(Request $request) : Response {
    return $this->_response->withStatus(StatusCode::HTTP_NOT_IMPLEMENTED);
  }
}
