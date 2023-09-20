<?php

namespace ConnectId\Api\DataModel;

/**
 * This reflects the Subscriptions from the API.
 *
 * @see https://mediaconnect-api.redoc.ly/Production/tag/Subscription
 */
class Subscription extends BasicData {

  /**
   * The product id- A unique id for the product.
   *
   * @var string
   */
  protected string $product;

  /**
   * Informs if the subscription is stopped.
   *
   * @var bool
   */
  protected bool $stopped;

  /**
   * Start of the current subscription period.
   *
   * startTime is 00:00:00 on the subscription start date.
   * If the user continues to pay for the subscription then startTime does not change.
   * If the user stops paying for the subscription and later starts a new subscription on the same product (and some time
   * has passed during which the user did not pay) then startTime will be 00:00:00 on the new start date.
   *
   * @var int
   */
  protected int $startTime;

  /**
   * End of the current subscription period.
   *
   * endTime is 23:59:59 on the last date that the user has paid for or 23:59:59 on the publication date of the last issue
   * that the user has received if that is a later date (relevant for free subscriptions).
   *
   * @var int
   */
  protected int $endTime;

  /**
   * Informs if the subscription period is paid.
   *
   * @var bool
   */
  protected bool $paid;

  /**
   * @var array
   */
  protected array $priceDetails;

  /**
   * Informs if the subscription can be shared.
   *
   * @var bool
   */
  protected bool $sharable;

  /**
   * Specifies share type when subscription can be shared.
   *
   * USERS: Shareable with users
   * NETS: Shareable nets (per domain, IP range)
   * B2B: B2B shareable
   *
   * @var string|null
   */
  protected $shareType;

  /**
   * The sales person identifier on this subscription.
   *
   * @var string|null
   */
  protected $salesPerson;

  /**
   * Distribution level. Mainly important for B2B source(received) subscription.
   * Based on this value you can resolve whether it is paper distribution or not.
   *
   * @var string|null
   */
  protected string $distributionLevel;

  /**
   * The unique id for productdeliveryplan
   *
   * @var int|null
   */
  protected $productDeliveryPlanId;

  /**
   * @return string
   */
  public function getProduct(): string {
    return $this->product;
  }

  /**
   * @return bool
   */
  public function isStopped(): bool {
    return $this->stopped;
  }

}
