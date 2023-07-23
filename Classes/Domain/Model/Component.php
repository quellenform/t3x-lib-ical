<?php

declare(strict_types=1);

namespace Quellenform\LibIcal\Domain\Model;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Component Properties
 *
 * The following properties can appear within calendar components, as
 * specified by each component property definition.
 * https://tools.ietf.org/html/rfc5545#section-8.3.2
 *
 */
class Component
{
    /**
     *
     * Descriptive Component Properties
     *
     * The following properties specify descriptive information about
     * calendar components.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1
     *
     */

    /**
     * Attachment
     *
     * This property provides the capability to associate a
     * document object with a calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.1
     *
     * @var string
     */
    protected $attachment;

    /**
     * Categories
     *
     * This property defines the categories for a calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.2
     *
     * @var array
     */
    protected $categories;

    /**
     * Classification
     *
     * This property defines the access classification for a
     * calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.3
     *
     * @var string
     */
    protected $classification;

    /**
     * Comment
     *
     * This property specifies non-processing information intended
     * to provide a comment to the calendar user.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.4
     *
     * @var string
     */
    protected $comment;

    /**
     * Description
     *
     * This property provides a more complete description of the
     * calendar component than that provided by the "SUMMARY" property.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.5
     *
     * @var string
     */
    protected $description;

    /**
     * Geographic Position
     *
     * This property specifies information related to the global
     * position for the activity specified by a calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.6
     *
     * @var array
     */
    protected $geo;

    /**
     * Location
     *
     * This property defines the intended venue for the activity
     * defined by a calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.7
     *
     * @var string
     */
    protected $location;

    /**
     * Percent Complete
     *
     * This property is used by an assignee or delegatee of a
     * to-do to convey the percent completion of a to-do to the
     * "Organizer".
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.8
     *
     * @var int
     */
    protected $percentComplete;

    /**
     * Priority
     *
     * This property defines the relative priority for a calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.9
     *
     * @var int
     */
    protected $priority;

    /**
     * Resources
     *
     * This property defines the equipment or resources
     * anticipated for an activity specified by a calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.10
     *
     * @var string
     */
    protected $resources;

    /**
     * Status
     *
     * This property defines the overall status or confirmation
     * for the calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.11
     *
     * @var string
     */

    /**
     * Summary
     *
     * This property defines a short summary or subject for the
     * calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.1.12
     *
     * @var string
     */
    protected $summary;

    /**
     *
     * Date and Time Component Properties
     *
     * The following properties specify date and time related information in
     * calendar components.
     * https://tools.ietf.org/html/rfc5545#section-3.8.2
     *
     */

    /**
     * Date-Time Completed
     *
     * This property defines the date and time that a to-do was
     * actually completed.
     * https://tools.ietf.org/html/rfc5545#section-3.8.2.1
     *
     * @var int
     */
    protected $completed;

    /**
     * Date-Time End
     *
     * This property specifies the date and time that a calendar
     * component ends.
     * https://tools.ietf.org/html/rfc5545#section-3.8.2.2
     *
     * @var int
     */
    protected $dtend;

    /**
     * Date-Time Due
     *
     * This property defines the date and time that a to-do is
     * expected to be completed.
     * https://tools.ietf.org/html/rfc5545#section-3.8.2.3
     *
     * @var int
     */
    protected $due;

    /**
     * Date-Time Start
     *
     * This property specifies when the calendar component begins.
     * https://tools.ietf.org/html/rfc5545#section-3.8.2.4
     *
     * @var int
     */
    protected $dtstart;

    /**
     * Duration
     *
     * This property specifies a positive duration of time.
     * https://tools.ietf.org/html/rfc5545#section-3.8.2.5
     *
     * @var int
     */
    protected $duration;

    /**
     * Free/Busy Time
     *
     * This property defines one or more free or busy time intervals.
     * https://tools.ietf.org/html/rfc5545#section-3.8.2.6
     *
     * @var int
     */
    protected $freebusy;

    /**
     * Time Transparency
     *
     * This property defines whether or not an event is
     * transparent to busy time searches.
     * https://tools.ietf.org/html/rfc5545#section-3.8.2.7
     *
     * @var string
     */
    protected $transp;

    /**
     *
     * Time Zone Component Properties
     *
     * The following properties specify time zone information in calendar components.
     * https://tools.ietf.org/html/rfc5545#section-3.8.3
     *
     */

    /**
     * Time Zone Identifier
     *
     * This property specifies the text value that uniquely
     * identifies the "VTIMEZONE" calendar component in the scope of an
     * iCalendar object.
     * https://tools.ietf.org/html/rfc5545#section-3.8.3.1
     *
     * @var string
     */
    protected $tzid;

    /**
     * Time Zone Name
     *
     * This property specifies the customary designation for a
     * time zone description.
     * https://tools.ietf.org/html/rfc5545#section-3.8.3.2
     *
     * @var string
     */
    protected $tzname;

    /**
     * Time Zone Offset From
     *
     * This property specifies the offset that is in use prior to
     * this time zone observance.
     * https://tools.ietf.org/html/rfc5545#section-3.8.3.3
     *
     * @var int
     */
    protected $tzoffsetfrom;

    /**
     * Time Zone Offset To
     *
     * This property specifies the offset that is in use in this
     * time zone observance.
     * https://tools.ietf.org/html/rfc5545#section-3.8.3.4
     *
     * @var int
     */
    protected $tzoffsetto;

    /**
     * Time Zone URL
     *
     * This property provides a means for a "VTIMEZONE" component
     * to point to a network location that can be used to retrieve an up-
     * to-date version of itself.
     * https://tools.ietf.org/html/rfc5545#section-3.8.3.5
     *
     * @var string
     */
    protected $tzurl;

    /**
     *
     * Relationship Component Properties
     *
     * The following properties specify relationship information in calendar components.
     * https://tools.ietf.org/html/rfc5545#section-3.8.4
     *
     */

    /**
     * Attendee
     *
     * This property defines an "Attendee" within a calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.4.1
     *
     * @var string
     */
    protected $attendee;

    /**
     * Contact
     *
     * This property is used to represent contact information or
     * alternately a reference to contact information associated with the
     * calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.4.2
     *
     * @var string
     */
    protected $contact;

    /**
     * Organizer
     *
     * This property defines the organizer for a calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.4.3
     *
     * @var string
     */
    protected $organizer;

    /**
     * Recurrence ID
     *
     * This property is used in conjunction with the "UID" and
     * "SEQUENCE" properties to identify a specific instance of a
     * recurring "VEVENT", "VTODO", or "VJOURNAL" calendar component.
     * The property value is the original value of the "DTSTART" property
     * of the recurrence instance.
     * https://tools.ietf.org/html/rfc5545#section-3.8.4.4
     *
     * @var string
     */
    protected $recurrenceId;

    /**
     * Related To
     *
     * This property is used to represent a relationship or
     * reference between one calendar component and another.
     * https://tools.ietf.org/html/rfc5545#section-3.8.4.5
     *
     * @var string
     */
    protected $relatedTo;

    /**
     * Uniform Resource Locator
     *
     * This property defines a Uniform Resource Locator (URL)
     * associated with the iCalendar object.
     * https://tools.ietf.org/html/rfc5545#section-3.8.4.6
     *
     * @var string
     */
    protected $url;

    /**
     * Unique Identifier
     *
     *  This property defines the persistent, globally unique
     * identifier for the calendar component.
     * https://tools.ietf.org/html/rfc5545#section-3.8.4.7
     *
     * @var string
     */
    protected $uid;

    /**
     *
     * Recurrence Component Properties
     *
     * https://tools.ietf.org/html/rfc5545#section-3.8.5
     *
     */

    /**
     * Exception Date-Times
     *
     * This property defines the list of DATE-TIME exceptions for
     * recurring events, to-dos, journal entries, or time zone
     * definitions.
     * https://tools.ietf.org/html/rfc5545#section-3.8.5.1
     *
     * @var int
     */
    protected $exdate;

    /**
     * Recurrence Date-Times
     *
     * This property defines the list of DATE-TIME values for
     * recurring events, to-dos, journal entries, or time zone
     * definitions.
     * https://tools.ietf.org/html/rfc5545#section-3.8.5.2
     *
     * @var int
     */
    protected $rdate;

    /**
     * Recurrence Rule
     *
     * This property defines a rule or repeating pattern for
     * recurring events, to-dos, journal entries, or time zone
     * definitions.
     * https://tools.ietf.org/html/rfc5545#section-3.8.5.3
     *
     * @var string
     */
    protected $rrule;

    /**
     *
     * Alarm Component Properties
     *
     * https://tools.ietf.org/html/rfc5545#section-3.8.6
     *
     */

    /**
     * Action
     *
     * This property defines the action to be invoked when an
     * alarm is triggered.
     * https://tools.ietf.org/html/rfc5545#section-3.8.6.1
     *
     * @var string
     */
    protected $action;

    /**
     * Repeat Count
     *
     * This property defines the number of times the alarm should
     * be repeated, after the initial trigger.
     * https://tools.ietf.org/html/rfc5545#section-3.8.6.2
     *
     * @var int
     */
    protected $repeat;

    /**
     * Trigger
     *
     * This property specifies when an alarm will trigger.
     * https://tools.ietf.org/html/rfc5545#section-3.8.6.3
     *
     * @var int
     */
    protected $trigger;

    /**
     *
     * Change Management Component Properties
     *
     * https://tools.ietf.org/html/rfc5545#section-3.8.7
     *
     */

    /**
     * Date-Time Created
     *
     * This property specifies the date and time that the calendar
     * information was created by the calendar user agent in the calendar
     * store.
     * Note: This is analogous to the creation date and time for a
     * file in the file system.
     * https://tools.ietf.org/html/rfc5545#section-3.8.7.1
     *
     * @var int
     */
    protected $created;

    /**
     * Date-Time Stamp
     *
     * In the case of an iCalendar object that specifies a
     * "METHOD" property, this property specifies the date and time that
     * the instance of the iCalendar object was created.  In the case of
     * an iCalendar object that doesn't specify a "METHOD" property, this
     * property specifies the date and time that the information
     * associated with the calendar component was last revised in the
     * calendar store.
     * https://tools.ietf.org/html/rfc5545#section-3.8.7.2
     *
     * @var int
     */
    protected $dtstamp;

    /**
     * Last Modified
     *
     * This property specifies the date and time that the
     * information associated with the calendar component was last
     * revised in the calendar store.
     * Note: This is analogous to the modification date and time for a
     * file in the file system.
     * https://tools.ietf.org/html/rfc5545#section-3.8.7.3
     *
     * @var int
     */
    protected $lastModified;

    /**
     * Sequence Number
     *
     * This property defines the revision sequence number of the
     * calendar component within a sequence of revisions.
     * https://tools.ietf.org/html/rfc5545#section-3.8.7.4
     *
     * @var int
     */
    protected $sequence;

    /**
     * @var bool
     */
    protected $isAlldayEvent;

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     *
     * @return void
     */
    public function setSummary(string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return int
     */
    public function getDateStart(): int
    {
        return $this->dateStart;
    }

    /**
     * @param int $dateStart
     *
     * @return void
     */
    public function setDateStart(int $dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return int
     */
    public function getDateEnd(): int
    {
        return $this->dateEnd;
    }

    /**
     * @param int $dateEnd
     *
     * @return void
     */
    public function setDateEnd(int $dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     *
     * @return void
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function getIsAlldayEvent(): bool
    {
        return $this->isAlldayEvent;
    }

    /**
     * @param bool $isAlldayEvent
     *
     * @return void
     */
    public function setIsAlldayEvent(bool $isAlldayEvent = true): void
    {
        $this->isAlldayEvent = $isAlldayEvent;
    }

    /**
     * @return string
     */
    public function getOrganizerEmail(): string
    {
        return $this->organizerEmail;
    }

    /**
     * @param string $organizerEmail
     *
     * @return void
     */
    public function setOrganizerEmail(string $organizerEmail): void
    {
        $this->organizerEmail = $organizerEmail;
    }

    /**
     * @return string
     */
    public function getOrganizerName(): string
    {
        return $this->organizerName;
    }

    /**
     * @param string $organizerName
     *
     * @return void
     */
    public function setOrganizerName(string $organizerName): void
    {
        $this->organizerName = $organizerName;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     *
     * @return void
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @param string $category
     *
     * @return void
     */
    public function addCategory(string $category): void
    {
        $this->categories[] = $category;
    }
}
