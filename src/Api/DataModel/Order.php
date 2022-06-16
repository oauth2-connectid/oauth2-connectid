<?php

namespace ConnectId\Api\DataModel;

class Order extends BasicData {

  /** @var string Paying by using a credit card via Nets */
  const PAYMENT_TYPE_CARD = 'creditcard';
  /** @var string Paying by sending a invoice */
  const PAYMENT_TYPE_INVOICE = 'invoice';
  /** @var string It is free of cost*/
  const PAYMENT_TYPE_FREE = 'free';
  /** @var string Paying by using SMS via Link Mobility */
  const PAYMENT_TYPE_SMS = 'sms';
  /** @var string Paying by using SMS via SMSpay */
  const PAYMENT_TYPE_SMSPAY = 'smsPay';
  /** @var string Paying by using Vipps (Faste betalinger med Vipps)*/
  const PAYMENT_TYPE_VIPPS = 'vippsRecurring';
  /** @var string Paying by using Klarna Checkout */
  const PAYMENT_TYPE_KLARNA = 'kco';
  /** @var string Paying by using a digital wallet provided by Mastercard. */
  const PAYMENT_TYPE_PASS = 'masterpass';
  /** @var string Paying by using own integration with payment provider */
  const PAYMENT_TYPE_OTHER = 'other';


  /**
   * @var int
   */
  protected $orderId;

  /**
   * @var string
   */
  protected $externalOrderId;

  /**
   * @var \DateTimeImmutable
   */
  protected $orderDate;

  /**
   * @var string
   */
  protected $paymentMethod;

  /**
   * @var float
   */
  protected $orderAmount;

  /**
   * @var string
   */
  protected $currency;

  /**
   * @var string
   */
  protected $marketingCouponCode;

  /**
   * @var int
   */
  protected $marketingCouponNumber;

  /**
   * @var string
   */
  protected $companyCode;

  /**
   * @var string
   */
  protected $customerReference;

  /**
   * @var \ConnectId\Api\DataModel\Address
   */
  protected $payer;

  /**
   * @var \ConnectId\Api\DataModel\OrderLineList
   */
  protected $orderLines;

  /**
   * @var bool
   */
  protected $prepaid;

  /**
   * @var \ConnectId\Api\DataModel\PaymentInfo
   */
  protected $paymentInfo;

  /**
   * @return int
   */
  public function getOrderId(): ?int {
    return $this->orderId;
  }

  /**
   * @param int $orderId
   *
   * @return Order
   */
  public function withOrderId(int $orderId): Order {
    $this->orderId = $orderId;
    return $this;
  }

  /**
   * @return string
   */
  public function getExternalOrderId(): string {
    return $this->externalOrderId;
  }

  /**
   * @param string $externalOrderId
   *
   * @return Order
   */
  public function withExternalOrderId(string $externalOrderId): Order {
    $this->externalOrderId = $externalOrderId;
    return $this;
  }

  /**
   * @return \DateTimeImmutable
   */
  public function getOrderDate(): \DateTimeImmutable {
    return $this->orderDate;
  }

  /**
   * @param \DateTimeImmutable $orderDate
   *
   * @return Order
   */
  public function withOrderDate(\DateTimeImmutable $orderDate): Order {
    $this->orderDate = $orderDate;
    return $this;
  }

  /**
   * @return string
   */
  public function getPaymentMethod(): string {
    return $this->paymentMethod;
  }

  /**
   * @param string $paymentMethod
   *
   * @return Order
   */
  public function withPaymentMethod(string $paymentMethod): Order {
    $this->paymentMethod = $paymentMethod;
    return $this;
  }

  /**
   * @return float
   */
  public function getOrderAmount(): float {
    return $this->orderAmount;
  }

  /**
   * @param float $orderAmount
   *
   * @return Order
   */
  public function withOrderAmount(float $orderAmount): Order {
    $this->orderAmount = $orderAmount;
    return $this;
  }

  /**
   * @return string
   */
  public function getCurrency(): string {
    return $this->currency;
  }

  /**
   * @param string $currency
   *
   * @return Order
   */
  public function withCurrency(string $currency): Order {
    $this->currency = $currency;
    return $this;
  }

  /**
   * @return string
   */
  public function getMarketingCouponCode(): string {
    return $this->marketingCouponCode;
  }

  /**
   * @param string $marketingCouponCode
   *
   * @return Order
   */
  public function withMarketingCouponCode(string $marketingCouponCode): Order {
    $this->marketingCouponCode = $marketingCouponCode;
    return $this;
  }

  /**
   * @return int
   */
  public function getMarketingCouponNumber(): int {
    return $this->marketingCouponNumber;
  }

  /**
   * @param int $marketingCouponNumber
   *
   * @return Order
   */
  public function withMarketingCouponNumber(int $marketingCouponNumber): Order {
    $this->marketingCouponNumber = $marketingCouponNumber;
    return $this;
  }

  /**
   * @return string
   */
  public function getCompanyCode(): string {
    return $this->companyCode;
  }

  /**
   * @param string $companyCode
   *
   * @return Order
   */
  public function withCompanyCode(string $companyCode): Order {
    $this->companyCode = $companyCode;
    return $this;
  }

  /**
   * @return string
   */
  public function getCustomerReference(): string {
    return $this->customerReference;
  }

  /**
   * @param string $customerReference
   *
   * @return Order
   */
  public function withCustomerReference(string $customerReference): Order {
    $this->customerReference = $customerReference;
    return $this;
  }

  /**
   * @return \ConnectId\Api\DataModel\Address
   */
  public function getPayer(): \ConnectId\Api\DataModel\Address {
    return $this->payer;
  }

  /**
   * @param \ConnectId\Api\DataModel\Address $payer
   *
   * @return Order
   */
  public function withPayer(\ConnectId\Api\DataModel\Address $payer): Order {
    $this->payer = $payer;
    return $this;
  }

  /**
   * @return \ConnectId\Api\DataModel\OrderLineList
   */
  public function getOrderLines(): \ConnectId\Api\DataModel\OrderLineList {
    return $this->orderLines;
  }


  /**
   * @param \ConnectId\Api\DataModel\OrderLineList $orderLines
   *
   * @return Order
   */
  public function withOrderLine(\ConnectId\Api\DataModel\OrderLine $orderLine): Order {
    if (empty($this->orderLines)) {
      $this->orderLines = new OrderLineList();
    }
    $this->orderLines->append($orderLine);
    return $this;
  }

  /**
   * @param \ConnectId\Api\DataModel\OrderLineList $orderLines
   *
   * @return Order
   */
  public function withOrderLines(\ConnectId\Api\DataModel\OrderLineList $orderLines): Order {
    $this->orderLines = $orderLines;
    return $this;
  }

  /**
   * @return bool
   */
  public function isPrepaid(): bool {
    return $this->prepaid;
  }

  /**
   * @see self::setPrepaid()
   *
   * @return \ConnectId\Api\DataModel\Order
   */
  public function withPrepaid(bool $prepaid): Order {
    $this->setPrepaid($prepaid);
    return $this;
  }

  /**
   * @param bool $prepaid
   *
   * @return Order
   */
  public function setPrepaid(bool $prepaid) {
    $this->prepaid = $prepaid;
  }

  /**
   * @return \ConnectId\Api\DataModel\PaymentInfo
   */
  public function getPaymentInfo(): \ConnectId\Api\DataModel\PaymentInfo {
    return $this->paymentInfo;
  }

  /**
   * @param \ConnectId\Api\DataModel\PaymentInfo $paymentInfo
   *
   * @return Order
   */
  public function withPaymentInfo(\ConnectId\Api\DataModel\PaymentInfo $paymentInfo): Order {
    $this->paymentInfo = $paymentInfo;
    return $this;
  }

  /**
   * @return string
   */
  public function toJson(): string {
    $data = $this->toArray();

    // Override date fields
    $data['orderDate'] = $this->getFormattedDate($this->orderDate);

    return json_encode($data);
  }
}
