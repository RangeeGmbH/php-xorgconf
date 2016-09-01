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

class ModuleSection extends Section
{
    const SECTION_NAME = 'Module';

    /**
     * This instructs the server to load the module called modulename. The module name given should be the module’s
     * standard name, not the module file name. The standard name is case−sensitive, and does not include the “lib”
     * prefix, or the “.a”, “.o”, or “.so” suffixes.
     *
     * @var string[] $load
     */
    private $load;

    /**
     * This instructs the server to not load the module called modulename. Some modules are loaded by default in the
     * server, and this overrides that default. If a Load instruction is given for the same module, it overrides the
     * Disable instruction and the module is loaded. The module name given should be the module’s standard name, not
     * the module file name. As with the Load instruction, the standard name is case-sensitive, and does not include
     * the "lib" prefix, or the ".a", ".o", or ".so" suffixes.
     *
     * @var string[] $disable
     */
    private $disable;

    /**
     * Gets array of disabled modules
     *
     * @see \Xorgconf\Sections\ModuleSection::$disable $disable
     *
     * @return string[]
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * Sets array of disabled modules
     *
     * @see \Xorgconf\Sections\ModuleSection::$disable $disable
     *
     * @param string[] $disable
     *
     * @return ModuleSection
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;

        return $this;
    }

    /**
     * Gets array of loaded modules
     *
     * @see \Xorgconf\Sections\ModuleSection::$load $load
     *
     * @return string[]
     */
    public function getLoad()
    {
        return $this->load;
    }

    /**
     * Sets array of loaded modules
     *
     * @see \Xorgconf\Sections\ModuleSection::$load $load
     *
     * @param string[] $load
     *
     * @return ModuleSection
     */
    public function setLoad($load)
    {
        $this->load = $load;

        return $this;
    }

    /**
     * Adds module to array of loaded modules
     *
     * @see \Xorgconf\Sections\ModuleSection::$load $load
     *
     * @param string $load
     *
     * @return ModuleSection
     */
    public function addLoad($load)
    {
        $this->load[] = $load;

        return $this;
    }

    /**
     * Adds module to array of disabled modules
     *
     * @see \Xorgconf\Sections\ModuleSection::$disable $disable
     *
     * @param string $disable
     *
     * @return ModuleSection
     */
    public function addDisable($disable)
    {
        $this->disable[] = $disable;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        return $this->_render(array(
            'Load'    => $this->load,
            'Disable' => $this->disable,
        ));
    }
}
