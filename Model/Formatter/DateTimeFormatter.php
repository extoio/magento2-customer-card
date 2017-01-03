<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\Formatter;

use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Date time formatter.
 */
class DateTimeFormatter
{
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        TimezoneInterface $timezone
    ) {
        $this->timezone = $timezone;
    }

    /**
     * Format date medium.
     *
     * @param string $date
     * @return string
     */
    public function formatMedium($date)
    {
        return $this->timezone->formatDateTime(
            $date,
            \IntlDateFormatter::MEDIUM
        );
    }
}
