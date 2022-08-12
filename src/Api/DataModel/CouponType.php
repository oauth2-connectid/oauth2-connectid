<?php

namespace ConnectId\Api\DataModel;


class CouponType extends BasicType {

  use StartEndTimeTrait;

  /**
   * @var string
   */
  protected $couponCode;

  /**
   * @var int
   */
  protected $couponNumber;

  /**
   * @var string
   */
  protected $description;

  /**
   * @var float
   */
  protected $couponPrice;

  /**
   * @var array
   */
  protected $extraProducts;

  /**
   * @var int
   */
  protected $periodLength;

  /**
   * @var string
   */
  protected $periodType;

  /**
   * @inheritdoc
   */
  public function getId(): string {
    return $this->getCouponCode() . ':' . $this->getCouponNumber();
  }

  /**
   * @return string
   */
  public function getCouponCode(): string {
    return $this->couponCode;
  }

  /**
   * @param string $couponCode
   *
   * @return CouponType
   */
  public function withCouponCode(string $couponCode): CouponType {
    $this->couponCode = $couponCode;
    return $this;
  }

  /**
   * @return int
   */
  public function getCouponNumber(): int {
    return $this->couponNumber;
  }

  /**
   * @param int $couponNumber
   *
   * @return CouponType
   */
  public function withCouponNumber(int $couponNumber): CouponType {
    $this->couponNumber = $couponNumber;
    return $this;
  }

  /**
   * @return string
   */
  public function getDescription(): ?string {
    return $this->description;
  }

  /**
   * @param string $description
   *
   * @return CouponType
   */
  public function withDescription(?string $description): CouponType {
    $this->description = $description;
    return $this;
  }

  /**
   * @return float
   */
  public function getCouponPrice(): ?float {
    return $this->couponPrice;
  }

  /**
   * @param float $couponPrice
   *
   * @return CouponType
   */
  public function withCouponPrice(float $couponPrice): CouponType {
    if (is_numeric($couponPrice)) {
      $this->couponPrice = $couponPrice;
    }
    elseif (!empty($couponPrice)) {
      throw new \InvalidArgumentException("Invalid numeric value: " . $couponPrice);
    }
    return $this;
  }

  /**
   * @return array
   */
  public function getExtraProducts(): array {
    return $this->extraProducts;
  }

  /**
   * @param array $extraProducts
   *
   * @return CouponType
   */
  public function withExtraProducts(array $extraProducts): CouponType {
    $this->extraProducts = $extraProducts;
    return $this;
  }

  /**
   * @return int
   */
  public function getPeriodLength(): ?int {
    return $this->periodLength;
  }


  /**
   * @param int $periodLength
   *
   * @return CouponType
   */
  public function withPeriodLength(int $periodLength): CouponType {
    $this->periodLength = $periodLength;
    return $this;
  }


  /**
   * @return string
   */
  public function getPeriodType(): ?string {
    return $this->periodType;
  }


  /**
   * @param string $periodType
   *
   * @return CouponType
   */
  public function withPeriodType(string $periodType): CouponType {
    $this->periodType = $periodType;
    return $this;
  }


}
