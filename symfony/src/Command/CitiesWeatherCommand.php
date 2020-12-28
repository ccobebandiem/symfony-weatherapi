<?php

namespace App\Command;

use App\Helper\CityHelper;
use App\Helper\WeatherHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CitiesWeatherCommand extends Command
{
    protected static $defaultName = 'app:city-weather';

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
        $cities        = [];
        $citiesLatLong = $this->cityHelper->getCitiesLatLong();

        foreach ($citiesLatLong as $city) {
            $cityWeather = $this->weatherHelper->getWeather($city);

            if ($cityWeather) {
                $cities[] = $cityWeather;
            }
        }

        foreach ($cities as $city) {
            $output->writeln('Processed city ' . $city['cityName'] . ' | ' . $city['todayWeather'] . ' - ' . $city['tomorrowWeather']);
        }

        return Command::SUCCESS;
    }
}