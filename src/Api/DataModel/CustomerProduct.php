<?php

namespace ConnectId\Api\DataModel;

/**
 * Customer product access.
 *
 * @see https://mediaconnect-api.redoc.ly/Production/tag/Product#paths/~1v1~1customer~1product/get
 */
class CustomerProduct extends BasicData {

  /**
   * @see \ConnectId\Api\DataModel\CustomerProduct::$accessType
   */
  public const ACCESS_UNLIMITED = 'A';

  /**
   * @see \ConnectId\Api\DataModel\CustomerProduct::$accessType
   */
  public const ACCESS_PERIOD = 'B';

  /**
   * @see \ConnectId\Api\DataModel\CustomerProduct::$accessType
   */
  public const ACCESS_NONE = 'C';

  /**
   * The partner id the product below belongs to.
   *
   * @var string
   */
  protected string $partnerId;

  /**
   * The product id. A unique code for the product.
   *
   * @var string
   */
  protected string $productId;

  /**
   * The product id. A unique code for the product.
   *
   * A: The user is active and has access to everything
   * B: The user has been active and have access to everything
   * between startTime and endTime
   * D: The user has no access
   *
   * @see \ConnectId\Api\DataModel\CustomerProduct::ACCESS_UNLIMITED
   * @see \ConnectId\Api\DataModel\CustomerProduct::ACCESS_PERIOD
   * @see \ConnectId\Api\DataModel\CustomerProduct::ACCESS_NONE
   *
   * @var string
   */
  protected string $accessType;

  /**
   * Start of the current access period.
   *
   * For subscriptions, startTime is 00:00:00 on the subscription start date.
   * If the user continues to pay for the subscription then startTime does not
   * change. If the user stops paying for the subscription and later starts a new
   * subscription on the same product (and some time has passed during which the
   * user did not pay) then startTime will be 00:00:00 on the new start date.
   *
   * This value is only returned for accessType B.
   *
   * @see \ConnectId\Api\DataModel\CustomerProduct::ACCESS_PERIOD
   *
   * @var \DateTimeImmutable|null
   */
  protected ?\DateTimeImmutable $startTime = NULL;


  /**
   * End of the current access period.
   *
   * For subscriptions, endTime is 23:59:59 on the last date that the user has
   * paid for or 23:59:59 on the publication date of the last issue that the user
   * has received if that is a later date (relevant for free subscriptions).
   *
   * This value is only returned for accessType B.
   *
   * @see \ConnectId\Api\DataModel\CustomerProduct::ACCESS_PERIOD
   *
   * @var \DateTimeImmutable|null
   */
  protected ?\DateTimeImmutable $endTime = NULL;

  /**
   * @return string
   */
  public function getPartnerId(): ?string {
    return $this->partnerId ?? NULL;
  }

  /**
   * @param string $partnerId
   *
   * @return CustomerProduct
   */
  public function withPartnerId(string $partnerId): CustomerProduct {
    $this->partnerId = $partnerId;
    return $this;
  }

  /**
   * @return string
   */
  public function getProductId(): string {
    return $this->productId;
  }

  /**
   * @param string $productId
   *
   * @return CustomerProduct
   */
  public function withProductId(string $productId): CustomerProduct {
    $this->productId = $productId;
    return $this;
  }

  /**
   * @return string
   */
  public function getAccessType(): string {
    return $this->accessType;
  }

  /**
   * @param string $accessType
   *
   * @return CustomerProduct
   */
  public function withAccessType(string $accessType): CustomerProduct {
    $allowed_access_types = [
      self::ACCESS_UNLIMITED,
      self::ACCESS_PERIOD,
      self::ACCESS_NONE,
    ];
    if (!in_array($accessType, $allowed_access_types)) {
      throw new \InvalidArgumentException("Access type $accessType is not an acceptable value.");
    }

    $this->accessType = $accessType;
    return $this;
  }

  /**
   * Checks if the granted access is time-limited.
   *
   * @return bool|null
   *   True if access_type is "B", false otherwise. NULL if not access_type is not defined.
   */
  public function isAccessTimeLimited(): ?bool {
    if ($this->getAccessType() === self::ACCESS_PERIOD) {
      return TRUE;
    }
    if ($this->getAccessType() === NULL) {
      return NULL;
    }

    return FALSE;
  }

  /**
   * Returns the "start time" of a subscription.
   *
   * @return \DateTimeImmutable|null
   *   Start time or NULL in case of non-time-limited access.
   */
  public function getStartTime(): ?\DateTimeImmutable {
    if (!$this->isAccessTimeLimited()) {
      return NULL;
    }
    return $this->startTime;
  }

  /**
   * @param \DateTimeImmutable|null $startTime
   *
   * @return CustomerProduct
   */
  public function withStartTime(?\DateTimeImmutable $startTime): CustomerProduct {
    $this->startTime = $startTime;
    return $this;
  }

  /**
   * Returns the "end time" of a subscription.
   *
   * @return \DateTimeImmutable|null
   *   End time or NULL in case of non-time-limited access.
   */
  public function getEndTime(): ?\DateTimeImmutable {
    if (!$this->isAccessTimeLimited()) {
      return NULL;
    }

    return $this->endTime;
  }

  /**
   * @param \DateTimeImmutable|null $endTime
   *
   * @return CustomerProduct
   */
  public function withEndTime(?\DateTimeImmutable $endTime): CustomerProduct {
    $this->endTime = $endTime;
    return $this;
  }

  /**
   * Checks if the product is currently valid.
   *
   * @return bool
   *   True for access, false if not.
   */
  public function isValidAccess(): bool {
    if ($this->getAccessType() === self::ACCESS_UNLIMITED) {
      return TRUE;
    }
    if ($this->getAccessType() === self::ACCESS_NONE) {
      return FALSE;
    }
    if ($this->getAccessType() === self::ACCESS_PERIOD) {
      $start = $this->getStartTime();
      $end = $this->getEndTime();
      $now =  new \DateTimeImmutable();
      $end_of_day = new \DateTimeImmutable('tomorrow');
      // Validate the validity of the access
      if (
        ($start !== NULL && $start->diff($now)->format('r') === '-') &&
        ($end !== NULL && $end_of_day->diff($end)->format('r') === 'r')) {
        return TRUE;
      }
    }

    // Fallback.
    return FALSE;
  }
}
