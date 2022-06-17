<?php

declare(strict_types=1);

namespace ConnectId\OAuth2\Client\Provider;


use ConnectId\Api\DataModel\ConnectIdProfile;
use ConnectId\OAuth2\Client\Provider\Exception\InvalidAccessTokenException;
use ConnectId\OAuth2\Client\Provider\Exception\InvalidApiResponseException;
use ConnectId\OAuth2\Client\Provider\Exception\InvalidGrantException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * Minimal provider for ConnectID OAuth handling.
 *
 * For interaction with the API you should use one of the following implementations.
 * @see \ConnectId\Api\ClientApi
 * @see \ConnectId\Api\LoginApi
 */
class ConnectId extends AbstractProvider implements ConnectIdClientInterface {

  use BearerAuthorizationTrait;

  /**
   * Indicates if we are using the Test API.
   *
   * @var bool
   */
  protected $testing = FALSE;

  /**
   * @inheritDoc
   */
  public function getBaseAuthorizationUrl() {
    return Endpoints::getOAuthUrl('authorize', $this->testing);
  }

  /**
   * @inheritDoc
   */
  public function getResourceOwnerDetailsUrl(AccessToken $token) {
    return Endpoints::getResourceOwnerDetailsUrl($this->testing);
  }

  /**
   * @inheritDoc
   */
  protected function getAccessTokenUrl(array $params) {
    $url = $this->getBaseAccessTokenUrl($params);
    // ConnectID expects the parameters in the urls not the body also for the POST
    $query = $this->getAccessTokenQuery($params);
    return $this->appendQuery($url, $query);
  }

  /**
   * @inheritDoc
   */
  public function getBaseAccessTokenUrl(array $params) {
    return Endpoints::getOAuthUrl('token', $this->testing);
  }

  /**
   * @inheritDoc
   */
  protected function getDefaultScopes() {
    return [];
  }

  /**
   * @inheritDoc
   */
  protected function getDefaultHeaders() {
    $http_headers = parent::getDefaultHeaders();

    $http_headers['accept'] = 'application/json';

    return $http_headers;
  }

  /**
   * @inheritDoc
   */
  protected function checkResponse(ResponseInterface $response, $data) {
    $statusCode = $response->getStatusCode();

    // Exception on the other side
    if ($statusCode === 400 && isset($data['exceptionType'], $data['errorMessage'])) {
      throw new InvalidApiResponseException(
        "[{$data['exceptionType']}] {$data['errorMessage']}",
        $statusCode,
        $response
      );
    }

    if (($statusCode >= 400 && $statusCode < 500) && $data['error'] === self::RFC6749_INVALID_GRANT) {
      /*
       * The provided authorization grant (e.g., authorization code, resource
       * owner credentials) or refresh token is invalid, expired, revoked, does
       * not match the redirection URI used in the authorization request, or was
       * issued to another client.
       *
       * @see https://tools.ietf.org/html/rfc6749#section-5.2
       */
      $message = $data['error'];
      if (isset($data['error_description'])) {
        $message .= ': ' . $data['error_description'];
      }
      throw new InvalidGrantException($message, $statusCode, $response);
    }

    // Check if the error is to be attributed to an expired Access Token.
    if ($statusCode === 401 && $data['error'] === self::RFC6750_INVALID_TOKEN) {
      /**
       * The access token provided is expired, revoked, malformed, or invalid
       * for other reasons.  The resource SHOULD respond with the HTTP 401
       * (Unauthorized) status code.  The client MAY request a new access token
       * and retry the protected resource request.
       *
       * @see https://tools.ietf.org/html/rfc6750#section-3.1
       * @see https://tools.ietf.org/html/rfc6750#section-6.2.2
       */
      $message = $data['error'];
      if (isset($data['error_description'])) {
        $message .= ': ' . $data['error_description'];
      }
      throw new InvalidAccessTokenException($message, $statusCode, $response);
    }

    // Fallback to a generic exception
    if ($statusCode >= 400) {
      if (isset($data['error_description'])) {
        $message = $data['error_description'];
      }
      elseif (isset($data['errorMessage'])) {
        $message = $data['exceptionType'] . ' => ' . $data['errorMessage'];
      }
      else {
        $message = $response->getReasonPhrase();
      }

      throw new InvalidApiResponseException($message, $statusCode, $response);
    }
  }

  /**
   * @inheritDoc
   */
  protected function createResourceOwner(array $response, AccessToken $token) {
    return ConnectIdProfile::createFromApiResponse($response);
  }

  /**
   * Requests a new access_token using the provided refresh_token.
   *
   * @param \League\OAuth2\Client\Token\AccessTokenInterface $accessToken
   *
   * @return \League\OAuth2\Client\Token\AccessTokenInterface
   * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
   */
  public function refreshAccessToken(AccessTokenInterface $accessToken): AccessTokenInterface {
    return $this->getAccessToken(
      'refresh_token',
      [
        'refresh_token' => $accessToken->getRefreshToken(),
      ]
    );
  }
}
