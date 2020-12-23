<?php


namespace App\Command;


use App\Controller\V3\WeatherController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CitiesWeatherCommand extends Command
{
    protected static $defaultName = 'app:cities-weather';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $weather = new WeatherController();

        $output->writeln(json_decode($weather->index()->getContent()));

        return Command::SUCCESS;
    }
}