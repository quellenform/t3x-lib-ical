<?php

declare(strict_types=1);

namespace Quellenform\LibIcal\ViewHelpers;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Psr\Http\Message\ServerRequestInterface;
use Quellenform\LibIcal\Utility\UrlParamUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;

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
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '13', '>=')) {
            // @extensionScannerIgnoreLine
            $this->registerUniversalTagAttributes();
        }
        $this->registerArgument('provider', 'string', 'The iCal-Provider', true);
        $this->registerArgument('additionalParams', 'array', 'Additional query parameters');
        $this->registerArgument('noCache', 'bool', 'Disable caching for the target page.');
        $this->registerArgument('debug', 'bool', 'Display as raw data instead of downloading ical');
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $request = null;
        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '13', '>=')) {
            if ($this->renderingContext->hasAttribute(ServerRequestInterface::class)) {
                $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
            }
        } else {
            /** @var RenderingContext $renderingContext */
            $renderingContext = $this->renderingContext;
            // @extensionScannerIgnoreLine
            $request = $renderingContext->getRequest();
        }

        /** @var UrlParamUtility $extConf */
        $extConf = GeneralUtility::makeInstance(UrlParamUtility::class);
        $pageId = $this->getRootPageId();
        $noCache = (bool) ($this->arguments['noCache'] ?? false);
        $parameterName = $extConf->getParameterName();

        $urlParams = [
            $parameterName => [
                'provider' => $this->arguments['provider'],
                'params' => base64_encode(
                    json_encode(
                        array_merge(
                            $this->arguments['additionalParams'],
                            [
                                'referrer' => $this->getRequestUrl(),
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
            ->setRequest($request)
            ->setTargetPageUid($pageId)
            ->setNoCache($noCache)
            ->setArguments($urlParams)
            ->setCreateAbsoluteUri(false)
            ->buildFrontendUri();

        $content = (string) $this->renderChildren();
        if ($uri === '') {
            return $content;
        }

        // Set uri
        $uri = str_replace(
            '?',
            $extConf->getIcalSlug() . '?',
            $uri,
        );

        $this->tag->addAttribute('href', $uri);
        $this->tag->addAttribute('rel', 'nofollow');
        $this->tag->setContent($content);
        $this->tag->forceClosingTag(true);

        return $this->tag->render();
    }

    /**
     * Get request url from normalized parameters.
     *
     * @return string
     */
    private function getRequestUrl(): string
    {
        /** @var NormalizedParams $normalizedParams */
        $normalizedParams = $GLOBALS['TYPO3_REQUEST']->getAttribute('normalizedParams');
        return $normalizedParams->getRequestUrl();
    }

    /**
     * Get root page id from Site object.
     *
     * @return int
     */
    private function getRootPageId(): int
    {
        /** @var Site $site */
        $site = $GLOBALS['TYPO3_REQUEST']->getAttribute('site');
        return $site->getRootPageId();
    }
}
