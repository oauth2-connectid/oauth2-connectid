<?php

namespace ConnectId\Api\DataModel;

trait StartEndTimeTrait {

  /**
   * @var \DateTimeImmutable|null
   */
  protected $startTime;

  /**
   * @var \DateTimeImmutable|null
   */
  protected $endTime;

  /**
   * @return \DateTimeImmutable|null
   */
  public function getStartTime(): ?\DateTimeImmutable {
    return $this->startTime;
  }

  /**
   * @param \DateTimeImmutable|\DateTime|int $timeValue
   *   Either a \DateTimeImmutable, a \DateTime object or a unix timestamp (UTC).
   *
   * @return $this
   */
  public function withStartTime($timeValue): self {
    $this->startTime = !empty($timeValue) ? $this->getDateTimeFromData($timeValue) : NULL;

    return $this;
  }

  /**
   * @return \DateTimeImmutable|null
   */
  public function getEndTime(): ?\DateTimeImmutable {
    return $this->endTime;
  }

  /**
   * @param \DateTimeImmutable|\DateTime|int $timeValue
   *   Either a \DateTimeImmutable, a \DateTime object or a unix timestamp (UTC).
   *
   * @return $this
   */
  public function withEndTime($timeValue): self {
    $this->endTime = !empty($timeValue) ? $this->getDateTimeFromData($timeValue) : NULL;

    return $this;
  }

}
