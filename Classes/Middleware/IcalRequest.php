<?php

declare(strict_types=1);

namespace Quellenform\LibIcal\Middleware;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Quellenform\LibIcal\Exception\IcalException;
use Quellenform\LibIcal\Ical;
use Quellenform\LibIcal\IcalFactory;
use Quellenform\LibIcal\Utility\UrlParamUtility;
use TYPO3\CMS\Core\Http\NullResponse;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Lightweight alternative to regular frontend requests; used when $_GET[eID] is set.
 * In the future, logic from the EidUtility will be moved to this class, however in most cases
 * a custom PSR-15 middleware will be better suited for whatever job the eID functionality does currently.
 *
 * @internal
 */
class IcalRequest implements MiddlewareInterface
{
    /**
     * Process an incoming server request
     *
     * Processes an incoming server request in order to produce a response.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws IcalException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        /** @var UrlParamUtility $urlParam */
        $icalUrlParam = GeneralUtility::makeInstance(UrlParamUtility::class);
        $parameterName = $icalUrlParam->getParameterName();
        $slug = $icalUrlParam->getIcalSlug();

        if (
            str_ends_with($request->getUri()->getPath(), '/' . $slug) &&
            isset($queryParams[$parameterName]) &&
            is_array($queryParams[$parameterName])
        ) {
            $icalRequest = $queryParams[$parameterName];

            /** @var bool $debug */
            $debug = isset($icalRequest['debug']) ? boolval($icalRequest['debug']) : false;
            /** @var array $params */
            $params = isset($icalRequest['params']) && is_array($icalRequest['params']) ? $icalRequest['params'] : [];
            /** @var string $provider */
            $provider = isset($icalRequest['provider']) ? $icalRequest['provider'] : false;

            // Instantiate the iCal object and get data from requested iCal-provider
            if (!empty($provider)) {
                /** @var ?Ical $calendar */
                $calendar = GeneralUtility::makeInstance(IcalFactory::class)->queryProvider($provider, $params);
                if ($calendar) {
                    $calendar->setDebug($debug);
                    /** @var Response $response */
                    $response = $calendar->getIcalResponse();
                    if ($response) {
                        return $response;
                    }
                }
            }
            return new NullResponse();
        }
        return $handler->handle($request);
    }
}
