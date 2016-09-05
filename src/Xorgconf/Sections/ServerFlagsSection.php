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
 * In addition to options specific to this section, the ServerFlags section is used to specify some global Xorg server
 * options. The ServerFlags section is optional, as are the entries that may be specified in it.
 *
 * Options specified in this section (with the exception of the "DefaultServerLayout" Option) may be overridden by
 * Options specified in the active ServerLayout section. Options with command line equivalents are overridden when
 * their command line equivalent is used.
 *
 * @package Xorgconf\Sections
 */
class ServerFlagsSection extends Section
{
    const SECTION_NAME = 'ServerFlags';

    /**
     * This specifies the default ServerLayout section to use in the absence of the −layout command line option.
     *
     * @var string $defaultServerLayout
     */
    private $defaultServerLayout;

    /**
     * This prevents the Xorg server from trapping a range of unexpected fatal signals and exiting cleanly. Instead,
     * the Xorg server will die and drop core where the fault occurred. The default behaviour is for the Xorg server to
     * exit cleanly, but still drop a core file. In general you never want to use this option unless you are debugging
     * an Xorg server problem and know how to deal with the consequences.
     *
     * @var bool $noTrapSignals
     */
    private $noTrapSignals;

    /**
     * This controls whether the Xorg server requests that events from input devices be reported via a SIGIO signal
     * handler (also known as SIGPOLL on some platforms), or only reported via the standard select(3) loop. The default
     * behaviour is platform specific. In general you do not want to use this option unless you are debugging the Xorg
     * server, or working around a specific bug until it is fixed, and understand the consequences.
     *
     * @var bool $useSigio
     */
    private $useSigio;

    /**
     * This disallows the use of the Ctrl+Alt+Fn sequence (where Fn refers to one of the numbered function keys). That
     * sequence is normally used to switch to another "virtual terminal" on operating systems that have this feature.
     * When this option is enabled, that key sequence has no special meaning and is passed to clients. Default: off.
     *
     * @var bool $dontVtSwitch
     */
    private $dontVtSwitch;

    /**
     * This disallows the use of the Terminate_Server XKB action (usually on Ctrl+Alt+Backspace, depending on XKB
     * options). This action is normally used to terminate the Xorg server. When this option is enabled, the action has
     * no effect. Default: off.
     *
     * @var bool $dontZap
     */
    private $dontZap;

    /**
     * This disallows the use of the Ctrl+Alt+Keypad−Plus and Ctrl+Alt+Keypad−Minus sequences. These sequences allows
     * you to switch between video modes. When this option is enabled, those key sequences have no special meaning and
     * are passed to clients. Default: off.
     *
     * @var bool $dontZoom
     */
    private $dontZoom;

    /**
     * This disables the parts of the VidMode extension used by the xvidtune client that can be used to change the
     * video modes. Default: the VidMode extension is enabled.
     *
     * @var bool $disableVidModeExtension
     */
    private $disableVidModeExtension;

    /**
     * This allows the xvidtune client (and other clients that use the VidMode extension) to connect from another host.
     * Default: off.
     *
     * @var bool $allowNonLocalXvidtune
     */
    private $allowNonLocalXvidtune;

    /**
     * This tells the mousedrv(4) and vmmouse(4) drivers to not report failure if the mouse device can’t be
     * opened/initialised. It has no effect on the evdev(4) or other drivers. Default: false.
     *
     * @var bool $allowMouseOpenFail
     */
    private $allowMouseOpenFail;

    /**
     * Sets the inactivity timeout for the blank phase of the screensaver. time is in minutes. This is equivalent to
     * the Xorg server’s −s flag, and the value can be changed at run−time with xset(1). Default: 10 minutes.
     *
     * @var int $blankTime
     */
    private $blankTime;

    /**
     * Sets the inactivity timeout for the standby phase of DPMS mode. time is in minutes, and the value can be changed
     * at run−time with xset(1). Default: 10 minutes. This is only suitable for VESA DPMS compatible monitors, and may
     * not be supported by all video drivers. It is only enabled for screens that have the "DPMS" option set (see the
     * MONITOR section below).
     *
     * @var int $standbyTime
     */
    private $standbyTime;

    /**
     * Sets the inactivity timeout for the suspend phase of DPMS mode. time is in minutes, and the value can be changed
     * at run−time with xset(1). Default: 10 minutes. This is only suitable for VESA DPMS compatible monitors, and may
     * not be supported by all video drivers. It is only enabled for screens that have the "DPMS" option set (see the
     * MONITOR section below).
     *
     * @var int $suspendTime
     */
    private $suspendTime;

    /**
     * Sets the inactivity timeout for the off phase of DPMS mode. time is in minutes, and the value can be changed at
     * run−time with xset(1). Default: 10 minutes. This is only suitable for VESA DPMS compatible monitors, and may not
     * be supported by all video drivers. It is only enabled for screens that have the "DPMS" option set (see the
     * MONITOR section below).
     *
     * @var int $offTime
     */
    private $offTime;

    /**
     * This sets the pixmap format to use for depth 24. Allowed values for bpp are 24 and 32. Default: 32 unless driver
     * constraints don’t allow this (which is rare). Note: some clients don’t behave well when this value is set to 24.
     *
     * @var int $pixmap
     */
    private $pixmap;

    /**
     * Disables something to do with power management events. Default: PM enabled on platforms that support it.
     *
     * @var bool $noPm
     */
    private $noPm;

    /**
     * Enable or disable XINERAMA extension. Default is disabled.
     *
     * @var bool $xinerama
     */
    private $xinerama;

    /**
     * Enable or disable AIGLX. AIGLX is enabled by default.
     *
     * @var bool $aiglx
     */
    private $aiglx;

    /**
     * Enable or disable DRI2. DRI2 is disabled by default.
     *
     * @var bool $dri2
     */
    private $dri2;

    /**
     * This option controls how many GLX visuals the GLX modules sets up. The default value is typical, which will
     * setup up a typical subset of the GLXFBConfigs provided by the driver as GLX visuals. Other options are minimal,
     * which will set up the minimal set allowed by the GLX specification and all which will setup GLX visuals for all
     * GLXFBConfigs.
     *
     * @var string $glxVisuals
     */
    private $glxVisuals;

    /**
     * Include the default font path even if other paths are specified in xorg.conf. If enabled, other font paths are
     * included as well. Enabled by default.
     *
     * @var bool $useDefaultFontPath
     */
    private $useDefaultFontPath;

    /**
     * Allow modules built for a different, potentially incompatible version of the X server to load. Disabled by
     * default.
     *
     * @var bool $ignoreAbi
     */
    private $ignoreAbi;

    /**
     * If this option is disabled, then no devices will be added from the HAL or udev backends. Enabled by default.
     *
     * @var bool $autoAddDevices
     */
    private $autoAddDevices;

    /**
     * If this option is disabled, then the devices will be added (and the DevicePresenceNotify event sent), but not
     * enabled, thus leaving policy up to the client. Enabled by default.
     *
     * @var bool $autoEnableDevices
     */
    private $autoEnableDevices;
    /**
     * This option controls whether the log is flushed and/or synced to disk after each message. Possible values are
     * flush or sync. Unset by default.
     *
     * @var string $log
     */
    private $log;

    /**
     * Sets DPMS globally on or off. False by default.
     *
     * @var bool $dpms
     */
    private $dpms;

    /**
     * Gets dpms
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dpms $dpms
     *
     * @return boolean
     */
    public function isDpms()
    {
        return $this->dpms;
    }

    /**
     * Sets dpms
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dpms $dpms
     *
     * @param boolean $dpms
     *
     * @return ServerFlagsSection
     */
    public function setDpms($dpms)
    {
        $this->dpms = $dpms;

        return $this;
    }

    /**
     * Gets the default server layout
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$defaultServerLayout $defaultServerLayout
     *
     * @return string
     */
    public function getDefaultServerLayout()
    {
        return $this->defaultServerLayout;
    }

    /**
     * Sets the default server layout
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$defaultServerLayout $defaultServerLayout
     *
     * @param string $defaultServerLayout
     *
     * @return ServerFlagsSection
     */
    public function setDefaultServerLayout($defaultServerLayout)
    {
        $this->defaultServerLayout = $defaultServerLayout;

        return $this;
    }

    /**
     * Gets noTrapSignals
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$noTrapSignals $noTrapSignals
     *
     * @return boolean
     */
    public function isNoTrapSignals()
    {
        return $this->noTrapSignals;
    }

    /**
     * Sets noTrapSignals
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$noTrapSignals $noTrapSignals
     *
     * @param boolean $noTrapSignals
     *
     * @return ServerFlagsSection
     */
    public function setNoTrapSignals($noTrapSignals)
    {
        $this->noTrapSignals = $noTrapSignals;

        return $this;
    }

    /**
     * Gets useSigio
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$useSigio $useSigio
     *
     * @return boolean
     */
    public function isUseSigio()
    {
        return $this->useSigio;
    }

    /**
     * Sets useSigio
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$useSigio $useSigio
     *
     * @param boolean $useSigio
     *
     * @return ServerFlagsSection
     */
    public function setUseSigio($useSigio)
    {
        $this->useSigio = $useSigio;

        return $this;
    }

    /**
     * Gets dontVtSwitch
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dontVtSwitch $dontVtSwitch
     *
     * @return boolean
     */
    public function isDontVtSwitch()
    {
        return $this->dontVtSwitch;
    }

    /**
     * Sets dontVtSwitch
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dontVtSwitch $dontVtSwitch
     *
     * @param boolean $dontVtSwitch
     *
     * @return ServerFlagsSection
     */
    public function setDontVtSwitch($dontVtSwitch)
    {
        $this->dontVtSwitch = $dontVtSwitch;

        return $this;
    }

    /**
     * Gets dontZap
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dontZap $dontZap
     *
     * @return boolean
     */
    public function isDontZap()
    {
        return $this->dontZap;
    }

    /**
     * Sets dontZap
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dontZap $dontZap
     *
     * @param boolean $dontZap
     *
     * @return ServerFlagsSection
     */
    public function setDontZap($dontZap)
    {
        $this->dontZap = $dontZap;

        return $this;
    }

    /**
     * Gets dontZoom
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dontZoom $dontZoom
     *
     * @return boolean
     */
    public function isDontZoom()
    {
        return $this->dontZoom;
    }

    /**
     * Sets dontZoom
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dontZoom $dontZoom
     *
     * @param boolean $dontZoom
     *
     * @return ServerFlagsSection
     */
    public function setDontZoom($dontZoom)
    {
        $this->dontZoom = $dontZoom;

        return $this;
    }

    /**
     * Gets disableVidModeExtension
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$disableVidModeExtension $disableVidModeExtension
     *
     * @return boolean
     */
    public function isDisableVidModeExtension()
    {
        return $this->disableVidModeExtension;
    }

    /**
     * Sets disableVidModeExtension
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$disableVidModeExtension $disableVidModeExtension
     *
     * @param boolean $disableVidModeExtension
     *
     * @return ServerFlagsSection
     */
    public function setDisableVidModeExtension($disableVidModeExtension)
    {
        $this->disableVidModeExtension = $disableVidModeExtension;

        return $this;
    }

    /**
     * Gets allowNonLocalXvidtune
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$allowNonLocalXvidtune $allowNonLocalXvidtune
     *
     * @return boolean
     */
    public function isAllowNonLocalXvidtune()
    {
        return $this->allowNonLocalXvidtune;
    }

    /**
     * Sets allowNonLocalXvidtune
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$allowNonLocalXvidtune $allowNonLocalXvidtune
     *
     * @param boolean $allowNonLocalXvidtune
     *
     * @return ServerFlagsSection
     */
    public function setAllowNonLocalXvidtune($allowNonLocalXvidtune)
    {
        $this->allowNonLocalXvidtune = $allowNonLocalXvidtune;

        return $this;
    }

    /**
     * Gets allowMouseOpenFail
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$allowMouseOpenFail $allowMouseOpenFail
     *
     * @return boolean
     */
    public function isAllowMouseOpenFail()
    {
        return $this->allowMouseOpenFail;
    }

    /**
     * Sets allowMouseOpenFail
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$allowMouseOpenFail $allowMouseOpenFail
     *
     * @param boolean $allowMouseOpenFail
     *
     * @return ServerFlagsSection
     */
    public function setAllowMouseOpenFail($allowMouseOpenFail)
    {
        $this->allowMouseOpenFail = $allowMouseOpenFail;

        return $this;
    }

    /**
     * Gets the blank time
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$blankTime $blankTime
     *
     * @return int
     */
    public function getBlankTime()
    {
        return $this->blankTime;
    }

    /**
     * Sets the blank time
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$blankTime $blankTime
     *
     * @param int $blankTime
     *
     * @return ServerFlagsSection
     */
    public function setBlankTime($blankTime)
    {
        $this->blankTime = $blankTime;

        return $this;
    }

    /**
     * Gets the standby time
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$standbyTime $standbyTime
     *
     * @return int
     */
    public function getStandbyTime()
    {
        return $this->standbyTime;
    }

    /**
     * Sets the standby time
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$standbyTime $standbyTime
     *
     * @param int $standbyTime
     *
     * @return ServerFlagsSection
     */
    public function setStandbyTime($standbyTime)
    {
        $this->standbyTime = $standbyTime;

        return $this;
    }

    /**
     * Gets the suspend time
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$suspendTime $suspendTime
     *
     * @return int
     */
    public function getSuspendTime()
    {
        return $this->suspendTime;
    }

    /**
     * Sets the suspend time
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$suspendTime $suspendTime
     *
     * @param int $suspendTime
     *
     * @return ServerFlagsSection
     */
    public function setSuspendTime($suspendTime)
    {
        $this->suspendTime = $suspendTime;

        return $this;
    }

    /**
     * Gets the off time
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$offTime $offTime
     * @return int
     */
    public function getOffTime()
    {
        return $this->offTime;
    }

    /**
     * Sets the off time
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$offTime $offTime
     *
     * @param int $offTime
     *
     * @return ServerFlagsSection
     */
    public function setOffTime($offTime)
    {
        $this->offTime = $offTime;

        return $this;
    }

    /**
     * Gets the pixmap
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$pixmap $pixmap
     *
     * @return int
     */
    public function getPixmap()
    {
        return $this->pixmap;
    }

    /**
     * Sets the pixmap
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$pixmap $pixmap
     *
     * @param int $pixmap
     *
     * @return ServerFlagsSection
     */
    public function setPixmap($pixmap)
    {
        $this->pixmap = $pixmap;

        return $this;
    }

    /**
     * Gets noPm
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$noPm $noPm
     *
     * @return boolean
     */
    public function isNoPm()
    {
        return $this->noPm;
    }

    /**
     * Sets noPm
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$noPm $noPm
     *
     * @param boolean $noPm
     *
     * @return ServerFlagsSection
     */
    public function setNoPm($noPm)
    {
        $this->noPm = $noPm;

        return $this;
    }

    /**
     * Gets xinerama
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$xinerama $xinerama
     *
     * @return boolean
     */
    public function isXinerama()
    {
        return $this->xinerama;
    }

    /**
     * Sets xinerama
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$xinerama $xinerama
     *
     * @param boolean $xinerama
     *
     * @return ServerFlagsSection
     */
    public function setXinerama($xinerama)
    {
        $this->xinerama = $xinerama;

        return $this;
    }

    /**
     * Gets aiglx
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$aiglx $aiglx
     *
     * @return boolean
     */
    public function isAiglx()
    {
        return $this->aiglx;
    }

    /**
     * Sets aiglx
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$aiglx $aiglx
     *
     * @param boolean $aiglx
     *
     * @return ServerFlagsSection
     */
    public function setAiglx($aiglx)
    {
        $this->aiglx = $aiglx;

        return $this;
    }

    /**
     * Gets dri2
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dri2 $dri2
     *
     * @return boolean
     */
    public function isDri2()
    {
        return $this->dri2;
    }

    /**
     * Sets dri2
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$dri2 $dri2
     *
     * @param boolean $dri2
     *
     * @return ServerFlagsSection
     */
    public function setDri2($dri2)
    {
        $this->dri2 = $dri2;

        return $this;
    }

    /**
     * Gets glxVisuals
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$glxVisuals $glxVisuals
     *
     * @return string
     */
    public function getGlxVisuals()
    {
        return $this->glxVisuals;
    }

    /**
     * Sets glxVisuals
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$glxVisuals $glxVisuals
     *
     * @param string $glxVisuals
     *
     * @return ServerFlagsSection
     */
    public function setGlxVisuals($glxVisuals)
    {
        $this->glxVisuals = $glxVisuals;

        return $this;
    }

    /**
     * Gets useDefaultFontPath
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$useDefaultFontPath $useDefaultFontPath
     *
     * @return boolean
     */
    public function isUseDefaultFontPath()
    {
        return $this->useDefaultFontPath;
    }

    /**
     * Sets useDefaultFontPath
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$useDefaultFontPath $useDefaultFontPath
     *
     * @param boolean $useDefaultFontPath
     *
     * @return ServerFlagsSection
     */
    public function setUseDefaultFontPath($useDefaultFontPath)
    {
        $this->useDefaultFontPath = $useDefaultFontPath;

        return $this;
    }

    /**
     * Gets ignoreAbi
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$ignoreAbi $ignoreAbi
     *
     * @return boolean
     */
    public function isIgnoreAbi()
    {
        return $this->ignoreAbi;
    }

    /**
     * Sets ignoreAbi
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$ignoreAbi $ignoreAbi
     *
     * @param boolean $ignoreAbi
     *
     * @return ServerFlagsSection
     */
    public function setIgnoreAbi($ignoreAbi)
    {
        $this->ignoreAbi = $ignoreAbi;

        return $this;
    }

    /**
     * Gets autoAddDevices
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$autoAddDevices $autoAddDevices
     *
     * @return boolean
     */
    public function isAutoAddDevices()
    {
        return $this->autoAddDevices;
    }

    /**
     * Sets autoAddDevices
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$autoAddDevices $autoAddDevices
     *
     * @param boolean $autoAddDevices
     *
     * @return ServerFlagsSection
     */
    public function setAutoAddDevices($autoAddDevices)
    {
        $this->autoAddDevices = $autoAddDevices;

        return $this;
    }

    /**
     * Gets autoEnableDevices
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$autoEnableDevices $autoEnableDevices
     *
     * @return boolean
     */
    public function isAutoEnableDevices()
    {
        return $this->autoEnableDevices;
    }

    /**
     * Sets autoEnableDevices
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$autoEnableDevices $autoEnableDevices
     *
     * @param boolean $autoEnableDevices
     *
     * @return ServerFlagsSection
     */
    public function setAutoEnableDevices($autoEnableDevices)
    {
        $this->autoEnableDevices = $autoEnableDevices;

        return $this;
    }

    /**
     * Gets log
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$log $log
     *
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Sets log
     *
     * @see \Xorgconf\Sections\ServerFlagsSection::$log $log
     *
     * @param string $log
     *
     * @return ServerFlagsSection
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this
            ->addOption('DefaultServerLayout', $this->defaultServerLayout)
            ->addOption('NoTrapSignals', $this->noTrapSignals)
            ->addOption('UseSIGIO', $this->useSigio)
            ->addOption('DontVTSwitch', $this->dontVtSwitch)
            ->addOption('DontZap', $this->dontZap)
            ->addOption('DontZoom', $this->dontZoom)
            ->addOption('DisableVidModeExtension', $this->disableVidModeExtension)
            ->addOption('AllowNonLocalXvidtune', $this->allowNonLocalXvidtune)
            ->addOption('AllowMouseOpenFail', $this->allowMouseOpenFail)
            ->addOption('BlankTime', $this->blankTime)
            ->addOption('StandbyTime', $this->standbyTime)
            ->addOption('SuspendTime', $this->suspendTime)
            ->addOption('OffTime', $this->offTime)
            ->addOption('Pixmap', $this->pixmap)
            ->addOption('NoPM', $this->noPm)
            ->addOption('Xinerama', $this->xinerama)
            ->addOption('AIGLX', $this->aiglx)
            ->addOption('DRI2', $this->dri2)
            ->addOption('GlxVisuals', $this->glxVisuals)
            ->addOption('UseDefaultFontPath', $this->useDefaultFontPath)
            ->addOption('IgnoreABI', $this->ignoreAbi)
            ->addOption('AutoAddDevices', $this->autoAddDevices)
            ->addOption('AutoEnableDevices', $this->autoEnableDevices)
            ->addOption('Log', $this->log)
            ->addOption('DPMS', $this->dpms);

        return $this->_render(array());
    }
}
