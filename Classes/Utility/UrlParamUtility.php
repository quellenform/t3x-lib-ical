<?php

declare(strict_types=1);

namespace Quellenform\LibIcal\Utility;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * Class UrlParamUtility
 */
class UrlParamUtility implements SingletonInterface
{

    /**
     * Extension configuration
     *
     * @var array
     */
    private $extConf = [];

    /**
     * TYPO3 $extConf['slug']
     *
     * @var PathUtility
     */
    private $pathUtility = null;

    public function __construct()
    {
        /** @var array $extConf */
        $this->extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('lib_ical');

        /** @var PathUtility $pathUtility */
        $this->pathUtility = GeneralUtility::makeInstance(PathUtility::class);
    }

    /**
     * Return the slug for the Ical-System.
     *
     * @return string
     */
    public function getIcalSlug(): string
    {
        $slug = $this->pathUtility->getCanonicalPath($this->extConf['slug']);
        return !empty($slug) ? $slug : 'ical';
    }

    /**
     * Return the URL parameter which is used as data array.
     *
     * @return string
     */
    public function getParameterName(): string
    {
        return (string) trim($this->extConf['parameterName']);
    }
}
