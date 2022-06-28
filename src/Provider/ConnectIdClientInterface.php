<?php

declare(strict_types=1);

namespace ConnectId\OAuth2\Client\Provider;

use League\OAuth2\Client\Token\AccessTokenInterface;

interface ConnectIdClientInterface {
  /**
   * Error identifiers as defined in the OAuth 2.0 RFC 6749
   *
   * @see https://tools.ietf.org/html/rfc6749#section-5.2
   */
  public const RFC6749_INVALID_REQUEST = 'invalid_request';

  /**
   * Error identifiers as defined in the OAuth 2.0 RFC 6749
   *
   * @see https://tools.ietf.org/html/rfc6749#section-5.2
   */
  public const RFC6749_INVALID_CLIENT = 'invalid_client';

  /**
   * Error identifiers as defined in the OAuth 2.0 RFC 6749
   *
   * @see https://tools.ietf.org/html/rfc6749#section-5.2
   */
  public const RFC6749_INVALID_GRANT = 'invalid_grant';

  /**
   * Error identifiers as defined in the OAuth 2.0 RFC 6749
   *
   * @see https://tools.ietf.org/html/rfc6749#section-5.2
   */
  public const RFC6749_UNAUTHORIZED_CLIENT = 'unauthorized_client';

  /**
   * Error identifiers as defined in the OAuth 2.0 RFC 6749
   *
   * @see https://tools.ietf.org/html/rfc6749#section-5.2
   */
  public const RFC6749_UNSUPPORTED_GRANT_TYPE = 'unsupported_grant_type';

  /**
   * Error identifiers as defined in the OAuth 2.0 RFC 6749
   *
   * @see https://tools.ietf.org/html/rfc6749#section-5.2
   */
  public const RFC6749_INVALID_SCOPE = 'invalid_scope';

  /**
   * Error identifiers as defined in the OAuth 2.0 RFC 6750
   *
   * @see https://tools.ietf.org/html/rfc6750#section-6.2
   */
  public const RFC6750_INVALID_REQUEST = 'invalid_request';

  /**
   * Error identifiers as defined in the OAuth 2.0 RFC 6750
   *
   * @see https://tools.ietf.org/html/rfc6750#section-6.2
   */
  public const RFC6750_INVALID_TOKEN = 'invalid_token';

  /**
   * Error identifiers as defined in the OAuth 2.0 RFC 6750
   *
   * @see https://tools.ietf.org/html/rfc6750#section-6.2
   */
  public const RFC6750_INSUFFICIENT_SCOPE = 'insufficient_scope';

  /**
   * Requests a new access_token using the provided refresh_token.
   *
   * @param  \League\OAuth2\Client\Token\AccessTokenInterface  $accessToken
   *
   * @return \League\OAuth2\Client\Token\AccessTokenInterface
   * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
   */
  public function refreshAccessToken(AccessTokenInterface $accessToken): AccessTokenInterface;

}
