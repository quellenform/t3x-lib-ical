<?php

declare(strict_types=1);

namespace Quellenform\LibIcal;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Quellenform\LibIcal\Exception\IcalException;
use Quellenform\LibIcal\Ical;
use Quellenform\LibIcal\IcalRegistry;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The main factory class, which acts as the entrypoint for generating an iCal object which
 * is responsible for rendering an iCal download. Checks for the correct iCal provider through the IcalRegistry.
 *
 * USAGE:
 *   use Quellenform\LibIcal\IcalFactory;
 *   $ical = GeneralUtility::makeInstance(IcalFactory::class);
 *   $ical->queryProvider($identifier, $params)->renderIcal()
 */
class IcalFactory
{
    /**
     * @var IcalRegistry
     */
    protected $icalRegistry = null;

    /**
     * @param IcalRegistry $icalRegistry
     */
    public function __construct(IcalRegistry $icalRegistry = null)
    {
        $this->icalRegistry = $icalRegistry ? $icalRegistry : GeneralUtility::makeInstance(IcalRegistry::class);
    }

    /**
     * Query iCal provider.
     *
     * @param string $identifier The iCal Provider identifier
     * @param array $params Additional provider parameters
     *
     * @return Ical
     * @throws IcalException
     */
    public function queryProvider(string $identifier = '', array $params = []): ?Ical
    {
        if (!empty($identifier)) {
            // Set iCal-provider configuration default values
            $providerConfiguration['config'] = $params;

            // Get iCal-provider configuration and merge it
            ArrayUtility::mergeRecursiveWithOverrule(
                $providerConfiguration,
                $this->icalRegistry->getProviderConfigurationByIdentifier($identifier)
            );

            /** @var Ical $ical */
            $ical = GeneralUtility::makeInstance(Ical::class);

            /** @var IcalProviderInterface $IcalProvider */
            $icalProvider = GeneralUtility::makeInstance($providerConfiguration['provider']);
            $result = $icalProvider->query($ical, $providerConfiguration['config']);
            if ($result) {
                return $ical;
            } else {
                return null;
            }
        } else {
            throw new IcalException('No iCal-Provider identifier provided.');
        }
    }
}
