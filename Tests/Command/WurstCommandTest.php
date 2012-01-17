<?php

namespace MarcW\Bundle\WurstBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use MarcW\Bundle\WurstBundle\Command\WurstCommand;
use Symfony\Component\Console\Tester\CommandTester;

class WurstCommandTest extends \PHPUnit_Framework_TestCase
{  
    public function testDefaultCommand()
    {
        $mockedKernel = $this->getMock('Symfony\\Component\\HttpKernel\\Kernel', array(), array(), '', false);
        $application = new Application($mockedKernel);
        $application->add(new WurstCommand());

        $command = $application->find('wurst:print');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));
        
        $expectedOutput = file_get_contents(__DIR__.'/../../Resources/wurst/classic.txt');
        $expectedOutput .= PHP_EOL;

        $this->assertEquals($commandTester->getDisplay(), $expectedOutput);
    }
}
