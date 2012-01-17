<?php

namespace MarcW\Bundle\WurstBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use MarcW\Bundle\WurstBundle\Command\WurstCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class WurstCommandTest extends \PHPUnit_Framework_TestCase
{
    private $wurstResourcesDirectory;
    private $sideResourcesDirectory;
    private $command;
    private $commandTester;
    private $wurstTypes;
    
    public function setUp()
    {
        $resourceDirectory = $this->getResourceDirectory();
        $this->wurstResourcesDirectory = $resourceDirectory.'wurst'.DIRECTORY_SEPARATOR;;
        $this->sideResourcesDirectory = $resourceDirectory.'sides'.DIRECTORY_SEPARATOR;
        
        $this->setCommand();
        $this->commandTester = new CommandTester($this->command);
        
        $this->findWurstTypes();
    }
    
    private function getResourceDirectory()
    {
        $sourceDirectory = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;
        $resourceDirectory = $sourceDirectory.'Resources'.DIRECTORY_SEPARATOR;
        
        return $resourceDirectory;
    }
    
    private function setCommand()
    {
        $mockedKernel = $this->getMock('Symfony\\Component\\HttpKernel\\Kernel', array(), array(), '', false);
        $application = new Application($mockedKernel);
        $application->add(new WurstCommand());

        $this->command = $application->find('wurst:print');
    }
    
    private function findWurstTypes()
    {
        $foundFiles = Finder::create()
            ->in($this->wurstResourcesDirectory)
            ->name('*.txt')
            ->depth(0)
            ->filter(function (SplFileInfo $file) {
                return $file->isReadable();
            })
        ;

        foreach ($foundFiles as $foundFile) {
            $this->wurstTypes[] = basename($foundFile->getRelativePathName(), '.txt');
        }
    }

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
}
