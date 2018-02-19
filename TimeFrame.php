<?php

namespace App;

/**
 * Class TimeFrame.
 */
final class TimeFrame
{
    /**
     * @var \DateTimeImmutable
     */
    private $startDate;

    /**
     * @var \DateTimeImmutable
     */
    private $endDate;

    /**
     * TimeFrame constructor.
     * @param \DateTimeImmutable $startDate
     * @param \DateTimeImmutable $endDate
     */
    public function __construct(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return TimeFrame
     */
    public static function lastMinute(): TimeFrame
    {
        $now = new \DateTimeImmutable();

        return static(
            $now->setTime(date('H'), date('i'), 0),
            $now->setTime(date('H'), date('i') + 1, 0)
        );
    }

    /**
     * @return TimeFrame
     */
    public static function lastHour(): TimeFrame
    {
        $now = new \DateTimeImmutable();

        return static(
            $now->setTime(date('H'), 0, 0),
            $now->setTime(date('H') + 1, 0, 0)
        );
    }

    /**
     * @return TimeFrame
     */
    public static function lastDay(): TimeFrame
    {
        $now = new \DateTimeImmutable();

        return static(
            $now->setTime(0, 0, 0),
            $now->setDate(date('Y'), date('m'), date('d') + 1)->setTime(0, 0, 0)
        );
    }

    /**
     * @return string
     */
    public function getHashCode(): string
    {
        return sprintf(
            '%s_%s',
            $this->startDate->getTimestamp(),
            $this->endDate->getTimestamp()
        );
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }
}