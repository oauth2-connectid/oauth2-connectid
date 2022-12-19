<?php

namespace ConnectId\Api\DataModel;


abstract class BasicTypeList extends BasicList {

  /**
   * @var array
   */
  protected $listOfTypes;

  public function __construct() {
    $this->listOfTypes = [];
  }

  protected function appendWithoutValidation($value): void {
    $this->listOfTypes[] = $value;
  }

  public function count(): int {
    return count($this->listOfTypes);
  }

  public function current(): BasicTypeInterface {
    return current($this->listOfTypes);
  }

  public function key(): mixed {
    return key($this->listOfTypes);
  }

  public function next(): void {
    next($this->listOfTypes);
  }

  public function rewind(): void {
    reset($this->listOfTypes);
  }

  public function valid() :bool {
    return isset($this->listOfTypes[$this->key()]);
  }
}
