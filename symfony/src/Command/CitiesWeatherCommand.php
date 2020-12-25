<?php


namespace App\Command;


use App\Controller\V3\WeatherController;
use App\Helper\CityHelper;
use App\Helper\WeatherHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CitiesWeatherCommand extends Command
{
    protected static $defaultName = 'app:cities-weather';

    /**
     * @var WeatherHelper
     */
    private $weatherHelper;

    /**
     * @var CityHelper
     */
    private $cityHelper;

    public function __construct(WeatherHelper $weatherHelper, CityHelper $cityHelper)
    {
        $this->weatherHelper = $weatherHelper;
        $this->cityHelper    = $cityHelper;

        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $weather = new WeatherController();

        $output->writeln(json_decode($weather->index($this->weatherHelper, $this->cityHelper)->getContent()));

        return Command::SUCCESS;
    }
}