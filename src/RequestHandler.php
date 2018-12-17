<?php

namespace NocWorx\Api;

use NocWorx\Api\Container;

use Psr\Http\ {
  Server\RequestHandlerInterface as Handler,
  Message\ResponseInterface as Response,
  Message\ServerRequestInterface as Request
};

/**
 * Adapts Slim's request callbacks to PSR-15 request handlers.
 *
 * Handler logic goes in the handle() method.
 * The response prototype is stored in $_response,
 * or can be retrieved from the container.
 * Route parameters (matched from the request URL)
 * are available by name from $request->getAttribute().
 */
abstract class RequestHandler implements Handler {

  /** @var Container NocWorx container. */
  protected $_container;

  /**
   * @param Container NocWorx container
   */
  public function __construct(Container $container) {
    $this->_container = $container;
  }

  /**
   * {@inheritDoc}
   * @see https://php.net/__invoke
   * @see https://www.slimframework.com/docs/v3/objects/router.html
   */
  public function __invoke(
    Request $request,
    Response $response,
    array $parameters
  ) : Response {
    $this->_response = $response;
    return $this->handle(
      $request->withAttributes($parameters + $request->getAttributes())
    );
  }

  /**
   * {@inheritDoc}
   * @see https://www.php-fig.org/psr/psr-15
   */
  abstract public function handle(Request $request) : Response;
}
