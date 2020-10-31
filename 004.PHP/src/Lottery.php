<?php

namespace App;

class Lottery implements LotteryInterface
{
    protected const HOUR = 21;
    protected const MINUTE = 30;
    protected const WEEKDAYS = 7;
    protected const SUNDAY_MINUS_TUESDAY = 5;
    protected const SUNDAY = 0;
    protected const TUESDAY = 2;
    /**
     * @var string
     */
    private $nextDraw;

    /**
     * Lottery constructor.
     * @param \DateTime $currentDate
     */
    public function __construct(\DateTime $currentDate)
    {
        $this->setNextDraw($currentDate);
    }

    /**
     * @param \DateTime $currentDate
     */
    private function setNextDraw(\DateTime $currentDate): void {
        $dayOfWeek = (int) $currentDate->format('w');

        if($dayOfWeek > self::TUESDAY || $dayOfWeek === self::SUNDAY) {
            $nextDate = $this
                ->getNextDate($currentDate, $dayOfWeek, self::SUNDAY);
        } else {
            $nextDate = $this
                ->getNextDate($currentDate, $dayOfWeek, self::TUESDAY);
        }

        $nextDate->setTime(self::HOUR, self::MINUTE);
        $this->nextDraw = $nextDate->format('r');
    }

    /**
     * @param \DateTime $currentDate
     * @param int $dayOfWeek
     * @param int $compareDay
     * @return \DateTime
     */
    private function getNextDate(\DateTime $currentDate, int $dayOfWeek, int $compareDay): \DateTime
    {
        if($dayOfWeek !== $compareDay) {
            return $this
                ->generateDateIfItIsNotTheDrawDay(
                    $currentDate,
                    $dayOfWeek,
                    $compareDay);
        }

        return $this
            ->generateDateIfItIsTheDrawDay($currentDate, $compareDay);
    }

    /**
     * @param \DateTime $currentDate
     * @param int $dayOfWeek
     * @param int $compareDay
     * @return \DateTime
     */
    private function generateDateIfItIsNotTheDrawDay(\DateTime $currentDate, int $dayOfWeek, int $compareDay): \DateTime
    {
        if ($compareDay === self::SUNDAY) {
            $dayToAdd = self::WEEKDAYS - $dayOfWeek;

            return $currentDate->add(new \DateInterval("P{$dayToAdd}D"));
        }

        $dayToAdd = $compareDay - $dayOfWeek;
        return $currentDate->add(new \DateInterval("P{$dayToAdd}D"));
    }

    /**
     * @param \DateTime $currentDate
     * @param int $compareDay
     * @return \DateTime
     */
    private function generateDateIfItIsTheDrawDay(\DateTime $currentDate, int $compareDay): \DateTime
    {
        $compareDate = clone($currentDate);
        $compareDate->setTime(self::HOUR, self::MINUTE);

        if ($currentDate > $compareDate && $compareDay === self::SUNDAY) {
            $dayToAdd = self::TUESDAY;
            $currentDate->add(new \DateInterval("P{$dayToAdd}D"));

            return $currentDate;
        }

        if ($currentDate >$compareDate && $compareDay === self::TUESDAY) {
            $dayToAdd = self::SUNDAY_MINUS_TUESDAY;
            $currentDate->add(new \DateInterval("P{$dayToAdd}D"));

            return $currentDate;
        }

        return $currentDate;
    }

    /**
     * @return string
     */
    public function getNextDraw(): string
    {
        return $this->nextDraw;
    }
}

