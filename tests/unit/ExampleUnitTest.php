<?php
/**
 * SendinBlue plugin for Craft CMS 3.x
 *
 * Integration with SendinBlue API. Create, update and delete sendinblue Contacts from with Craft
 *
 * @link      shorn.co.uk
 * @copyright Copyright (c) 2020 Sean Hill
 */

namespace shornuk\sendinbluetests\unit;

use Codeception\Test\Unit;
use UnitTester;
use Craft;
use shornuk\sendinblue\SendinBlue;

/**
 * ExampleUnitTest
 *
 *
 * @author    Sean Hill
 * @package   SendinBlue
 * @since     0.0.1
 */
class ExampleUnitTest extends Unit
{
    // Properties
    // =========================================================================

    /**
     * @var UnitTester
     */
    protected $tester;

    // Public methods
    // =========================================================================

    // Tests
    // =========================================================================

    /**
     *
     */
    public function testPluginInstance()
    {
        $this->assertInstanceOf(
            SendinBlue::class,
            SendinBlue::$plugin
        );
    }

    /**
     *
     */
    public function testCraftEdition()
    {
        Craft::$app->setEdition(Craft::Pro);

        $this->assertSame(
            Craft::Pro,
            Craft::$app->getEdition()
        );
    }
}
