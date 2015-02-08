<?php

include("classes/StringExtensions.php");

class Test extends PHPUnit_Framework_TestCase
{

    public function testStartsWith()
    {

        $this->assertTrue(stringextensions::StartsWith("Hallo Welt!", "Hallo"));
        $this->assertTrue(!stringextensions::StartsWith("Hallo Welt!", "hallo"));

        $this->assertTrue(stringextensions::EndsWith("Hallo Welt!", "elt!"));
        $this->assertTrue(!stringextensions::EndsWith("Hallo Welt!", "Hallo"));

    }

}
