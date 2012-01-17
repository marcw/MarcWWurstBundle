<?php

namespace MarcW\Bundle\WurstBundle\Tests\Command;

use MarcW\Bundle\WurstBundle\Tests\Command\WurstCommandTestCase;

class WurstCommandTest extends WurstCommandTestCase
{
    public function testDefaultCommand()
    {
        $this->commandTester->execute(array('command' => $this->command->getName()));

        $expectedOutput = file_get_contents($this->wurstResourcesDirectory.'classic.txt');
        $expectedOutput .= PHP_EOL;

        $this->assertSame($expectedOutput, $this->commandTester->getDisplay());
    }

    public function testWurstTypes()
    {
        foreach ($this->wurstTypes as $wurstType)
        {
            $this->commandTester->execute(array(
                'command' => $this->command->getName(),
                'type' => $wurstType
            ));

            $expectedOutput = file_get_contents($this->wurstResourcesDirectory.$wurstType.'.txt');
            $expectedOutput .= PHP_EOL;

            $this->assertSame($expectedOutput, $this->commandTester->getDisplay());
        }
    }
    
    public function testSides()
    {
        foreach ($this->sides as $side)
        {
            $option = "--mit-$side";
            $this->commandTester->execute(array(
                'command' => $this->command->getName(),
                $option => true
            ));

            $expectedOutput = file_get_contents($this->wurstResourcesDirectory.'classic.txt');
            $expectedOutput .= PHP_EOL;
            $expectedOutput .= file_get_contents($this->sideResourcesDirectory.$side.'.txt');

            $this->assertSame($expectedOutput, $this->commandTester->getDisplay());
        }
    }
}
