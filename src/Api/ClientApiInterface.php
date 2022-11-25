<?php

declare(strict_types=1);

namespace ConnectId\Api;

use ConnectId\Api\DataModel\CouponTypeList;
use ConnectId\Api\DataModel\OrderStatus;
use ConnectId\Api\DataModel\ProductType;
use ConnectId\Api\DataModel\ProductTypeList;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface ClientApiInterface {

  /**
   * Returns the access token valid for "client mode" requests.
   *
   * @return \League\OAuth2\Client\Token\AccessTokenInterface
   *  The access token.
   *
   * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
   *   In case of API errors.
   */
  public function getClientToken(): AccessTokenInterface;

  /**
   * Returns a list of coupons for a given product.
   *
   * @see https://doc.mediaconnect.no/doc/ConnectID/#tag/Coupon/paths/~1v1~1client~1coupon~1{productId}/get
   *
   * @param string $productCode
   *   Product identifier.
   *
   * @return \ConnectId\Api\DataModel\CouponTypeList
   *   The list of coupon info.
   */
  public function getCouponListForProduct(string $productCode): CouponTypeList;

  /**
   * Returns a list of coupons for a given product.
   *
   * @see https://mediaconnect-api.redoc.ly/Production/tag/Voucher-Coupons
   *
   * @param string $voucherCode
   *   Voucher identifier.
   *
   * @return \ConnectId\Api\DataModel\CouponTypeList
   *   The list of coupon info.
   */
  public function getCouponListForVoucher(string $productCode): CouponTypeList;

  /**
   * Returns basic "status" regarding an order.
   *
   * @see https://doc.mediaconnect.no/doc/ConnectID/v1/api/order.html#PaymentInfo
   * @see https://doc.mediaconnect.no/doc/ConnectID/#tag/Order/paths/~1v1~1client~1order~1status~1{orderId}/get
   *
   * @param string $orderId
   *   Order identifier.
   *
   * @return \ConnectId\Api\DataModel\OrderStatus
   *   The order status.
   */
  public function getOrderStatus(string $orderId): OrderStatus;

  /**
   * Fetches the info about a single product.
   *
   * @see https://doc.mediaconnect.no/doc/ConnectID/#tag/Product/paths/~1v1~1client~1product~1{productType}/get
   *
   * @param string $productId
   *   Product identifier.
   *
   * @return \ConnectId\Api\DataModel\ProductType|null
   *   The product info, when found.
   */
  public function getProductInfo(string $productId): ?ProductType;

  /**
   * Returns a list of products.
   *
   * @see https://doc.mediaconnect.no/doc/ConnectID/#tag/Product/paths/~1v1~1client~1product~1{productType}/get
   *
   * @return ProductTypeList
   *   List of product types.
   */
  public function getProductList(): ProductTypeList;
}

