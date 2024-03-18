<?php

namespace ConnectId\Api\DataModel;


class SubscriptionList extends BasicList {

  public static function fromDataArray(array $subscriptionList): SubscriptionList {
    $list = new static();
    foreach ($subscriptionList as $itemData) {
      $list->withSubscription(
        Subscription::create($itemData)
      );
    }

    return $list;
  }

  public function withSubscription(Subscription $subscription): SubscriptionList {
    $this->items[] = $subscription;
    return $this;
  }
}
