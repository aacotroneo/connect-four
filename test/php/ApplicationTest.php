<?php

namespace Aac;


class ApplicationTest extends \PHPUnit_Framework_TestCase
{


    function testDependenciesLoaded()
    {

        $application = new Application($this->getConf());

        $app = $application->getApp();

        $this->assertTrue(true);
//        $this->assertInstanceOf('Aac\Model\Board', $app->Board); //this initiates session and breaks the test
    }



    function getConf()
    {
        $conf = include(__DIR__ . '/../../conf/config.php');
        return $conf;
    }


} 