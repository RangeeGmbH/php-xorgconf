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

namespace Xorgconf;

/**
 * Class to build a xorg.conf
 *
 * @package Xorgconf
 */
class Xorgconf
{
    /**
     * Contains the sections that build up the xorg.conf
     *
     * @var \Xorgconf\Section[] $sections
     */
    private $sections;

    /**
     * Gets an array with sections.
     *
     * @see \Xorgconf\Xorgconf::$sections $sections
     *
     * @return \Xorgconf\Section[]
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Sets the array with sections.
     *
     * @see \Xorgconf\Xorgconf::$sections $sections
     *
     * @param \Xorgconf\Section[] $sections
     *
     * @return Xorgconf
     */
    public function setSections($sections)
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * Adds a section to the array of sections.
     *
     * @see \Xorgconf\Xorgconf::$sections $sections
     *
     * @param \Xorgconf\Section $section
     *
     * @return Xorgconf
     */
    public function addSection($section)
    {
        $this->sections[] = $section;

        return $this;
    }

    /**
     * Renders added sections as text and writes result to file
     *
     * @see \Xorgconf\Xorgconf::render() render()
     *
     * @param string $filename
     *
     * @return bool|int
     */
    public function write($filename)
    {
        if ($result = $this->render()) {
            return file_put_contents($filename, $result);
        } else {
            return false;
        }
    }

    /**
     * Renders added sections as text
     *
     * @return bool|string
     */
    public function render()
    {
        if (empty($this->sections)) {
            return false;
        }

        $result = "";

        foreach ($this->sections as $section) {
            $result .= $section->render();
            $result .= "\n";
        }

        return $result;
    }
}

