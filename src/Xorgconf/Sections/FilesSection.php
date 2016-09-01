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
 * The Files section is used to specify some path names required by the server. Some of these paths can also be set
 * from the command line (see Xserver(1) and Xorg(1)). The command line settings override the values specified in the
 * config file. The Files section is optional, as are all of the entries that may appear in it.
 *
 * @package Xorgconf\Sections
 */
class FilesSection extends Section
{
    const SECTION_NAME = 'Files';

    /**
     * Sets the search path for fonts. This path is a comma separated list of font path elements which the Xorg server
     * searches for font databases. Multiple FontPath entries may be specified, and they will be concatenated to build
     * up the fontpath used by the server. Font path elements can be absolute directory paths, catalogue directories or
     * a font server identifier.
     *
     * @var string $fontPath
     */
    private $fontPath;

    /**
     * Sets the search path for loadable Xorg server modules. This path is a comma separated list of directories which
     * the Xorg server searches for loadable modules loading in the order specified. Multiple ModulePath entries may be
     * specified, and they will be concatenated to build the module search path used by the server. The default module
     * path is /usr/lib/xorg/modules
     *
     * @var string $modulePath
     */
    private $modulePath;

    /**
     * Sets the base directory for keyboard layout files. The −xkbdir command line option can be used to override this.
     * The default directory is /usr/share/X11/xkb
     *
     * @var string $xkbDir
     */
    private $xkbDir;

    /**
     * Gets the fontPath
     *
     * @see \Xorgconf\Sections\FilesSection::$fontPath $fontPath
     *
     * @return string
     */
    public function getFontPath()
    {
        return $this->fontPath;
    }

    /**
     * Sets the fontPath
     *
     * @see \Xorgconf\Sections\FilesSection::$fontPath $fontPath
     *
     * @param string $fontPath
     *
     * @return FilesSection
     */
    public function setFontPath($fontPath)
    {
        $this->fontPath = $fontPath;

        return $this;
    }

    /**
     * Gets the modulePath
     *
     * @see \Xorgconf\Sections\FilesSection::$modulePath $modulePath
     *
     * @return string
     */
    public function getModulePath()
    {
        return $this->modulePath;
    }

    /**
     * Sets the modulePath
     *
     * @see \Xorgconf\Sections\FilesSection::$modulePath $modulePath
     *
     * @param string $modulePath
     *
     * @return FilesSection
     */
    public function setModulePath($modulePath)
    {
        $this->modulePath = $modulePath;

        return $this;
    }

    /**
     * Gets the xkbDir
     *
     * @see \Xorgconf\Sections\FilesSection::$xkbDir $xkbDir
     *
     * @return string
     */
    public function getXkbDir()
    {
        return $this->xkbDir;
    }

    /**
     * Sets the xkbDir
     *
     * @see \Xorgconf\Sections\FilesSection::$xkbDir $xkbDir
     *
     * @param string $xkbDir
     *
     * @return FilesSection
     */
    public function setXkbDir($xkbDir)
    {
        $this->xkbDir = $xkbDir;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        return $this->_render(array(
            'FontPath'   => $this->fontPath,
            'ModulePath' => $this->modulePath,
            'XkbDir'     => $this->xkbDir,
        ));
    }

}
