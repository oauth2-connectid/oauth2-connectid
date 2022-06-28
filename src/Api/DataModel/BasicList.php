<?php

namespace ConnectId\Api\DataModel;


abstract class BasicList implements \Countable, \Iterator  {

  protected array $items = [];

  public function count() {
    return count($this->items);
  }

  public function current() {
    return current($this->items);
  }

  public function next() {
    return next($this->items);
  }

  public function key() {
    return key($this->items);
  }

  public function valid():bool {
    return isset($this->items[$this->key()]);
  }

  public function rewind() {
    return reset($this->items);
  }

  public function toArray(): array {
    $list = [];
    foreach ($this->items as $value) {
      if (method_exists($value, 'toArray')) {
        $list[] = $value->toArray();
      }
      else {
        $list[] = serialize($value);
      }
    }

    return $list;
  }
}
