<?php

namespace MarcW\Bundle\WurstBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * WurstCommand.
 *
 * @author Marc Weistroff <marc.weistroff@gmail.com>
 */
class WurstCommand extends ContainerAwareCommand
{
    const ERROR_WURST_NOT_FOUND = 1;

    protected function configure()
    {
        $this
            ->setName('wurst:print')
            ->addOption('mit-pommes', null, InputOption::VALUE_NONE, 'Mit Pommes?')
            ->addOption('mit-mayo', null, InputOption::VALUE_NONE, 'Mit Mayo?')
            ->addArgument('type', null, 'Which type of würst you want?', 'classic')
            ->setHelp('Please ask your local curry würst retailer.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $wurstFile = sprintf(__DIR__.'/../Resources/wurst/%s.txt', $input->getArgument('type'));
        if (!is_readable($wurstFile)) {
            $output->writeln('<error>This würst is not part of this bundle. Try "classic" or consider contributing!</error>');

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
    }
}
