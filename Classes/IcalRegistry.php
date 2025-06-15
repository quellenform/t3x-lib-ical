<?php

declare(strict_types=1);

namespace Quellenform\LibIcal;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use InvalidArgumentException;
use Quellenform\LibIcal\Exception\IcalException;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Class IcalRegistry, which makes it possible to register custom iCal Providers from within an extension.
 *
 * Usage:
 *   $options = ['components' => 'vevent', 'class' => \GeorgRinger\News\Domain\Repository\NewsRepository];
 *   $icalRegistry = GeneralUtility::makeInstance(\Quellenform\LibIcal\ParserRegistry::class);
 *   $icalRegistry->registerProvider('eventnews', \Quellenform\MyProvider\Provider\EventnewsProvider::class, $options);
 */
class IcalRegistry implements SingletonInterface
{
    /**
     * Registered iCal providers
     *
     * @var array
     */
    protected $icalProviders = [];

    /**
     * Registers an iCal provider to be available inside the iCal factory.
     *
     * @param string $identifier
     * @param string $icalProviderClassName
     * @param array $config
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function registerProvider(string $identifier, string $icalProviderClassName, array $config = []): void
    {
        if (!in_array(IcalProviderInterface::class, class_implements($icalProviderClassName) ?: [], true)) {
            throw new InvalidArgumentException(
                'An iCal-Provider must implement ' . IcalProviderInterface::class . '.'
            );
        }
        $this->icalProviders[$identifier] = [
            'provider' => $icalProviderClassName,
            'config' => $config
        ];
    }

    /**
     * Get the keys of all registered iCal providers.
     *
     * @return array
     */
    public function getAllRegisteredProviders(): array
    {
        return array_keys($this->icalProviders);
    }

    /**
     * Fetches the configuration provided by registerProvider().
     *
     * @param string $identifier The iCal provider identifier
     *
     * @return array
     * @throws IcalException
     */
    public function getProviderConfigurationByIdentifier(string $identifier): array
    {
        // Throw execption if the given identifier is not registered
        if (!isset($this->icalProviders[$identifier])) {
            throw new IcalException('iCal-Provider with identifier "' . $identifier . '" is not registered.');
        }
        return $this->icalProviders[$identifier];
    }
}
