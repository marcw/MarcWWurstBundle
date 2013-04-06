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

    public function __construct($name = null)
    {
        $finder = Finder::create()
            ->in(__DIR__.'/../Resources/wurst')
            ->name('*.txt')
            ->depth(0)
            ->filter(function (SplFileInfo $file) {
                return $file->isReadable();
            })
        ;

        foreach ($finder as $file) {
            $this->wurstTypes[] = basename($file->getRelativePathName(), '.txt');
        }

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('wurst:print')
            ->addOption('mit-pommes', null, InputOption::VALUE_NONE, 'Mit Pommes?')
            ->addOption('mit-mayonnaise', null, InputOption::VALUE_NONE, 'Mit Mayo?')
            ->addOption('mit-beer', null, InputOption::VALUE_NONE, 'Mit Beer?')
            ->addOption('mit-pretzel', null, InputOption::VALUE_NONE, 'Mit Pretzel?')
            ->addOption('mit-coffee', null, InputOption::VALUE_NONE, 'Mit Kaffee?')
            ->addOption('mit-kase', null, InputOption::VALUE_NONE, 'Mit Kase?')
            ->addOption('mit-chocolate', null, InputOption::VALUE_NONE, 'Mit Chocolate?')
            ->addOption('mit-wine', null, InputOption::VALUE_NONE, 'Mit Wine?')
            ->addOption('mit-tea', null, InputOption::VALUE_NONE, 'Mit Tea?')
            ->addOption('mit-ketchup', null, InputOption::VALUE_NONE, 'Mit Ketchup?')
            ->addOption('mit-aioli', null, InputOption::VALUE_NONE, 'Mit Aioli?')
            ->addOption('mit-tomato', null, InputOption::VALUE_NONE, 'Mit Tomato?')
            ->addArgument('type', null, sprintf('Which type of würst you want (%s)?', implode(', ', $this->wurstTypes)), 'classic')
            ->setHelp('Please ask your local curry würst retailer.')
        ;
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

        if ($input->getOption('mit-pommes')) {
            $pommes = file_get_contents(__DIR__.'/../Resources/sides/pommes.txt');
            $output->write($pommes);
        }

        if ($input->getOption('mit-mayonnaise')) {
            $mayo = file_get_contents(__DIR__.'/../Resources/sides/mayonnaise.txt');
            $output->write($mayo);
        }

        if ($input->getOption('mit-beer')) {
            $beer = file_get_contents(__DIR__.'/../Resources/sides/beer.txt');
            $output->write($beer);
        }

        if ($input->getOption('mit-pretzel')) {
            $pretzel = file_get_contents(__DIR__.'/../Resources/sides/pretzel.txt');
            $output->write($pretzel);
        }

        if ($input->getOption('mit-coffee')) {
            $kaffee = file_get_contents(__DIR__.'/../Resources/sides/coffee.txt');
            $output->write($kaffee);
        }

        if ($input->getOption('mit-kase')) {
            $kase = file_get_contents(__DIR__.'/../Resources/sides/kase.txt');
            $output->write($kase);
        }

        if ($input->getOption('mit-chocolate')) {
            $chocolate = file_get_contents(__DIR__.'/../Resources/sides/chocolate.txt');
            $output->write($chocolate);
        }

        if ($input->getOption('mit-wine')) {
            $wine = file_get_contents(__DIR__.'/../Resources/sides/wine.txt');
            $output->write($wine);
        }

        if ($input->getOption('mit-tea')) {
            $tea = file_get_contents(__DIR__.'/../Resources/sides/tea.txt');
            $output->write($tea);
        }
        
        if ($input->getOption('mit-ketchup')) {
            $ketchup = file_get_contents(__DIR__.'/../Resources/sides/ketchup.txt');
            $output->write($ketchup);
        }

        if ($input->getOption('mit-aioli')) {
            $aioli = file_get_contents(__DIR__.'/../Resources/sides/aioli.txt');
            $output->write($aioli);
        }
        
        if ($input->getOption('mit-tomato')) {
            $aioli = file_get_contents(__DIR__.'/../Resources/sides/tomato.txt');
            $output->write($tomato);
        }
        
        if ($input->getOption('mit-sfliveWurst')) {
            $sfliveWurst = file_get_contents(__DIR__.'/../Resources/sides/sfliveWurst.txt');
            $output->write($sfliveWurst);
        }
    }
}
