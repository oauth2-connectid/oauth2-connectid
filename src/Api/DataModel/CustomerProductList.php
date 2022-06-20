<?php

namespace ConnectId\Api\DataModel;


/**
 * List of customer products.
 *
 * @see https://mediaconnect-api.redoc.ly/Production/tag/Product#paths/~1v1~1customer~1product/get
 */
class CustomerProductList extends BasicList {

  public static function fromDataArray(array $productList): CustomerProductList {
    $list = new static();
    foreach ($productList as $itemData) {
      $list->withProduct(CustomerProduct::create($itemData));
    }

    return $list;
  }

  /**
   * @param \ConnectId\Api\DataModel\CustomerProduct $product_type
   *
   * @return \ConnectId\Api\DataModel\CustomerProductList
   */
  public function withProduct(CustomerProduct $product_type): CustomerProductList {
    $this->items[] = $product_type;
    return $this;
  }
}
