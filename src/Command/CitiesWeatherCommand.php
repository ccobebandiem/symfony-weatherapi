<?php


namespace App\Command;


use App\Controller\V3\WeatherController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CitiesWeatherCommand extends Command
{
    protected static $defaultName = 'app:cities-weather';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $weather = new WeatherController();

        $output->writeln($weather->index()->getContent());

        return Command::SUCCESS;
    }
}