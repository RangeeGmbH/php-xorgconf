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
 * The config file may have multiple ServerLayout sections. A “server layout” represents the binding of one or more
 * screens (Screen sections) and one or more input devices (InputDevice sections) to form a complete configuration. In
 * multi−head configurations, it also specifies the relative layout of the heads. A ServerLayout section is considered
 * “active” if it is referenced by the −layout command line option or by an Option "DefaultServerLayout" entry in the
 * ServerFlags section (the former takes precedence over the latter). If those options are not used, the first
 * ServerLayout section found in the config file is considered the active one. If no ServerLayout sections are present,
 * the single active screen and two active (core) input devices are selected.
 *
 * The ServerLayout section provides information specific to the whole session, including session−specific Options. The
 * ServerFlags options may be specified here, and ones given here override those given in the ServerFlags section.
 *
 * @package Xorgconf\Sections
 */
class ServerLayoutSection extends Section
{
    const SECTION_NAME = 'ServerLayout';

    /**
     * This specifies the unique name for this server layout.
     *
     * @var string $identifier
     */
    private $identifier;

    /**
     * One of these entries must be given for each screen being used in a session. The screen−id field is mandatory,
     * and specifies the Screen section being referenced.
     *
     * @var \Xorgconf\Sections\ScreenSection[] $screens
     */
    private $screens;

    /**
     * One of these entries should be given for each input device being used in a session. Normally at least two are
     * required, one each for the core pointer and keyboard devices. If either of those is missing, suitable
     * InputDevice entries are searched for using the method described above in the INPUTDEVICE section. The idev−id
     * field is mandatory, and specifies the name of the InputDevice section being referenced.
     *
     * @var \Xorgconf\Sections\InputDeviceSection[] $inputDevices
     */
    private $inputDevices;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Gets the identifier
     *
     * @see \Xorgconf\Sections\ServerLayoutSection::$identifier $identifier
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
     * @see \Xorgconf\Sections\ServerLayoutSection::$identifier $identifier
     *
     * @param string $identifier
     *
     * @return ServerLayoutSection
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Gets array of screens
     *
     * @see \Xorgconf\Sections\ServerLayoutSection::$screens $screens
     *
     * @return ScreenSection[]
     */
    public function getScreens()
    {
        return $this->screens;
    }

    /**
     * Sets array of screens
     *
     * @see \Xorgconf\Sections\ServerLayoutSection::$screens $screens
     *
     * @param ScreenSection[] $screens
     *
     * @return ServerLayoutSection
     */
    public function setScreens($screens)
    {
        $this->screens = $screens;

        return $this;
    }

    /**
     * Adds a screen to the array of screens
     *
     * @see \Xorgconf\Sections\ServerLayoutSection::$screens $screens
     *
     * @param ScreenSection $screen
     *
     * @return ServerLayoutSection
     */
    public function addScreen($screen)
    {
        $this->screens[] = $screen;

        return $this;
    }

    /**
     * Gets array of input devices
     *
     * @see \Xorgconf\Sections\ServerLayoutSection::$inputDevices $inputDevices
     *
     * @return InputDeviceSection[]
     */
    public function getInputDevices()
    {
        return $this->inputDevices;
    }

    /**
     * Sets array of input devices
     *
     * @see \Xorgconf\Sections\ServerLayoutSection::$inputDevices $inputDevices
     *
     * @param InputDeviceSection[] $inputDevices
     *
     * @return ServerLayoutSection
     */
    public function setInputDevices($inputDevices)
    {
        $this->inputDevices = $inputDevices;

        return $this;
    }

    /**
     * Adds an input device to the array of input devices
     *
     * @see \Xorgconf\Sections\ServerLayoutSection::$inputDevices $inputDevices
     *
     * @param InputDeviceSection $inputDevice
     *
     * @return ServerLayoutSection
     */
    public function addInputDevice($inputDevice)
    {
        $this->inputDevices[] = $inputDevice;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        if (empty($this->identifier) || empty($this->screens)) {
            return false;
        }

        $screenIds = array();
        foreach ($this->screens as $screen) {
            $screenIds[] = $screen->getIdentifier();
        }

        $inputDeviceIds = array();
        foreach ($this->inputDevices as $inputDevice) {
            $inputDeviceIds[] = $inputDevice->getIdentifier();
        }

        return $this->_render(array(
            'Identifier'  => $this->identifier,
            'Screen'      => $screenIds,
            'InputDevice' => $inputDeviceIds,
        ));
    }
}
