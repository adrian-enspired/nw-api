<?php

namespace NocWorx\Api;

use NocWorx\Api\Container;

use Psr\Http\ {
  Server\MiddlewareInterface as PsrMiddleware,
  Message\ResponseInterface as Response,
  Message\ServerRequestInterface as Request
};

/**
 * Adapts Slim's double-pass middleware invocations to PSR-15 middleware.
 *
 * Middleware logic goes in the process() method.
 * The implementing class can create a response directly,
 * using the prototype from the container,
 * or delegate to the next middleware by calling $next->handle($request).
 */
abstract class Middleware implements PsrMiddleware {

  /** @var Container NocWorx container.*/
  protected $_container;

  /**
   * @param Container $container NocWorx container
   */
  public function __construct(Container $container) {
    $this->_container = $container;
  }

  /**
   * {@inheritDoc}
   * @see https://php.net/__invoke
   * @see https://www.slimframework.com/docs/v3/concepts/middleware.html
   */
  public function __invoke(
    Request $request,
    Response $response,
    callable $next
  ) : Response {
    $next = new class($next, $response) extends Handler {

      protected $_next;

      public function __construct(callable $next, Response $response) {
        $this->_next = $next;
        $this->_response = $response;
      }

      public function handle(Request $request) : Response {
        return ($this->_next)($request, $this->_response);
      }
    };

    return $this->process($request, $next);
  }

  /**
   * {@inheritDoc}
   * @see https://www.php-fig.org/psr/psr-15
   */
  abstract public function process(Request $request, Handler $next) : Response;
}
