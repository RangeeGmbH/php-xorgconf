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
 * Abstract Section implementing $options and _render
 *
 * @package Xorgconf
 */
abstract class Section
{
    const SECTION_NAME = 'AbstractSection';
    /**
     * Keyed array of custom options to add as entries to the section
     *
     * @var array $options
     */
    private $options;

    /**
     * Array of custom lines to be added to a section
     *
     * @var string[] $customLines
     */
    private $customLines;

    /**
     * Gets the array of custom lines
     *
     * @see \Xorgconf\Section::$customLines $customLines
     *
     * @return string[]
     */
    public function getCustomLines()
    {
        return $this->customLines;
    }

    /**
     * Sets the array of custom lines
     *
     * @param string[] $customLines
     *
     * @see \Xorgconf\Section::$customLines $customLines
     *
     * @return Section
     */
    public function setCustomLines($customLines)
    {
        $this->customLines = $customLines;

        return $this;
    }

    /**
     * Adds a custom line to the array of custom line
     *
     * @see \Xorgconf\Section::$customLines $customLines
     *
     * @param $customLine string
     *
     * @return Section
     */
    public function addCustomLine($customLine)
    {
        $this->customLines[] = $customLine;

        return $this;
    }

    /**
     * Renders the current section as text
     *
     * @return string
     */
    public abstract function render();

    /**
     * Gets an array with custom options.
     *
     * @see \Xorgconf\Section::$options $options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the array with custom options.
     *
     * @see \Xorgconf\Section::$options $options
     *
     * @param array $options
     *
     * @return Section
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Adds an entry to the array of custom options.
     *
     * @see \Xorgconf\Section::$options $options
     *
     * @param $key
     * @param $value
     *
     * @return Section
     */
    public function addOption($key, $value)
    {
        if (isset($value)) {
            $this->options[$key] = $value;
        }

        return $this;
    }

    /**
     * Gets an entry from the array of custom options.
     *
     * @see \Xorgconf\Section::$options $options
     *
     * @param $key
     *
     * @return mixed
     */
    public function getOption($key)
    {
        return $this->options[$key];
    }

    /**
     * Renders the section as text
     *
     * @param $entries mixed Keyed array of entries to render
     *
     * @return string
     */
    protected function _render($entries)
    {
        // Section start tag
        $result = "Section \"" . static::SECTION_NAME . "\"\n";

        // Render entries
        if (!empty($entries)) {
            foreach ($entries as $key => $value) {
                if (empty($value)) {
                    // $value is empty
                    continue;
                }

                if (is_array($value)) {
                    // $value is an array
                    foreach ($value as $val) {
                        $result .= "  {$key} \"{$val}\"\n";
                    }
                } elseif (is_bool($value)) {
                    $result .= "  {$key} \"" . ($value ? 'true' : 'false') . "\"\n";
                } else {
                    // $value is a scalar
                    $result .= "  {$key} \"{$value}\"\n";
                }
            }
        }

        // Render options
        if (!empty($this->options)) {
            foreach ($this->options as $key => $value) {
                if (is_array($value)) {
                    // $value is an array
                    foreach ($value as $val) {
                        $result .= "  Option \"{$key}\" \"{$val}\"\n";
                    }
                } elseif (is_bool($value)) {
                    $result .= "  Option \"{$key}\" \"" . ($value ? 'true' : 'false') . "\"\n";
                } elseif (is_int($value)) {
                    $result .= "  Option \"{$key}\" {$value}\n";
                } else {
                    // $value is a scalar
                    if (empty($value)) {
                        // $value is empty
                        $result .= "  Option \"{$key}\"\n";
                    } else {
                        $result .= "  Option \"{$key}\" \"{$value}\"\n";
                    }
                }
            }
        }

        // Render custom lines
        if (!empty($this->customLines)) {
            foreach ($this->customLines as $customLine) {
                $result .= "  {$customLine}\n";
            }
        }

        // Section end tag
        $result .= "EndSection\n";

        return $result;
    }
}
