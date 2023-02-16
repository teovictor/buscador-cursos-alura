<?php

namespace Alura\BuscadorCursosAlura;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private ClientInterface $httpClient;
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    private Crawler $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler    = $crawler;
    }

    public function buscar(string $url): array
    {
        $cursos   = [];
        $resposta = $this->httpClient->request('GET', $url);

        $html = $resposta->getBody();
        $this->crawler->addHtmlContent($html);

        $elementosCursos = $this->crawler->filter('span.card-curso__nome');

        foreach ($elementosCursos as $elemento) {
            $cursos[] = $elemento->textContent;
        }
        return $cursos;
    }
}
