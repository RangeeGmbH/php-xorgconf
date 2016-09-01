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

/**
 * The config file may have multiple InputClass sections. These sections are optional and are used to provide
 * configuration for a class of input devices as they are automatically added. An input device can match more than one
 * InputClass section. Each class can override settings from a previous class, so it is best to arrange the sections
 * with the most generic matches first.
 *
 * When an input device is automatically added, its characteristics are checked against all InputClass sections. Each
 * section can contain optional entries to narrow the match of the class. If none of the optional entries appear, the
 * InputClass section is generic and will match any input device. If more than one of these entries appear, they all
 * must match for the configuration to apply.
 *
 * An entry can be constructed to match attributes from different devices by separating arguments with a ’|’ character.
 * Multiple entries of the same type may be supplied to add multiple matching conditions on the same attribute.
 *
 * @package Xorgconf\Sections
 */
class InputClassSection extends InputDeviceSection
{
    const SECTION_NAME = 'InputClass';

    /**
     * This entry can be used to check if the substring "matchproduct" occurs in the device’s product name.
     *
     * @var string $matchProduct
     */
    private $matchProduct;

    /**
     * This entry can be used to check if the substring "matchvendor" occurs in the device’s vendor name.
     *
     * @var string $matchVendor
     */
    private $matchVendor;

    /**
     * This entry can be used to check if the device file matches the "matchdevice" pathname pattern.
     *
     * @var string $matchDevicePath
     */
    private $matchDevicePath;

    /**
     * This entry can be used to check if the operating system matches the case-insensitive "matchos" string. This
     * entry is only supported on platforms providing the uname(2) system call.
     *
     * @var string $matchOs
     */
    private $matchOs;

    /**
     * The device’s Plug and Play (PnP) ID can be checked against the "matchpnp" shell wildcard pattern.
     *
     * @var string $matchPnpId
     */
    private $matchPnpId;

    /**
     * The device’s USB ID can be checked against the "matchusb" shell wildcard pattern. The ID is constructed as
     * lowercase hexadecimal numbers separated by a ’:’. This is the same format as the lsusb(8) program.
     *
     * @var string $matchUsbId
     */
    private $matchUsbId;

    /**
     * Check the case-sensitive string "matchdriver" against the currently configured driver of the device. Ordering of
     * sections using this entry is important since it will not match unless the driver has been set by the config
     * backend or a previous InputClass section.
     *
     * @var string $matchDriver
     */
    private $matchDriver;

    /**
     * This entry can be used to check if tags assigned by the config backend matches the "matchtag" pattern. A match
     * is found if at least one of the tags given in "matchtag" matches at least one of the tags assigned by the
     * backend.
     *
     * @var string $matchTag
     */
    private $matchTag;

    /**
     * Check the case-sensitive string "matchlayout" against the currently active ServerLayout section. The empty
     * string "" matches an implicit layout which appears if no named ServerLayout sections have been found.
     *
     * @var string $matchLayout
     */
    private $matchLayout;

    /**
     * @var bool
     */
    private $matchIsKeyboard;
    private $matchIsPointer;
    private $matchIsJoystick;
    private $matchIsTablet;
    private $matchIsTouchpad;
    private $matchIsTouchscreen;

    /**
     * This optional entry specifies that the device should be ignored entirely, and not added to the server. This can
     * be useful when the device is handled by another program and no X events should be generated.
     *
     * @var bool $ignore
     */
    private $ignore;

    /**
     * Gets matchProduct
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchProduct $matchProduct
     *
     * @return string
     */
    public function getMatchProduct()
    {
        return $this->matchProduct;
    }

    /**
     * Sets matchProduct
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchProduct $matchProduct
     *
     * @param string $matchProduct
     *
     * @return InputClassSection
     */
    public function setMatchProduct($matchProduct)
    {
        $this->matchProduct = $matchProduct;

        return $this;
    }

    /**
     * Gets matchVendor
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchVendor $matchVendor
     *
     * @return string
     */
    public function getMatchVendor()
    {
        return $this->matchVendor;
    }

    /**
     * Sets matchVendor
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchVendor $matchVendor
     *
     * @param string $matchVendor
     *
     * @return InputClassSection
     */
    public function setMatchVendor($matchVendor)
    {
        $this->matchVendor = $matchVendor;

        return $this;
    }

    /**
     * Gets matchDevicePath
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchDevicePath $matchDevicePath
     *
     * @return string
     */
    public function getMatchDevicePath()
    {
        return $this->matchDevicePath;
    }

    /**
     * Sets matchDevicePath
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchDevicePath $matchDevicePath
     *
     * @param string $matchDevicePath
     *
     * @return InputClassSection
     */
    public function setMatchDevicePath($matchDevicePath)
    {
        $this->matchDevicePath = $matchDevicePath;

        return $this;
    }

    /**
     * Gets matchOs
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchOs $matchOs
     *
     * @return string
     */
    public function getMatchOs()
    {
        return $this->matchOs;
    }

    /**
     * Sets matchOs
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchOs $matchOs
     *
     * @param string $matchOs
     *
     * @return InputClassSection
     */
    public function setMatchOs($matchOs)
    {
        $this->matchOs = $matchOs;

        return $this;
    }

    /**
     * Gets matchPnpId
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchPnpId $matchPnpId
     *
     * @return string
     */
    public function getMatchPnpId()
    {
        return $this->matchPnpId;
    }

    /**
     * Sets matchPnpId
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchPnpId $matchPnpId
     *
     * @param string $matchPnpId
     *
     * @return InputClassSection
     */
    public function setMatchPnpId($matchPnpId)
    {
        $this->matchPnpId = $matchPnpId;

        return $this;
    }

    /**
     * Gets matchUsbId
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchUsbId $matchUsbId
     *
     * @return string
     */
    public function getMatchUsbId()
    {
        return $this->matchUsbId;
    }

    /**
     * Sets matchUsbId
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchUsbId $matchUsbId
     *
     * @param string $matchUsbId
     *
     * @return InputClassSection
     */
    public function setMatchUsbId($matchUsbId)
    {
        $this->matchUsbId = $matchUsbId;

        return $this;
    }

    /**
     * Gets matchDriver
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchDriver $matchDriver
     *
     * @return string
     */
    public function getMatchDriver()
    {
        return $this->matchDriver;
    }

    /**
     * Sets matchDriver
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchDriver $matchDriver
     *
     * @param string $matchDriver
     *
     * @return InputClassSection
     */
    public function setMatchDriver($matchDriver)
    {
        $this->matchDriver = $matchDriver;

        return $this;
    }

    /**
     * Gets matchTag
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchTag $matchTag
     *
     * @return string
     */
    public function getMatchTag()
    {
        return $this->matchTag;
    }

    /**
     * Sets matchTag
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchTag $matchTag
     *
     * @param string $matchTag
     *
     * @return InputClassSection
     */
    public function setMatchTag($matchTag)
    {
        $this->matchTag = $matchTag;

        return $this;
    }

    /**
     * Gets matchLayout
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchLayout $matchLayout
     *
     * @return string
     */
    public function getMatchLayout()
    {
        return $this->matchLayout;
    }

    /**
     * Sets matchLayout
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchLayout $matchLayout
     *
     * @param string $matchLayout
     *
     * @return InputClassSection
     */
    public function setMatchLayout($matchLayout)
    {
        $this->matchLayout = $matchLayout;

        return $this;
    }

    /**
     * Gets matchIsKeyboard
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsKeyboard $matchIsKeyboard
     *
     * @return boolean
     */
    public function isMatchIsKeyboard()
    {
        return $this->matchIsKeyboard;
    }

    /**
     * Sets matchIsKeyboard
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsKeyboard $matchIsKeyboard
     *
     * @param boolean $matchIsKeyboard
     *
     * @return InputClassSection
     */
    public function setMatchIsKeyboard($matchIsKeyboard)
    {
        $this->matchIsKeyboard = $matchIsKeyboard;

        return $this;
    }

    /**
     * Gets matchIsPointer
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsPointer $matchIsPointer
     *
     * @return mixed
     */
    public function getMatchIsPointer()
    {
        return $this->matchIsPointer;
    }

    /**
     * Sets matchIsPointer
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsPointer $matchIsPointer
     *
     * @param mixed $matchIsPointer
     *
     * @return InputClassSection
     */
    public function setMatchIsPointer($matchIsPointer)
    {
        $this->matchIsPointer = $matchIsPointer;

        return $this;
    }

    /**
     * Gets matchIsJoystick
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsJoystick $matchIsJoystick
     *
     * @return mixed
     */
    public function getMatchIsJoystick()
    {
        return $this->matchIsJoystick;
    }

    /**
     * Sets matchIsJoystick
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsJoystick $matchIsJoystick
     *
     * @param mixed $matchIsJoystick
     *
     * @return InputClassSection
     */
    public function setMatchIsJoystick($matchIsJoystick)
    {
        $this->matchIsJoystick = $matchIsJoystick;

        return $this;
    }

    /**
     * Gets matchIsTablet
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsTablet $matchIsTablet
     *
     * @return mixed
     */
    public function getMatchIsTablet()
    {
        return $this->matchIsTablet;
    }

    /**
     * Sets matchIsTablet
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsTablet $matchIsTablet
     *
     * @param mixed $matchIsTablet
     *
     * @return InputClassSection
     */
    public function setMatchIsTablet($matchIsTablet)
    {
        $this->matchIsTablet = $matchIsTablet;

        return $this;
    }

    /**
     * Gets matchIsTouchpad
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsTouchpad $matchIsTouchpad
     *
     * @return mixed
     */
    public function getMatchIsTouchpad()
    {
        return $this->matchIsTouchpad;
    }

    /**
     * Sets matchIsTouchpad
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsTouchpad $matchIsTouchpad
     *
     * @param mixed $matchIsTouchpad
     *
     * @return InputClassSection
     */
    public function setMatchIsTouchpad($matchIsTouchpad)
    {
        $this->matchIsTouchpad = $matchIsTouchpad;

        return $this;
    }

    /**
     * Gets matchIsTouchscreen
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsTouchscreen $matchIsTouchscreen
     *
     * @return mixed
     */
    public function getMatchIsTouchscreen()
    {
        return $this->matchIsTouchscreen;
    }

    /**
     * Sets matchIsTouchscreen
     *
     * @see \Xorgconf\Sections\InputClassSection::$matchIsTouchscreen $matchIsTouchscreen
     *
     * @param mixed $matchIsTouchscreen
     *
     * @return InputClassSection
     */
    public function setMatchIsTouchscreen($matchIsTouchscreen)
    {
        $this->matchIsTouchscreen = $matchIsTouchscreen;

        return $this;
    }

    /**
     * Gets ignore
     *
     * @see \Xorgconf\Sections\InputClassSection::$ignore $ignore
     *
     * @return boolean
     */
    public function isIgnore()
    {
        return $this->ignore;
    }

    /**
     * Sets ignore
     *
     * @see \Xorgconf\Sections\InputClassSection::$ignore $ignore
     *
     * @param boolean $ignore
     *
     * @return InputClassSection
     */
    public function setIgnore($ignore)
    {
        $this->ignore = $ignore;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        if (empty($this->getIdentifier())) {
            return false;
        }

        $this->addBoolOption('Ignore', $this->ignore);

        return $this->__render(array(
            'MatchProduct'       => $this->matchProduct,
            'MatchVendor'        => $this->matchVendor,
            'MatchDevicePath'    => $this->matchDevicePath,
            'MatchOS'            => $this->matchOs,
            'MatchPnPID'         => $this->matchPnpId,
            'MatchUSBID'         => $this->matchUsbId,
            'MatchDriver'        => $this->matchDriver,
            'MatchTag'           => $this->matchTag,
            'MatchLayout'        => $this->matchLayout,
            'MatchIsKeyboard'    => $this->matchIsKeyboard,
            'MatchIsPointer'     => $this->matchIsPointer,
            'MatchIsJoystick'    => $this->matchIsJoystick,
            'MatchIsTablet'      => $this->matchIsTablet,
            'MatchIsTouchpad'    => $this->matchIsTouchpad,
            'MatchIsTouchscreen' => $this->matchIsTouchscreen,
        ));
    }
}
