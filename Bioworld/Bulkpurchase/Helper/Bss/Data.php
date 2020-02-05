<?php

namespace Bioworld\Bulkpurchase\Helper\Bss;

use Bss\PreOrder\Helper\Data as BssHelper;

class Data extends BssHelper
{
    public function formatDate(
        $date,
        $format = \IntlDateFormatter::SHORT,
        $showTime = false,
        $timezone = null,
        $pattern = 'd/MM/Y'
    ) {
        if ($date) {
            return $this->timezone->formatDateTime(
                $date,
                $format,
                $showTime ? $format : \IntlDateFormatter::NONE,
                null,
                $timezone,
                $pattern
            );
        }

        return false;
    }
}
