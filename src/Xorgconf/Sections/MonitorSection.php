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
 * The config file may have multiple Monitor sections. There should normally be at least one, for the monitor being
 * used, but a default configuration will be created when one isn’t specified.
 *
 * With RandR 1.2-enabled drivers, monitor sections may be tied to specific outputs of the video card. Using the name
 * of the output defined by the video driver plus the identifier of a monitor section, one associates a monitor section
 * with an output by adding an option to the Device section in the following format:
 * Option "Monitor-outputname" "monitorsection"
 *
 * @package Xorgconf\Sections
 */
class MonitorSection extends Section
{
    const SECTION_NAME = 'Monitor';

    /**
     * This specifies the unique name for this monitor.
     *
     * @var string $identifier
     */
    private $identifier;

    /**
     * This entry is a more compact version of the Mode entry, and it also can be used to specify video modes for the
     * monitor. This is a single line format for specifying video modes. In most cases this isn’t necessary because the
     * built−in set of VESA standard modes will be sufficient.
     *
     * The mode−description is in four sections, the first three of which are mandatory. The first is the dot (pixel)
     * clock. This is a single number specifying the pixel clock rate for the mode in MHz. The second section is a list
     * of four numbers specifying the horizontal timings. These numbers are the hdisp, hsyncstart, hsyncend, and htotal
     * values. The third section is a list of four numbers specifying the vertical timings. These numbers are the
     * vdisp, vsyncstart, vsyncend, and vtotal values. The final section is a list of flags specifying other
     * characteristics of the mode. Interlace indicates that the mode is interlaced. DoubleScan indicates a mode where
     * each scanline is doubled. +HSync and −HSync can be used to select the polarity of the HSync signal. +VSync and
     * −VSync can be used to select the polarity of the VSync signal. Composite can be used to specify composite sync
     * on hardware where this is supported. Additionally, on some hardware, +CSync and −CSync may be used to select the
     * composite sync polarity. The HSkew and VScan options mentioned above in the Mode entry description can also be
     * used here.
     *
     * @var string $modeLine
     */
    private $modeLine;

    /**
     * This optional entry specifies that the monitor should be treated as the primary monitor. (RandR 1.2-supporting
     * drivers only)
     *
     * @var bool $primary
     */
    private $primary;

    /**
     * This optional entry specifies a mode to be marked as the preferred initial mode of the monitor. (RandR
     * 1.2-supporting drivers only)
     *
     * @var string $preferredMode
     */
    private $preferredMode;

    /**
     * This optional entry specifies the X position of the monitor within the X screen. (RandR 1.2-supporting drivers
     * only)
     *
     * @var int $positionX
     */
    private $positionX;

    /**
     * This optional entry specifies the Y position of the monitor within the X screen. (RandR 1.2-supporting drivers
     * only)
     *
     * @var int $positionY
     */
    private $positionY;

    /**
     * This optional entry specifies that the monitor should be positioned to the left of the output (not monitor) of
     * the given name. (RandR 1.2-supporting drivers only)
     *
     * @var string $leftOf
     */
    private $leftOf;

    /**
     * This optional entry specifies that the monitor should be positioned to the right of the output (not monitor) of
     * the given name. (RandR 1.2-supporting drivers only)
     *
     * @var string $rightOf
     */
    private $rightOf;

    /**
     * This optional entry specifies that the monitor should be positioned above the output (not monitor) of the given
     * name. (RandR 1.2-supporting drivers only)
     *
     * @var string $above
     */
    private $above;

    /**
     * This optional entry specifies that the monitor should be positioned below the output (not monitor) of the given
     * name. (RandR 1.2-supporting drivers only)
     *
     * @var string $below
     */
    private $below;

    /**
     * This optional entry specifies whether the monitor should be turned on at startup. By default, the server will
     * attempt to enable all connected monitors. (RandR 1.2-supporting drivers only)
     *
     * @var bool $enable
     */
    private $enable;

    /**
     * This optional entry specifies that the monitor should be ignored entirely, and not reported through RandR. This
     * is useful if the hardware reports the presence of outputs that don’t exist. (RandR 1.2-supporting drivers only)
     *
     * @var bool $ignore
     */
    private $ignore;

    /**
     * This optional entry specifies the initial rotation of the given monitor. Valid values for rotation are "normal",
     * "left", "right", and "inverted". (RandR 1.2-supporting drivers only)
     *
     * @var string $rotate
     */
    private $rotate;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Gets the mode line
     *
     * @see \Xorgconf\Sections\MonitorSection::$modeLine $modeLine
     *
     * @return string
     */
    public function getModeLine()
    {
        return $this->modeLine;
    }

    /**
     * Sets the mode line
     *
     * @see \Xorgconf\Sections\MonitorSection::$modeLine $modeLine
     *
     * @param string $modeLine
     *
     * @return MonitorSection
     */
    public function setModeLine($modeLine)
    {
        $this->modeLine = $modeLine;

        return $this;
    }

    /**
     * Gets primary
     *
     * @see \Xorgconf\Sections\MonitorSection::$primary $primary
     *
     * @return boolean
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * Sets primary
     *
     * @see \Xorgconf\Sections\MonitorSection::$primary $primary
     *
     * @param boolean $primary
     *
     * @return MonitorSection
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;

        return $this;
    }

    /**
     * Gets the preferred mode
     *
     * @see \Xorgconf\Sections\MonitorSection::$preferredMode $preferredMode
     *
     * @return string
     */
    public function getPreferredMode()
    {
        return $this->preferredMode;
    }

    /**
     * Sets the preferred mode
     *
     * @see \Xorgconf\Sections\MonitorSection::$preferredMode $preferredMode
     *
     * @param string $preferredMode
     *
     * @return MonitorSection
     */
    public function setPreferredMode($preferredMode)
    {
        $this->preferredMode = $preferredMode;

        return $this;
    }

    /**
     * Gets the X position
     *
     * @see \Xorgconf\Sections\MonitorSection::$positionX $positionX
     *
     * @return int
     */
    public function getPositionX()
    {
        return $this->positionX;
    }

    /**
     * Sets the X position
     *
     * @see \Xorgconf\Sections\MonitorSection::$positionX $positionX
     *
     * @param int $positionX
     *
     * @return MonitorSection
     */
    public function setPositionX($positionX)
    {
        $this->positionX = $positionX;

        return $this;
    }

    /**
     * Gets the Y position
     *
     * @see \Xorgconf\Sections\MonitorSection::$positionY $positionY
     *
     * @return int
     */
    public function getPositionY()
    {
        return $this->positionY;
    }

    /**
     * Sets the Y position
     *
     * @see \Xorgconf\Sections\MonitorSection::$positionY $positionY
     *
     * @param int $positionY
     *
     * @return MonitorSection
     */
    public function setPositionY($positionY)
    {
        $this->positionY = $positionY;

        return $this;
    }

    /**
     * Gets leftOf
     *
     * @see \Xorgconf\Sections\MonitorSection::$leftOf $leftOf
     *
     * @return string
     */
    public function getLeftOf()
    {
        return $this->leftOf;
    }

    /**
     * Sets leftOf
     *
     * @see \Xorgconf\Sections\MonitorSection::$leftOf $leftOf
     *
     * @param string $leftOf
     *
     * @return MonitorSection
     */
    public function setLeftOf($leftOf)
    {
        $this->leftOf = $leftOf;

        return $this;
    }

    /**
     * Gets rightOf
     *
     * @see \Xorgconf\Sections\MonitorSection::$rightOf $rightOf
     *
     * @return string
     */
    public function getRightOf()
    {
        return $this->rightOf;
    }

    /**
     * Sets rightOf
     *
     * @see \Xorgconf\Sections\MonitorSection::$rightOf $rightOf
     *
     * @param string $rightOf
     *
     * @return MonitorSection
     */
    public function setRightOf($rightOf)
    {
        $this->rightOf = $rightOf;

        return $this;
    }

    /**
     * Gets above
     *
     * @see \Xorgconf\Sections\MonitorSection::$above $above
     *
     * @return string
     */
    public function getAbove()
    {
        return $this->above;
    }

    /**
     * Sets above
     *
     * @see \Xorgconf\Sections\MonitorSection::$above $above
     *
     * @param string $above
     *
     * @return MonitorSection
     */
    public function setAbove($above)
    {
        $this->above = $above;

        return $this;
    }

    /**
     * Gets below
     *
     * @see \Xorgconf\Sections\MonitorSection::$below $below
     *
     * @return string
     */
    public function getBelow()
    {
        return $this->below;
    }

    /**
     * Sets below
     *
     * @see \Xorgconf\Sections\MonitorSection::$below $below
     *
     * @param string $below
     *
     * @return MonitorSection
     */
    public function setBelow($below)
    {
        $this->below = $below;

        return $this;
    }

    /**
     * Gets enable
     *
     * @see \Xorgconf\Sections\MonitorSection::$enable $enable
     *
     * @return boolean
     */
    public function isEnable()
    {
        return $this->enable;
    }

    /**
     * Sets enable
     *
     * @see \Xorgconf\Sections\MonitorSection::$enable $enable
     *
     * @param boolean $enable
     *
     * @return MonitorSection
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Gets ignore
     *
     * @see \Xorgconf\Sections\MonitorSection::$ignore $ignore
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
     * @see \Xorgconf\Sections\MonitorSection::$ignore $ignore
     *
     * @param boolean $ignore
     *
     * @return MonitorSection
     */
    public function setIgnore($ignore)
    {
        $this->ignore = $ignore;

        return $this;
    }

    /**
     * Gets rotation
     *
     * @see \Xorgconf\Sections\MonitorSection::$rotate $rotate
     *
     * @return string
     */
    public function getRotate()
    {
        return $this->rotate;
    }

    /**
     * Sets rotation
     *
     * @see \Xorgconf\Sections\MonitorSection::$rotate $rotate
     *
     * @param string $rotate
     *
     * @return MonitorSection
     */
    public function setRotate($rotate)
    {
        $this->rotate = $rotate;

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

        $this->addOption('Primary', $this->primary);
        $this->addOption('PreferredMode', $this->preferredMode);
        $this->addOption('LeftOf', $this->leftOf);
        $this->addOption('RightOf', $this->rightOf);
        $this->addOption('Above', $this->above);
        $this->addOption('Below', $this->below);
        $this->addOption('Enable', $this->enable);
        $this->addOption('Ignore', $this->ignore);
        $this->addOption('Rotate', $this->rotate);

        if (isset($this->positionX, $this->positionY)) {
            $this->addOption('Position', (string)$this->positionX . ' ' . (string)$this->positionY);
        }

        return $this->_render(array(
            'Identifier' => $this->identifier,
            'ModeLine'   => $this->modeLine,
        ));
    }

    /**
     * Gets the identifier
     *
     * @see \Xorgconf\Sections\MonitorSection::$identifier $identifier
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
     * @see \Xorgconf\Sections\MonitorSection::$identifier $identifier
     *
     * @param string $identifier
     *
     * @return MonitorSection
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }
}
