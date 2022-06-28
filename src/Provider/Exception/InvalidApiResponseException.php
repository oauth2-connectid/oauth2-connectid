<?php

namespace ConnectId\OAuth2\Client\Provider\Exception;


use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Message;
use Psr\Http\Message\ResponseInterface;

class InvalidApiResponseException extends \RuntimeException {
  /**
   * Http response causing the exception.
   *
   * @var \Psr\Http\Message\ResponseInterface
   */
  protected ResponseInterface $response;

  /**
   * Any attached data.
   *
   * @var mixed|null
   */
  protected $data = NULL;

  public function __construct($message, ResponseInterface $response, $data = NULL) {
    // Set the code of the exception if the response is set and not future.
    $code = !($response instanceof PromiseInterface) ? $response->getStatusCode() : 0;
    parent::__construct($message, $code);
    $this->response = $response;
    $this->data = $data;
  }

  /**
   * Get a short summary of the response
   *
   * Will return `null` if the response is not printable.
   *
   * @return string|null
   *   Response summary.
   */
  public function getResponseBodySummary(): ?string {
    return Message::bodySummary($this->response);
  }

  /**
   * Get the associated response
   *
   * @return ResponseInterface
   *   The response.
   */
  public function getResponse(): ResponseInterface {
    return $this->response;
  }

  /**
   * Check is exception has any attached data.
   *
   * @return bool
   *   True onyl if has any data.
   */
  public function hasAttachedData(): bool {
    return $this->data !== NULL;
  }

  /**
   * Get the attached data.
   *
   * @return mixed|null
   *   Attached response data or null if none.
   */
  public function getAttachedData() {
    return $this->data;
  }
}
