<?php

namespace MarcW\Bundle\WurstBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * WurstCommand.
 *
 * @author Marc Weistroff <marc.weistroff@gmail.com>
 */
class WurstCommand extends ContainerAwareCommand
{
    const ERROR_WURST_NOT_FOUND = 1;

    protected $wurstTypes = array();
    protected $sides = array();

    public function __construct($name = null)
    {
        $this->wurstType = $this->findFood(__DIR__.'/../Resources/wurst');
        $this->sides = $this->findFood(__DIR__.'/../Resources/sides');

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('wurst:print')
            ->addArgument('type', null, sprintf('Which type of würst you want (%s)?', implode(', ', $this->wurstTypes)), 'classic')
            ->setHelp('Please ask your local curry würst retailer.')
        ;

        foreach ($this->sides as $side) {
            $this->addOption('mit-'.$side, null, InputOption::VALUE_NONE, sprintf('Mit %s?', ucfist($side)));
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!in_array($input->getArgument('type'), $this->wurstTypes, true)) {
            $output->writeln(sprintf(
                '<error>This würst is not part of this bundle. Try one of "%s" or consider contributing!</error>',
                implode(', ', $this->wurstTypes)
            ));

            return self::ERROR_WURST_NOT_FOUND;
        }

        $wurst = file_get_contents(sprintf(__DIR__.'/../Resources/wurst/%s.txt', $input->getArgument('type')));
        $output->writeln($wurst);

        foreach ($this->sides as $side) {
            if ($input->getOption('mit-'.$side)) {
                $option = file_get_contents(sprintf(__DIR__.'/../Resources/sides/%s.txt', $side));
                $output->write($option);
            }
        }
    }

    private function findFood($path)
    {
        $yumyum = Finder::create()
            ->in(__DIR__.'/../Resources/wurst')
            ->name('*.txt')
            ->depth(0)
            ->filter(function (SplFileInfo $file) {
                return $file->isReadable();
            })
        ;

        $food = array();
        foreach ($yumyum as $yum) {
            $food[] = basename($file->getRelativePathName(), '.txt');
        }

        return $food;
    }
}
