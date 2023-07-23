<?php

declare(strict_types=1);

namespace Quellenform\LibIcal;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use \DateTime;
use \DateTimeZone;
use Quellenform\LibIcal\Domain\Model\Calendar;
use Quellenform\LibIcal\Domain\Model\Component;
use Quellenform\LibIcal\Utility\IcalUtility;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\Stream;

/**
 * iCal
 */
class Ical
{
    /**
     * Calender Model
     *
     * @var Calendar
     */
    protected $calendar = null;

    /**
     * Calender Model
     *
     * @var Component
     */
    protected $component = null;

    /**
     * Debug iCal
     *
     * @var bool
     */
    protected $debugOutput = false;

    /**
     * iCal filename
     *
     * @var string
     */
    protected $filename = 'iCalendar.ics';

    public function __construct()
    {
        $this->initializeObject();
    }

    /**
     * Initialize the calender and component objects.
     *
     * @return void
     */
    private function initializeObject(): void
    {
        $this->calendar = new Calendar();
        $this->component = new Component();
    }

    /**
     * Return an instance of the iCalendar object.
     *
     * @return Calendar
     */
    public function getCalendar(): Calendar
    {
        return $this->calendar;
    }

    /**
     * Set the iCalendar object.
     *
     * @param Calendar $calendar
     *
     * @return void
     */
    public function setCalendar(Calendar $calendar): void
    {
        $this->calendar = $calendar;
    }

    /**
     * Return an instance of the component object.
     *
     * @return Component
     */
    public function getComponent(): Component
    {
        return $this->component;
    }

    /**
     * Set the component object
     *
     * @param Component $component
     *
     * @return void
     */
    public function setComponent(Component $component): void
    {
        $this->component = $component;
    }

    /**
     * Enable/disable debug
     *
     * @param bool $debugOutput
     *
     * @return void
     */
    public function setDebug(bool $debugOutput = true): void
    {
        $this->debugOutput = $debugOutput;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return void
     */
    public function setFilename(string $filename = ''): void
    {
        if (!empty($filename)) {
            $this->filename = $filename;
        }
    }

    /**
     * Renders the calendar into iCalendar format.
     *
     * @return string
     */
    public function renderIcal(): string
    {
        $vevents = $this->calendar->getVevent()->toArray();
        $vjournals = $this->calendar->getVjournal()->toArray();
        $vtodos = $this->calendar->getVtodo()->toArray();

        if (count($vevents) || count($vjournals) || count($vtodos)) {
            // Set current timezone ID
            $tzid = date_default_timezone_get();
            if (empty($tzid)) {
                $tzid = 'Europe/Vienna';
            }

            // Get timezone object
            $timezone = new DateTimeZone($tzid);

            $icalbody[] = IcalUtility::setProperty('calscale', $this->calendar->getCalscale());
            $icalbody[] = IcalUtility::setProperty('prodid', $this->calendar->getProdid());
            $icalbody[] = IcalUtility::setProperty('version', $this->calendar->getVersion());

            // VEVENT
            foreach ($vevents as $item) {
                $vevent = [];

                // Get start date
                $start = new DateTime('@' . $item->getDateStart());
                // Convert start date into local timezone
                $start->setTimezone($timezone);
                // Get end date
                $end = new DateTime('@' . $item->getDateEnd());
                // Convert endd ate into local timezone
                $end->setTimezone($timezone);

                if ($item->getIsAlldayEvent()) {
                    $vevent[] = IcalUtility::setProperty('dtstart', date('Ymd', $start->getTimestamp()), ['VALUE' => 'DATE']);
                    $vevent[] = IcalUtility::setProperty('dtend', date('Ymd', $end->getTimestamp()), ['VALUE' => 'DATE']);
                    $vevent[] = IcalUtility::setProperty('x-microsoft-cdo-alldayevent', 'TRUE');
                } else {
                    $vevent[] = IcalUtility::setProperty('dtstart', IcalUtility::dateToCal($start), ['TZID' => $tzid]);
                    $vevent[] = IcalUtility::setProperty('dtend', IcalUtility::dateToCal($end), ['TZID' => $tzid]);
                }
                $vevent[] = IcalUtility::setProperty('dtstamp', IcalUtility::dateToCal(new DateTime('now')));
                $vevent[] = IcalUtility::setProperty('uid', uniqid('ics'));
                $vevent[] = IcalUtility::setProperty('location', IcalUtility::escapeString($item->getLocation()));
                $vevent[] = IcalUtility::setProperty('description', IcalUtility::escapeString($item->getDescription()));
                $vevent[] = IcalUtility::setProperty('url', IcalUtility::escapeString($item->getUrl()), ['VALUE' => 'URI']);
                $vevent[] = IcalUtility::setProperty('summary', IcalUtility::escapeString($item->getSummary()));
                $icalbody[] = IcalUtility::wrapItem('vevent', implode('', $vevent));
            }

            // VJOURNAL
            foreach ($vjournals as $item) {
                // TODO
                $vjournal = [];
                $vjournal[] = IcalUtility::setProperty('summary', $item->getSummary());
                $icalbody[] = IcalUtility::wrapItem('vjournal', implode('', $vjournal));
            }

            // VTODO
            foreach ($vtodos as $item) {
                // TODO
                $vtodo = [];
                $vtodo[] = IcalUtility::setProperty('summary', $item->getSummary());
                $icalbody[] = IcalUtility::wrapItem('vtodo', implode('', $vtodo));
            }

            return IcalUtility::wrapItem('vcalendar', implode('', $icalbody));
        } else {
            return '';
        }
    }

    /**
     * Create final iCal-Response.
     *
     * @return Response
     */
    public function getIcalResponse(): Response
    {
        $ical = $this->renderIcal($this->calendar);
        $body = new Stream('php://temp', 'rw');
        if ($this->debugOutput) {
            $body->write('<pre>' . $ical . '</pre>');
            return (new Response())
                ->withHeader('Content-Type', 'text/html; charset=utf-8')
                ->withBody($body)
                ->withStatus(200);
        } else {
            $body->write($ical);
            ob_clean();
            return (new Response())
                ->withHeader('Contensssst-Type', 'text/calendar; charset=utf-8')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $this->filename . '.ics"')
                ->withHeader('Cache-Control', 'no-cache, must-revalidate')
                ->withHeader('Pragma', 'no-cache')
                ->withBody($body)
                ->withStatus(200);
        }
    }
}
