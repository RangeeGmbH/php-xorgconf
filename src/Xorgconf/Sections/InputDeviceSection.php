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
 * The config file may have multiple InputDevice sections. Recent X servers employ HAL or udev backends for input
 * device enumeration and input hotplugging. It is usually not necessary to provide InputDevice sections in the
 * xorg.conf if hotplugging is in use (i.e. AutoAddDevices is enabled). If hotplugging is enabled, InputDevice sections
 * using the mouse, kbd and vmmouse driver will be ignored.
 *
 * If hotplugging is disabled, there will normally be at least two: one for the core (primary) keyboard and one for the
 * core pointer. If either of these two is missing, a default configuration for the missing ones will be used. In the
 * absence of an explicitly specified core input device, the first InputDevice marked as CorePointer (or CoreKeyboard)
 * is used. If there is no match there, the first InputDevice that uses the “mouse” (or “kbd”) driver is used. The
 * final fallback is to use built−in default configurations. Currently the default configuration may not work as
 * expected on all platforms.
 *
 * An InputDevice section is considered active if it is referenced by an active ServerLayout section, if it is
 * referenced by the −keyboard or −pointer command line options, or if it is selected implicitly as the core pointer or
 * keyboard device in the absence of such explicit references.
 *
 * @package Xorgconf\Sections
 */
class InputDeviceSection extends Section
{
    const SECTION_NAME = 'InputDevice';

    /**
     * This specifies the unique name for this input device.
     *
     * @var string $identifier
     */
    private $identifier;

    /**
     * This specifies the name of the driver to use for this input device. When using the loadable server, the
     * driver module "inputdriver" will be loaded for each active InputDevice section. The most commonly used input
     * drivers are evdev(4) on Linux systems, and kbd(4) and mousedrv(4) on other platforms.
     *
     * @var string $driver
     */
    private $driver;

    /**
     * Always add the device to the ServerLayout section used by this instance of the server. This affects implied
     * layouts as well as explicit layouts specified in the configuration and/or on the command line.
     *
     * @var bool $autoServerLayout
     */
    private $autoServerLayout;

    /**
     * When enabled, the input device is set up floating and does not report events through any master device or
     * control a cursor. The device is only available to clients using the X Input Extension API. This option is
     * disabled by default.
     *
     * This option controls the startup behavior only, a device may be reattached or set floating at runtime.
     *
     * @var bool $floating
     */
    private $floating;

    /**
     * Specifies the 3x3 transformation matrix for absolute input devices. The input device will be bound to the area
     * given in the matrix. In most configurations, "a" and "e" specify the width and height of the area the device is
     * bound to, and "c" and "f" specify the x and y offset of the area. The value range is 0 to 1, where 1 represents
     * the width or height of all root windows together, 0.5 represents half the area, etc. The values represent a 3x3
     * matrix, with the first, second and third group of three values representing the first, second and third row of
     * the matrix, respectively. The identity matrix is "1 0 0 0 1 0 0 0 1".
     *
     * @var string $transformationMatrix
     */
    private $transformationMatrix;

    /**
     * Select the profile. In layman’s terms, the profile constitutes the "feeling" of the acceleration. More formally,
     * it defines how the transfer function (actual acceleration as a function of current device velocity and
     * acceleration controls) is constructed. This is mainly a matter of personal preference.
     *
     *  0: classic (mostly compatible)
     * -1: none (only constant deceleration is applied)
     *  1: device-dependent
     *  2: polynomial (polynomial function)
     *  3: smooth linear (soft knee, then linear)
     *  4: simple (normal when slow, otherwise accelerated)
     *  5: power (power function)
     *  6: linear (more speed, more acceleration)
     *  7: limited (like linear, but maxes out at threshold)
     *
     * @var int $accelerationProfile
     */
    private $accelerationProfile;

    /**
     * Makes the pointer go deceleration times slower than normal. Most useful for high-resolution devices.
     *
     * @var double $constantDeceleration
     */
    private $constantDeceleration;

    /**
     * Allows to actually decelerate the pointer when going slow. At most, it will be adaptive deceleration times
     * slower. Enables precise pointer placement without sacrificing speed.
     *
     * @var double $adaptiveDeceleration
     */
    private $adaptiveDeceleration;

    /**
     * Selects the scheme, which is the underlying algorithm.
     *
     * predictable: default algorithm (behaving more predictable)
     * lightweight: old acceleration code (as specified in the X protocol spec)
     *        none: no acceleration or deceleration
     *
     * @var string $accelerationScheme
     */
    private $accelerationScheme;

    /**
     * Sets the numerator of the acceleration factor. The acceleration factor is a rational which, together with
     * threshold, can be used to tweak profiles to suit the users needs. The simple and limited profiles use it
     * directly (i.e. they accelerate by the factor), for other profiles it should hold that a higher acceleration
     * factor leads to a faster pointer. Typically, 1 is unaccelerated and values up to 5 are sensible.
     *
     * @var int $accelerationNumerator
     */
    private $accelerationNumerator;

    /**
     * Sets the denominator of the acceleration factor. The acceleration factor is a rational which, together with
     * threshold, can be used to tweak profiles to suit the users needs. The simple and limited profiles use it
     * directly (i.e. they accelerate by the factor), for other profiles it should hold that a higher acceleration
     * factor leads to a faster pointer. Typically, 1 is unaccelerated and values up to 5 are sensible.
     *
     * @var int $accelerationDenominator
     */
    private $accelerationDenominator;

    /**
     * Set the threshold, which is roughly the velocity (usually device units per 10 ms) required for acceleration to
     * become effective. The precise effect varies with the profile however.
     *
     * @var int $accelerationThreshold
     */
    private $accelerationThreshold;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Gets the identifier
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$identifier $identifier
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
     * @see \Xorgconf\Sections\InputDeviceSection::$identifier $identifier
     *
     * @param string $identifier
     *
     * @return InputDeviceSection
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Gets the driver
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$driver $driver
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
     * @see \Xorgconf\Sections\InputDeviceSection::$driver $driver
     *
     * @param string $driver
     *
     * @return InputDeviceSection
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Gets autoServerLayout
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$autoServerLayout $autoServerLayout
     *
     * @return boolean
     */
    public function isAutoServerLayout()
    {
        return $this->autoServerLayout;
    }

    /**
     * Sets autoServerLayout
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$autoServerLayout $autoServerLayout
     *
     * @param boolean $autoServerLayout
     *
     * @return InputDeviceSection
     */
    public function setAutoServerLayout($autoServerLayout)
    {
        $this->autoServerLayout = $autoServerLayout;

        return $this;
    }

    /**
     * Gets floating
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$floating $floating
     *
     * @return boolean
     */
    public function isFloating()
    {
        return $this->floating;
    }

    /**
     * Sets floating
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$floating $floating
     *
     * @param boolean $floating
     *
     * @return InputDeviceSection
     */
    public function setFloating($floating)
    {
        $this->floating = $floating;

        return $this;
    }

    /**
     * Gets the transformation matrix
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$transformationMatrix $transformationMatrix
     *
     * @return string
     */
    public function getTransformationMatrix()
    {
        return $this->transformationMatrix;
    }

    /**
     * Sets the transformation matrix
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$transformationMatrix $transformationMatrix
     *
     * @param string $transformationMatrix
     *
     * @return InputDeviceSection
     */
    public function setTransformationMatrix($transformationMatrix)
    {
        $this->transformationMatrix = $transformationMatrix;

        return $this;
    }

    /**
     * Gets the acceleration profile
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationProfile $accelerationProfile
     *
     * @return int
     */
    public function getAccelerationProfile()
    {
        return $this->accelerationProfile;
    }

    /**
     * Sets the acceleration profile
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationProfile $accelerationProfile
     *
     * @param int $accelerationProfile
     *
     * @return InputDeviceSection
     */
    public function setAccelerationProfile($accelerationProfile)
    {
        $this->accelerationProfile = $accelerationProfile;

        return $this;
    }

    /**
     * Gets the constant deceleration
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$constantDeceleration $constantDeceleration
     *
     * @return float
     */
    public function getConstantDeceleration()
    {
        return $this->constantDeceleration;
    }

    /**
     * Sets the constant deceleration
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$constantDeceleration $constantDeceleration
     *
     * @param float $constantDeceleration
     *
     * @return InputDeviceSection
     */
    public function setConstantDeceleration($constantDeceleration)
    {
        $this->constantDeceleration = $constantDeceleration;

        return $this;
    }

    /**
     * Gets the adaptive deceleration
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$adaptiveDeceleration $adaptiveDeceleration
     *
     * @return float
     */
    public function getAdaptiveDeceleration()
    {
        return $this->adaptiveDeceleration;
    }

    /**
     * Sets the adaptive deceleration
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$adaptiveDeceleration $adaptiveDeceleration
     *
     * @param float $adaptiveDeceleration
     *
     * @return InputDeviceSection
     */
    public function setAdaptiveDeceleration($adaptiveDeceleration)
    {
        $this->adaptiveDeceleration = $adaptiveDeceleration;

        return $this;
    }

    /**
     * Gets the acceleration scheme
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationScheme $accelerationScheme
     *
     * @return string
     */
    public function getAccelerationScheme()
    {
        return $this->accelerationScheme;
    }

    /**
     * Sets the acceleration scheme
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationScheme $accelerationScheme
     *
     * @param string $accelerationScheme
     *
     * @return InputDeviceSection
     */
    public function setAccelerationScheme($accelerationScheme)
    {
        $this->accelerationScheme = $accelerationScheme;

        return $this;
    }

    /**
     * Gets the acceleration numerator
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationNumerator $accelerationNumerator
     *
     * @return int
     */
    public function getAccelerationNumerator()
    {
        return $this->accelerationNumerator;
    }

    /**
     * Sets the acceleration numerator
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationNumerator $accelerationNumerator
     *
     * @param int $accelerationNumerator
     *
     * @return InputDeviceSection
     */
    public function setAccelerationNumerator($accelerationNumerator)
    {
        $this->accelerationNumerator = $accelerationNumerator;

        return $this;
    }

    /**
     * Gets the acceleration denominator
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationDenominator $accelerationDenominator
     *
     * @return int
     */
    public function getAccelerationDenominator()
    {
        return $this->accelerationDenominator;
    }

    /**
     * Sets the acceleration denominator
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationDenominator $accelerationDenominator
     *
     * @param int $accelerationDenominator
     *
     * @return InputDeviceSection
     */
    public function setAccelerationDenominator($accelerationDenominator)
    {
        $this->accelerationDenominator = $accelerationDenominator;

        return $this;
    }

    /**
     * Gets the acceleration threshold
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationThreshold $accelerationThreshold
     *
     * @return int
     */
    public function getAccelerationThreshold()
    {
        return $this->accelerationThreshold;
    }

    /**
     * Sets the acceleration threshold
     *
     * @see \Xorgconf\Sections\InputDeviceSection::$accelerationThreshold $accelerationThreshold
     *
     * @param int $accelerationThreshold
     *
     * @return InputDeviceSection
     */
    public function setAccelerationThreshold($accelerationThreshold)
    {
        $this->accelerationThreshold = $accelerationThreshold;

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

        return $this->__render(array());
    }

    protected function __render($entries)
    {
        $this->addOption('AutoServerLayout', $this->autoServerLayout);
        $this->addOption('Floating', $this->floating);
        $this->addOption('TransformationMatrix', $this->transformationMatrix);
        $this->addOption('AccelerationProfile', $this->accelerationProfile);
        $this->addOption('ConstantDeceleration', $this->constantDeceleration);
        $this->addOption('AdaptiveDeceleration', $this->adaptiveDeceleration);
        $this->addOption('AccelerationScheme', $this->accelerationScheme);
        $this->addOption('AccelerationNumerator', $this->accelerationNumerator);
        $this->addOption('AccelerationDenominator', $this->accelerationDenominator);
        $this->addOption('AccelerationThreshold', $this->accelerationThreshold);

        $myEntries = array(
            'Identifier' => $this->identifier,
            'Driver'     => $this->driver,
        );

        $entries = array_merge($myEntries, $entries);

        return $this->_render($entries);
    }
}
