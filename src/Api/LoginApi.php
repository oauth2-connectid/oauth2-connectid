<?php

declare(strict_types=1);

namespace ConnectId\Api;

use ConnectId\Api\DataModel\CustomerProductList;
use ConnectId\Api\DataModel\Order;
use ConnectId\Api\DataModel\SubscriptionList;
use ConnectId\OAuth2\Client\Provider\ConnectId;
use ConnectId\OAuth2\Client\Provider\Endpoints;
use League\OAuth2\Client\Token\AccessTokenInterface;
use UnexpectedValueException;

class LoginApi extends ConnectId implements LoginApiInterface {

  /**
   * @inheritDoc
   */
  public function getOrderFulfillmentUrl(string $orderId, string $returnUrl, string $errorUrl): string {
    $params = [
      'clientId'  => $this->clientId,
      'orderId'   => $orderId,
      'returnUrl' => $returnUrl,
      'errorUrl'  => $errorUrl,
    ];

    $url = Endpoints::getLoginUrl('fulfillment', $this->testing);
    // ConnectID expects the parameters in the urls not the body also for the POST
    $query = $this->getAccessTokenQuery($params);
    return $this->appendQuery($url, $query);
  }

  /**
   * @inheritDoc
   */
  public function getSubscriptionList(AccessTokenInterface $accessToken): SubscriptionList {
    $url = Endpoints::getApiUrl('v1/subscription', $this->testing);
    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $accessToken);
    $response = $this->getParsedResponse($request);

    // If the response is not an array, or it does not contain the subscriptions we must consider it an invalid answer.
    if (FALSE === is_array($response) || !isset($response['subscriptions'])) {
      throw new UnexpectedValueException(
        'Invalid response received from Authorization Server. Expected JSON.'
      );
    }

    return SubscriptionList::fromDataArray($response['subscriptions']);
  }

  /**
   * @inheritDoc
   */
  public function getCustomerProducts(AccessTokenInterface $accessToken): CustomerProductList {
    $url = Endpoints::getApiUrl('v1/customer/product', $this->testing);
    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $accessToken);
    $response = $this->getParsedResponse($request);

    if (FALSE === is_array($response) || !isset($response['products'])) {
      throw new UnexpectedValueException(
        'Invalid response received from Authorization Server. Expected JSON.'
      );
    }

    return CustomerProductList::fromDataArray($response['products']);
  }

  /**
   * @inheritDoc
   */
  public function submitOrder(AccessTokenInterface $accessToken, Order $order): Order {
    $url = Endpoints::getApiUrl('v1/order', $this->testing);
    $options = [
      'body' => $order->toJson(),
    ];
    $request = $this->getAuthenticatedRequest(self::METHOD_POST, $url, $accessToken, $options)
      ->withAddedHeader('Content-Type', 'application/json');
    $response = $this->getParsedResponse($request);

    if (FALSE === is_array($response) || !isset($response['orderId'])) {
      throw new UnexpectedValueException(
        'Invalid response received from Authorization Server. Expected JSON.'
      );
    }

    return $order->withOrderId($response['orderId']);
  }

  /**
   * @inheritDoc
   */
  public function getOrderList(AccessTokenInterface $accessToken): array {
    $url = Endpoints::getApiUrl('v1/order/status', $this->testing);
    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $accessToken);
    $response = $this->getParsedResponse($request);

    if (FALSE === is_array($response)) {
      throw new UnexpectedValueException(
        'Invalid response received from Authorization Server. Expected JSON.'
      );
    }

    return $response;
  }
}
