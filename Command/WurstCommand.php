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
            ->addOption('mit-mayo', null, InputOption::VALUE_NONE, 'Mit Mayo?')
            ->addOption('mit-beer', null, InputOption::VALUE_NONE, 'Mit Beer?')
            ->addOption('mit-pretzel', null, InputOption::VALUE_NONE, 'Mit Pretzel?')
            ->addArgument('type', null, sprintf('Which type of würst you want (%s)?', implode(', ', $this->wurstTypes)), 'classic')
            ->setHelp('Please ask your local curry würst retailer.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $wurstFile = sprintf(__DIR__.'/../Resources/wurst/%s.txt', $input->getArgument('type'));
        if (!is_readable($wurstFile)) {
            $output->writeln(sprintf(
                '<error>This würst is not part of this bundle. Try one of "%s" or consider contributing!</error>',
                implode(', ', $this->wurstTypes)
            ));

            return self::ERROR_WURST_NOT_FOUND;
        }

        $wurst = file_get_contents($wurstFile);
        $output->writeln($wurst);

        if ($input->getOption('mit-pommes')) {
            $pommes = file_get_contents(__DIR__.'/../Resources/sides/pommes.txt');
            $output->write($pommes);
        }

        if ($input->getOption('mit-mayo')) {
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
    }
}
