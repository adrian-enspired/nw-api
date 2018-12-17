<?php

namespace NocWorx\Api;

use NocWorx\App as NocWorx;

use Slim\Container as SlimContainer;

/**
 * NocWorx-aware Slim Container.
 */
class Container extends SlimContainer {

  /**
   * @param NocWorx $nocworx The NocWorx application instance
   * @param array $values Map of name:value pairs to set on the container
   */
  public function __construct(NocWorx $nw, array $values = []) {
    $this->_Nw = $nw;
    parent::__construct($values);
  }

  /**
   * Gets the NocWorx application instance.
   *
   * @return NocWorx
   */
  public function NocWorx() : NocWorx {
    return $this->_Nw;
  }
}
