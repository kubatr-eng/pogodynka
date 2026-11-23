<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $city,
        WeatherUtil $weatherUtil,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false
    ): Response
    {
        $measurements = $weatherUtil->getWeatherForCountryAndCity(
            $country,
            $city
        );


        if ($twig) {
            $template = $format === 'csv'
                ? 'weather_api/index.csv.twig'
                : 'weather_api/index.json.twig';

            $content = $this->renderView($template, [
                'city' => $city,
                'country' => $country,
                'measurements' => $measurements,
            ]);

            $contentType = $format === 'csv'
                ? 'text/plain; charset=UTF-8'
                : 'application/json; charset=UTF-8';

            return new Response($content, 200, [
                'Content-Type' => $contentType
            ]);
        }

        if ($format === 'csv') {
            $csv = "city,country,date,celsius\n";

            foreach ($measurements as $m) {
                $csv .= sprintf(
                    "%s,%s,%s,%s\n",
                    $city,
                    $country,
                    $m->getDate()->format('Y-m-d'),
                    $m->getCelsius(),
                    $m->getFahrenheit()
                );
            }

            return new Response($csv, 200, [
                'Content-Type' => 'text/csv; charset=UTF-8'
            ]);
        }

        return $this->json([
            'city' => $city,
            'country' => $country,
            'measurements' => array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'celsius' => $m->getCelsius(),
                'fahrenheit' => $m->getFahrenheit(),
            ], $measurements),
        ]);
    }
}
