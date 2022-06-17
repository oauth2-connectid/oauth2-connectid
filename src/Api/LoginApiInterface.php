<?php

declare(strict_types=1);

namespace ConnectId\Api;


use ConnectId\Api\DataModel\Order;
use ConnectId\Api\DataModel\SubscriptionList;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface LoginApiInterface {

  /**
   * Builds a URL to redirect the user to fulfill and order.
   *
   * @see https://mediaconnect-api.redoc.ly/Production/#section/About-the-URLs/URL:-fulfillment
   *
   * @param  string  $orderId
   * @param  string  $returnUrl
   * @param  string  $errorUrl
   *
   * @return string
   */
  public function getOrderFulfillmentUrl(string $orderId, string $returnUrl, string $errorUrl): string;

  /**
   * Returns a list of all products a user has access to.
   *
   * @see https://doc.mediaconnect.no/doc/ConnectID/v1/api/customer/product.html#Product_API
   * @see https://doc.mediaconnect.no/doc/ConnectID/#tag/Product/paths/~1v1~1customer~1product/get
   *
   * @param  \League\OAuth2\Client\Token\AccessTokenInterface  $accessToken
   *   Access token to identify the user.
   *
   * @return array
   */
  public function getApiCustomerProduct(AccessTokenInterface $accessToken): array;

  /**
   * Lists the user's active subscriptions.
   *
   * @see https://mediaconnect-api.redoc.ly/Production/tag/Subscription#paths/~1v1~1subscription/get
   *
   * @param  \League\OAuth2\Client\Token\AccessTokenInterface  $accessToken
   *   Access token to identify the user.
   *
   * @return \ConnectId\Api\DataModel\SubscriptionList
   */
  public function getSubscriptionList(AccessTokenInterface $accessToken): SubscriptionList;

  /**
   * Creates an order in ConnectId systems.
   *
   * After placing an order to the client order API, the order needs to be fulfilled.
   * Ref. the API docs.
   *
   * @see https://doc.mediaconnect.no/doc/ConnectID/#operation/order
   *
   * @param  \League\OAuth2\Client\Token\AccessToken  $accessToken
   *   Access token to identify the user.
   * @param  \ConnectId\Api\DataModel\Order  $order
   *   Order data to submit.
   *
   * @return \ConnectId\Api\DataModel\Order
   *   The order object, with the additional orderId configured.
   *
   * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
   *   Could indicate errors with the API server or with the order, needs to be handled manually.
   */
  public function submitOrder(AccessTokenInterface $accessToken, Order $order): Order;
}
