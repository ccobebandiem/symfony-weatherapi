<?php


namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CitiesWeatherCommandTest extends KernelTestCase
{
    public function testExecute(){

        $kernel      = static::createKernel();
        $application = new Application($kernel);


        $command       = $application->find('app:cities-weather');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Processed city', $output);
    }
}