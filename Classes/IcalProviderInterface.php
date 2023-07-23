<?php

declare(strict_types=1);

namespace Quellenform\LibIcal;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Quellenform\LibIcal\Ical;

/**
 * Interface IcalProviderInterface
 */
interface IcalProviderInterface
{
    /**
     * Query the iCal provider
     *
     * @param Ical $ical
     * @param array $params
     *
     * @return bool
     */
    public function query(Ical $ical, array $params = []): bool;
}
