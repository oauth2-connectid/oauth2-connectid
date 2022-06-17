<?php

namespace ConnectId\Api\DataModel;


class SubscriptionList extends BasicTypeList {

  public static function fromDataArray(array $subscriptionList): SubscriptionList {
    $list = new static();
    foreach ($productList as $itemData) {
      $list->withSubscription(
        Subscription::create($itemData)
      );
    }

    return $list;
  }

  public function withSubscription(Subscription $subscription): SubscriptionList {
    $this->appendWithoutValidation($subscription);
    return $this;
  }
}
