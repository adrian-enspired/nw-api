<?php

namespace NocWorx\Api;

use NocWorx\Api\ {
  Middleware\Authenticator,
  Middleware\RateLimiter
};

use Slim\App as Slim;

class Api extends Slim {

  public function __construct() {
    parent::__construct();
    $this->_initialize();
  }

  protected function _initialize() {
    // route groups

    // app middlewares
    $this->add(new Authenticator());
    $this->add(new RateLimiter());
  }
}
