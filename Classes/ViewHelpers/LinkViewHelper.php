<?php

declare(strict_types=1);

namespace Quellenform\LibIcal\ViewHelpers;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Quellenform\LibIcal\Utility\UrlParamUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * A ViewHelper for creating iCal-URLs.
 *
 * Examples
 * ========
 *
 * URI to the show-action of the current controller::
 *
 *    <ical:link class="btn btn-primary" provider="eventnews" additionalParams="{uid:newsItem.uid}" />
 *
 * ``/slug?ical%5Bparams%5D%5BL%5D=0&amp;ical%5Bparams%5D%5Breferrer%5D=###URL###&amp;ical%5Bparams%5D%5Buid%5D=2&amp;ical%5Bprovider%5D=eventnews&amp;cHash=8bcb0de295984642a56846e645df3a45``
 *
 */
class LinkViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * @var UriBuilder
     */
    protected $uriBuilder = null;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();

        $this->registerArgument('provider', 'string', 'The iCal-Provider', true);
        $this->registerArgument('additionalParams', 'array', 'Additional query parameters', false, []);
        $this->registerArgument('noCache', 'bool', 'Disable caching for the target page.', false, false);
        $this->registerArgument('debug', 'bool', 'Display as raw data instead of downloading ical', false, false);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        /** @var UrlParamUtility $extConf */
        $extConf = GeneralUtility::makeInstance(UrlParamUtility::class);

        /** @var NormalizedParams $normalizedParams */
        $normalizedParams = $this->getRequest();

        /** @var bool $noCache */
        $noCache = $this->arguments['noCache'];

        /** @var string $parameterName */
        $parameterName = $extConf->getParameterName();

        /** @var array $urlParams */
        $urlParams = [
            $parameterName => [
                'provider' => $this->arguments['provider'],
                'params' => base64_encode(
                    json_encode(
                        array_merge(
                            $this->arguments['additionalParams'],
                            [
                                'referrer' => $normalizedParams->getRequestUrl(),
                                'L' => GeneralUtility::makeInstance(Context::class)->getAspect('language')->getId(),
                            ]
                        )
                    )
                )
            ]
        ];

        if ($this->arguments['debug']) {
            $urlParams[$parameterName]['debug'] = $this->arguments['debug'];
        }

        /** @var string $uri */
        $uri = GeneralUtility::makeInstance(UriBuilder::class)
            ->reset()
            ->setTargetPageUid($GLOBALS['TSFE']->rootLine[0]['uid'])
            ->setNoCache($noCache)
            ->setArguments($urlParams)
            ->setCreateAbsoluteUri(false)
            ->buildFrontendUri();

        if (empty($uri)) {
            return $this->renderChildren();
        }

        // Set uri
        $uri = str_replace(
            '/',
            '/' . $extConf->getIcalSlug(),
            $uri,
        );

        $this->tag->addAttribute('href', $uri);
        $this->tag->addAttribute('rel', 'nofollow');
        $this->tag->setContent($this->renderChildren());
        $this->tag->forceClosingTag(true);

        return $this->tag->render();
    }

    /**
     * Get normalized parameters from request.
     *
     * @return \TYPO3\CMS\Core\Http\NormalizedParams
     */
    private function getRequest(): NormalizedParams
    {
        return $GLOBALS['TYPO3_REQUEST']->getAttribute('normalizedParams');
    }
}
