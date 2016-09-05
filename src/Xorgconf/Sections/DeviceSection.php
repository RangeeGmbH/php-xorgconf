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
 * The config file may have multiple Device sections. There must be at least one, for the video card being used. The
 * Identifier and Driver entries are required in all Device sections. All other entries are optional.
 *
 * A Device section is considered active if it is referenced by an active Screen section.
 *
 * @package Xorgconf\Sections
 */
class DeviceSection extends Section
{
    const SECTION_NAME = 'Device';

    /**
     * This specifies the unique name for this graphics device.
     *
     * @var string $identifier
     */
    private $identifier;

    /**
     * This specifies the name of the driver to use for this graphics device. When using the loadable server, the
     * driver module "driver" will be loaded for each active Device section.
     *
     * @var string $driver
     */
    private $driver;

    /**
     * This specifies the bus location of the graphics card. For PCI/AGP cards, the bus−id string has the form
     * PCI:bus:device:function (e.g., “PCI:1:0:0” might be appropriate for an AGP card). This field is usually optional
     * in single-head configurations when using the primary graphics card. In multi-head configurations, or when using
     * a secondary graphics card in a single-head configuration, this entry is mandatory. Its main purpose is to make
     * an unambiguous connection between the device section and the hardware it is representing. This information can
     * usually be found by running the pciaccess tool scanpci.
     *
     * @var string $busId
     */
    private $busId;

    /**
     * This option is mandatory for cards where a single PCI entity can drive more than one display (i.e., multiple
     * CRTCs sharing a single graphics accelerator and video memory). One Device section is required for each head, and
     * this parameter determines which head each of the Device sections applies to. The legal values of number range
     * from 0 to one less than the total number of heads per entity. Most drivers require that the primary screen (0)
     * be present.
     *
     * @var int $screen
     */
    private $screen;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Gets the identifier
     *
     * @see \Xorgconf\Sections\DeviceSection::$identifier $identifier
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
     * @see \Xorgconf\Sections\DeviceSection::$identifier $identifier
     *
     * @param string $identifier
     *
     * @return DeviceSection
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Gets the driver
     *
     * @see \Xorgconf\Sections\DeviceSection::$driver $driver
     *
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Sets the driver
     *
     * @see \Xorgconf\Sections\DeviceSection::$driver $driver
     *
     * @param string $driver
     *
     * @return DeviceSection
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Gets the busId
     *
     * @see \Xorgconf\Sections\DeviceSection::$busId $busId
     *
     * @return string
     */
    public function getBusId()
    {
        return $this->busId;
    }

    /**
     * Sets the busId
     *
     * @see \Xorgconf\Sections\DeviceSection::$busId $busId
     *
     * @param string $busId
     *
     * @return DeviceSection
     */
    public function setBusId($busId)
    {
        $this->busId = $busId;

        return $this;
    }

    /**
     * Gets the screen
     *
     * @see \Xorgconf\Sections\DeviceSection::$screen $screen
     *
     * @return int
     */
    public function getScreen()
    {
        return $this->screen;
    }

    /**
     * Sets the screen
     *
     * @see \Xorgconf\Sections\DeviceSection::$screen $screen
     *
     * @param int $screen
     *
     * @return DeviceSection
     */
    public function setScreen($screen)
    {
        $this->screen = $screen;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        if (empty($this->identifier)) {
            return false;
        }

        return $this->_render(array(
            'Identifier' => $this->identifier,
            'Driver'     => $this->driver,
            'BusID'      => $this->busId,
            'Screen'     => (string)$this->screen,
        ));
    }


}
