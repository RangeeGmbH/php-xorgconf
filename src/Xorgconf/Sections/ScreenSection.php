<?php
/**
 * The MIT License
 *
 * Copyright 2015 - 2016 Rangee GmbH.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Xorgconf\Sections;


use Xorgconf\Section;

/**
 * The config file may have multiple Screen sections. There must be at least one, for the “screen” being used. A
 * “screen” represents the binding of a graphics device (Device section) and a monitor (Monitor section). A Screen
 * section is considered “active” if it is referenced by an active ServerLayout section or by the −screen command line
 * option. If neither of those is present, the first Screen section found in the config file is considered the active
 * one.
 *
 * The Screen section provides information specific to the whole screen, including screen−specific Options. In
 * multi−head configurations, there will be multiple active Screen sections, one for each head.
 *
 * @package Xorgconf\Sections
 */
class ScreenSection extends Section
{
    const SECTION_NAME = 'Screen';

    /**
     * This specifies the unique name for this screen.
     *
     * @var string $identifier
     */
    private $identifier;

    /**
     * This mandatory entry specifies the Device section to be used for this screen. This is what ties a specific
     * graphics card to a screen.
     *
     * @var \Xorgconf\Sections\DeviceSection $device
     */
    private $device;

    /**
     * Specifies which monitor description is to be used for this screen. If a Monitor name is not specified, a default
     * configuration is used. Currently the default configuration may not function as expected on all platforms.
     *
     * @var \Xorgconf\Sections\MonitorSection $monitor
     */
    private $monitor;

    /**
     * Specifies which color depth the server should use by default. The −depth command line option can be used to
     * override this. If neither is specified, the default depth is driver−specific, but in most cases is 8.
     *
     * @var int $defaultDepth
     */
    private $defaultDepth;

    /**
     * Enables XAA (X Acceleration Architecture), a mechanism that makes video cards’ 2D hardware acceleration
     * available to the Xorg server. This option is on by default, but it may be necessary to turn it off if there are
     * bugs in the driver. There are many options to disable specific accelerated operations, listed below. Note that
     * disabling an operation will have no effect if the operation is not accelerated (whether due to lack of support
     * in the hardware or in the driver).
     *
     * @var bool $accel
     */
    private $accel;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Gets the identifier
     *
     * @see \Xorgconf\Sections\ScreenSection::$identifier $identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Sets the identifier
     *
     * @see \Xorgconf\Sections\ScreenSection::$identifier $identifier
     *
     * @param string $identifier
     *
     * @return ScreenSection
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Gets the device
     *
     * @see \Xorgconf\Sections\ScreenSection::$device $device
     *
     * @return DeviceSection
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Sets the device
     *
     * @see \Xorgconf\Sections\ScreenSection::$device $device
     *
     * @param DeviceSection $device
     *
     * @return ScreenSection
     */
    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Gets the monitor
     *
     * @see \Xorgconf\Sections\ScreenSection::$monitor $monitor
     *
     * @return MonitorSection
     */
    public function getMonitor()
    {
        return $this->monitor;
    }

    /**
     * Sets the monitor
     *
     * @see \Xorgconf\Sections\ScreenSection::$monitor $monitor
     *
     * @param MonitorSection $monitor
     *
     * @return ScreenSection
     */
    public function setMonitor($monitor)
    {
        $this->monitor = $monitor;

        return $this;
    }

    /**
     * Gets the default depth
     *
     * @see \Xorgconf\Sections\ScreenSection::$defaultDepth $defaultDepth
     *
     * @return int
     */
    public function getDefaultDepth()
    {
        return $this->defaultDepth;
    }

    /**
     * Sets the default depth
     *
     * @see \Xorgconf\Sections\ScreenSection::$defaultDepth $defaultDepth
     *
     * @param int $defaultDepth
     *
     * @return ScreenSection
     */
    public function setDefaultDepth($defaultDepth)
    {
        $this->defaultDepth = $defaultDepth;

        return $this;
    }

    /**
     * Gets accel
     *
     * @see \Xorgconf\Sections\ScreenSection::$accel $accel
     *
     * @return boolean
     */
    public function isAccel()
    {
        return $this->accel;
    }

    /**
     * Sets accel
     *
     * @see \Xorgconf\Sections\ScreenSection::$accel $accel
     *
     * @param boolean $accel
     *
     * @return ScreenSection
     */
    public function setAccel($accel)
    {
        $this->accel = $accel;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        if (empty($this->identifier) || empty($this->device) || empty($this->monitor)) {
            return false;
        }

        $this->addBoolOption('Accel', $this->accel);

        return $this->_render(array(
            'Identifier'   => $this->identifier,
            'Device'       => $this->device->getIdentifier(),
            'Monitor'      => (!empty($this->monitor)) ? $this->monitor->getIdentifier() : null,
            'DefaultDepth' => (string)$this->defaultDepth,
        ));
    }
}
