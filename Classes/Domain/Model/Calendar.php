<?php

declare(strict_types=1);

namespace Quellenform\LibIcal\Domain\Model;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Quellenform\LibIcal\Domain\Model\Component;
use Quellenform\LibIcal\Domain\Model\Vevent;
use Quellenform\LibIcal\Domain\Model\Vjournal;
use Quellenform\LibIcal\Domain\Model\Vtodo;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Calendar
 */
class Calendar
{
    /**
     * Product identifier
     *
     * @var string
     */
    protected $prodid = '-//TYPO3//lib_ical//EN';

    /**
     * Version
     *
     * @var string
     */
    protected $version = '2.0';

    /**
     * Calendar scale
     *
     * @var string
     */
    protected $calscale = 'GREGORIAN';

    /**
     * VEVENT calendar component object storage
     *
     * @var ObjectStorage<Vevent>
     * @Lazy
     */
    protected $vevent = null;

    /**
     * VJOURNAL calendar component object storage
     *
     * @var ObjectStorage<Vjournal>
     * @Lazy
     */
    protected $vjournal = null;

    /**
     * VTODO calendar component object storage
     *
     * @var ObjectStorage<Vtodo>
     * @Lazy
     */
    protected $vtodo = null;

    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     *
     * @return void
     */
    protected function initStorageObjects(): void
    {
        $this->vevent = new ObjectStorage();
        $this->vjournal = new ObjectStorage();
        $this->vtodo = new ObjectStorage();
    }

    /**
     * @return string
     */
    public function getProdid(): string
    {
        return $this->prodid;
    }

    /**
     * @param string $prodid
     *
     * @return void
     */
    public function setProdid(string $prodid): void
    {
        $this->prodid = $prodid;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return void
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getCalscale(): string
    {
        return $this->calscale;
    }

    /**
     * @param string $calscale
     *
     * @return void
     */
    public function setCalscale(string $calscale): void
    {
        $this->calscale = $calscale;
    }

    /**
     * Gets the VEVENT calendar component object storage
     *
     * @return ObjectStorage<Component>
     */
    public function getVevent(): ObjectStorage
    {
        return $this->vevent;
    }

    /**
     * Sets the VEVENT calendar component object storage
     *
     * @param ObjectStorage $veventObject
     *
     * @return void
     */
    public function setVevent(ObjectStorage $veventObject): void
    {
        $this->vevent = $veventObject;
    }

    /**
     * Adds a new VEVENT calendar component to the object storage
     *
     * @param Component $vevent
     *
     * @return void
     */
    public function addVevent(Component $vevent): void
    {
        $this->vevent->attach($vevent);
    }

    /**
     * Gets the VJOURNAL calendar component object storage
     *
     * @return ObjectStorage<Component>
     */
    public function getVjournal(): ObjectStorage
    {
        return $this->vjournal;
    }

    /**
     * Sets the VJOURNAL calendar component object storage
     *
     * @param ObjectStorage $vjournalObject
     *
     * @return void
     */
    public function setVjournal(ObjectStorage $vjournalObject): void
    {
        $this->vjournal = $vjournalObject;
    }

    /**
     * Adds a new VJOURNAL calendar component to the object storage
     *
     * @param Component $vjournal
     *
     * @return void
     */
    public function addVjournal(Component $vjournal): void
    {
        $this->vjournal->attach($vjournal);
    }

    /**
     * Gets the VTODO calendar component object storage
     *
     * @return ObjectStorage<Component>
     */
    public function getVtodo(): ObjectStorage
    {
        return $this->vjournal;
    }

    /**
     * Sets the VTODO calendar component object storage
     *
     * @param ObjectStorage $vtodoObject
     *
     * @return void
     */
    public function setVtodo(ObjectStorage $vtodoObject): void
    {
        $this->vtodo = $vtodoObject;
    }

    /**
     * Adds a new VTODO calendar component to the object storage
     *
     * @param Component $vtodo
     *
     * @return void
     */
    public function addVtodo(Component $vtodo): void
    {
        $this->vtodo->attach($vtodo);
    }

    /**
     * Adds a new calendar component to a specific object storage
     *
     * @param string $componentIdentifier
     * @param Component $componentObject
     *
     * @return void
     */
    public function addComponent(string $componentIdentifier = '', Component $componentObject = null): void
    {
        switch ($componentIdentifier) {
            case 'event':
                $this->vevent->attach($componentObject);
                break;
            case 'journal':
                $this->vevent->attach($componentObject);
                break;
            case 'todo':
                $this->vevent->attach($componentObject);
                break;
        }
    }
}
