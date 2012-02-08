<?php

namespace MarcW\Bundle\WurstBundle\Tests\Command;

use MarcW\Bundle\WurstBundle\Tests\Command\WurstCommandTestCase;

class WurstCommandTest extends WurstCommandTestCase
{
    public function testDefaultCommand()
    {
        $this->commandTester->execute(array('command' => $this->command->getName()));

        $expectedOutput = $this->getExpectedWurstContent($this->defaultWurst);

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

            $expectedOutput = $this->getExpectedWurstContent($wurstType);

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

            $expectedOutput = $this->getExpectedSideContentForGivenType($side, $this->defaultWurst);

            $this->assertSame($expectedOutput, $this->commandTester->getDisplay());
        }
    }

    public function testSidesWithAllWurstTypes()
    {
        foreach ($this->sides as $side)
        {
            $option = "--mit-$side";
            foreach ($this->wurstTypes as $wurstType)
            {
                $this->commandTester->execute(array(
                    'command' => $this->command->getName(),
                    'type' => $wurstType,
                    $option => true
                ));

                $expectedOutput = $this->getExpectedSideContentForGivenType($side, $wurstType);

                $this->assertSame($expectedOutput, $this->commandTester->getDisplay());
            }
        }
    }

    private function getExpectedSideContentForGivenType($side, $givenType)
    {
        $content = $this->getExpectedWurstContent($givenType);
        $content .= $this->getContentFromDirectoryAndFile($this->sideResourcesDirectory, $side);

        return $content;
    }

    private function getExpectedWurstContent($wurst)
    {
        $content = $this->getContentFromDirectoryAndFile($this->wurstResourcesDirectory, $wurst);
        $content .= PHP_EOL;

        return $content;
    }

    private function getContentFromDirectoryAndFile($directory, $file)
    {
        $content = file_get_contents($directory.$file.'.txt');

        return $content;
    }
}

