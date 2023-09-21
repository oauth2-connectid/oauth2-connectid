<?php

namespace ConnectId\Api\DataModel;

use ConnectId\Api\DataModel\BasicData;

class AccessParameters extends BasicData {

  /**
   * Check if user has access base on product.
   *
   * @var string
   */
  protected string $product;

  /**
   * Check if user has access based on specific article id.
   *
   * @var string
   */
  protected string $articleId;

  /**
   * Check if user has access based on domain.
   *
   * @var string
   */
  protected string $domain;

  /**
   * Check if user has access based on IP address.
   *
   * @var string
   */
  protected string $ip;

  /**
   * Check if user has access based on any subscription with category having this category type.
   *
   * @var string
   */
  protected string $categoryType;


  /**
   * Check if user has access to azure active directory:
   *
   * true: To check if user has access to azure AD
   * false: Do not check if user has access to azure AD.
   *
   * @var bool
   */
  protected bool $accessAzureAd;

  /**
   * Check if user or their aid family has access to given product :
   *
   * true: To check if user or family has access to given product
   * false: Do not check if user or family has access to given product.
   *
   * @var bool
   */
  protected bool $accessAidFamily;

  /**
   * Check if user has access based on unique ID (from Profile API).
   *
   * @var string
   */
  protected string $uniqueId;

  /**
   * Check if user has access base on a valid and existing customer number in
   * the Connect environment.
   *
   * @var int
   */
  protected int $customerNumber;

  /**
   * Check if user has access base on credential e.g. email address or
   * phone number.
   *
   * @var string
   */
  protected string $credential;
}
