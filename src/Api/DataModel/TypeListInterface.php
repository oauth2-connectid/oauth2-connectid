<?php
/**
 * Created by PhpStorm.
 * User: esolitos
 * Date: 06/03/2018
 * Time: 16:51
 */

namespace ConnectId\Api\DataModel;


interface TypeListInterface extends \Countable, \Iterator {

  /**
   * @param array $list
   *
   * @return \ConnectId\Api\DataModel\TypeListInterface
   */
  public static function fromDataArray(array $list): TypeListInterface;
}
