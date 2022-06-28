<?php

namespace ConnectId\Api\DataModel;


interface BasicTypeInterface {

  public function getId(): string;

  public function toArray(): array;
}
