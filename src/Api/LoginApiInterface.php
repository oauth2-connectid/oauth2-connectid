<?php

declare(strict_types=1);

namespace ConnectId\Api;


use ConnectId\Api\DataModel\CustomerProductList;
use ConnectId\Api\DataModel\Order;
use ConnectId\Api\DataModel\SubscriptionList;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface LoginApiInterface {

  /**
   * Builds a URL to redirect the login page.
   *
   * @see https://mediaconnect-api.redoc.ly/Production/#section/About-the-URLs/GUI:-loginUrl
   *
   * @param string  $returnUrl
   *   A URL to redirect the user’s browser back to on success.
   * @param string  $errorUrl
   *   A URL to redirect the user’s browser back to if something goes wrong.
   * @param string $credential
   *  The default user's credential, will still be editable by the user.
   * @param bool $assumeNewUser
   *    When true the registration process will be assumed.
   *
   * @return string
   *   You can redirect a user’s browser to this URL to let the user log in.
   */
  public function getUserLoginUrl(string $returnUrl, string $errorUrl, string $credential = NULL, bool $assumeNewUser = FALSE): string;

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
   * @return \ConnectId\Api\DataModel\CustomerProductList
   *   List of products owned by the customer.
   */
  public function getCustomerProducts(AccessTokenInterface $accessToken): CustomerProductList;

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

  /**
   * Returns a list of orders with a status.
   *
   * @see https://mediaconnect-api.redoc.ly/Production/tag/Order#paths/~1v1~1order~1status/get
   *
   * @return \ConnectId\Api\DataModel\OrderStatus[]
   *   List of orders.
   */
  public function getOrderList(AccessTokenInterface $accessToken): array;
}
