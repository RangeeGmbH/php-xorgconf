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
use Xorgconf\Sections\DeviceSection;
use Xorgconf\Sections\InputClassSection;
use Xorgconf\Sections\InputDeviceSection;
use Xorgconf\Sections\MonitorSection;
use Xorgconf\Sections\ScreenSection;
use Xorgconf\Sections\ServerFlagsSection;
use Xorgconf\Sections\ServerLayoutSection;
use Xorgconf\Xorgconf;

require_once __DIR__ . '/vendor/autoload.php';

$conf = new Xorgconf();

$device = new DeviceSection("device1", "driverA");
$device->setScreen(4);
$conf->addSection($device);

$monitor = new MonitorSection("monitor1");
$monitor
    ->setPrimary(true)
    ->setEnable(false);
$conf->addSection($monitor);

$screen = new ScreenSection("screen1");
$screen
    ->setDevice($device)
    ->setMonitor($monitor);
$conf->addSection($screen);

$inputDevice1 = new InputDeviceSection("inputDevice1", "driverB");
$inputDevice1->setFloating(true);
$conf->addSection($inputDevice1);

$inputDevice2 = new InputDeviceSection("inputDevice2", "driverC");
$inputDevice2->setAutoServerLayout(false);
$conf->addSection($inputDevice2);

$inputClass = new InputClassSection("inputClass1");
$inputClass
    ->setAdaptiveDeceleration(1.5)
    ->setMatchIsTouchscreen(true);
$conf->addSection($inputClass);

$layout = new ServerLayoutSection("layout1");
$layout
    ->addScreen($screen)
    ->addInputDevice($inputDevice1)
    ->addInputDevice($inputDevice2);
$conf->addSection($layout);

$flags = new ServerFlagsSection();
$flags
    ->setDefaultServerLayout("layout1")
    ->setDontZap(false)
    ->setDontVtSwitch(true)
    ->setBlankTime(5);
$conf->addSection($flags);

$result = $conf->render();

echo $result;
