<?php

require_once("vendor/autoload.php");
require_once("src/itimetoread.php");
require_once("src/timetoread.php");


class TimeToReadTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testTimeToRead()
    {
        $minutes = new \kdaviesnz\timetoread\TimeToRead("Hello world");
        echo $minutes;
    }

}
