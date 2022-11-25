<?php

declare(strict_types=1);

namespace ConnectId\Api;

use ConnectId\Api\DataModel\CouponTypeList;
use ConnectId\Api\DataModel\OrderStatus;
use ConnectId\Api\DataModel\ProductType;
use ConnectId\Api\DataModel\ProductTypeList;
use ConnectId\OAuth2\Client\Provider\ConnectId;
use ConnectId\OAuth2\Client\Provider\Endpoints;
use League\OAuth2\Client\Token\AccessTokenInterface;
use UnexpectedValueException;

class ClientApi extends ConnectId implements ClientApiInterface {

  /**
   * The ConnectID Client access token.
   *
   * This cached to prevent new token on each request.
   *
   * @var \League\OAuth2\Client\Token\AccessTokenInterface
   */
  protected AccessTokenInterface $clientAccessToken;

  /**
   * @inheritDoc
   */
  public function getClientToken(): AccessTokenInterface {
    // Request a new token if we have an expired token or if we don't have one.
    if (!isset($this->clientAccessToken) || $this->clientAccessToken->hasExpired()) {
      $this->clientAccessToken = $this->requestNewClientCredentialsAccessToken();
    }

    return $this->clientAccessToken;
  }

  /**
   * Requests a new access token granting "client_credentials".
   *
   * @return \League\OAuth2\Client\Token\AccessTokenInterface
   * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
   */
  protected function requestNewClientCredentialsAccessToken(): AccessTokenInterface {
    return $this->getAccessToken('client_credentials');
  }

  /**
   * @inheritDoc
   */
  public function getCouponListForProduct(string $productCode): CouponTypeList {
    $url = Endpoints::getApiUrl('v1/client/coupon/' . $productCode, $this->testing);
    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $this->getClientToken());
    $response = $this->getParsedResponse($request);

    if (!is_array($response) || !isset($response['coupons'])) {
      throw new UnexpectedValueException(
        'Invalid response received from API Server. Expected json with a "products" key.'
      );
    }

    return CouponTypeList::fromDataArray($response['coupons']);
  }

  /**
   * @inheritDoc
   */
  public function getCouponListForVoucher(string $voucherCode): CouponTypeList {
    $url = Endpoints::getApiUrl('v1/client/voucher/coupons/' . $voucherCode, $this->testing);
    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $this->getClientToken());
    $response = $this->getParsedResponse($request);
    
    if (!is_array($response) || !isset($response['coupons'])) {
      throw new UnexpectedValueException(
        'Invalid response received from API Server. Expected json with a "products" key.'
      );
    }
    return CouponTypeList::fromDataArray($response['coupons']);
  }

  /**
   * @inheritDoc
   */
  public function getOrderStatus(string $orderId): OrderStatus {
    $url = Endpoints::getApiUrl('v1/client/order/status/' . $orderId, $this->testing);
    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $this->getClientToken())
      ->withAddedHeader('Content-Type', 'application/json');
    $response = $this->getParsedResponse($request);

    if (FALSE === is_array($response) || !isset($response['orders'])) {
      throw new UnexpectedValueException(
        'Invalid response received from Authorization Server. Expected JSON.'
      );
    }

    // Always one order will be returned.
    $order_data = reset($response['orders']);

    return OrderStatus::create($order_data);
  }

  /**
   * @inheritDoc
   */
  public function getProductInfo(string $productId): ?ProductType {
    $url = Endpoints::getApiUrl('v1/client/product', $this->testing);
    $url = $url . '?' . http_build_query(['productId' => $productId]);

    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $this->getClientToken());
    $response = $this->getParsedResponse($request);

    if (!is_array($response) || !isset($response['products'])) {
      throw new UnexpectedValueException(
        'Invalid response received from API Server. Expected json with a "products" key.'
      );
    }

    return count($response['products']) ? ProductType::create(array_pop($response['products'])) : NULL;
  }

  /**
   * @inheritDoc
   */
  public function getProductList(): ProductTypeList {
    $url = Endpoints::getApiUrl('v1/client/product', $this->testing);
    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $this->getClientToken());
    $response = $this->getParsedResponse($request);

    if (!is_array($response) || !isset($response['products'])) {
      throw new UnexpectedValueException(
        'Invalid response received from API Server. Expected json with a "products" key.'
      );
    }

    return ProductTypeList::fromDataArray($response['products']);
  }

}
