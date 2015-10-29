<?php

namespace Unisal\Encurtador\Service;

use Unisal\Encurtador\Service\PeriodoService;

/**
 * @author Lucas Oliveira
 */
class GraficoGoogleService
{
    /**
     * @var PeriodoService
     */
    protected $periodoService;
    
    public function __construct(PeriodoService $periodoService)
    {
        $this->periodoService = $periodoService;
    }
    
    /**
     * Retorn tag para exibir gráfico
     * @param array $diasAcesso
     * @return string
     */
    public function getGrafico($diasAcesso)
    {
        $legendas = [];
        $valores = [];
        $descricoes = [];
        
        $quantidadeDias = count($diasAcesso);
        if ($quantidadeDias <= 0) {
            return '<p>Essa url ainda não foi acessada.</p>';
        }
        foreach ($diasAcesso as $diaAcesso) {
            $legendas[] = $this->periodoService->getDiaSemana($diaAcesso['data']);
            $valores[] = $diaAcesso['visualizacoes'];
            $descricoes[] = $diaAcesso['visualizacoes'] . '+Visualizações';
        }
        
        $graficoParametros = $this->getParametrosGrafico($legendas, $valores, $descricoes);
        $urlGrafico = implode('', $graficoParametros);

        return "<img src=" . $urlGrafico . " alt='Gráfico'>";
    }
    
    protected function getParametrosGrafico($legendas, $valores, $descricoes)
    {
        return [
            '//chart.googleapis.com/chart',
            '?chxs=0,676767,13.5',
            '&chxt=x',
            '&chs=560x216',
            '&cht=p3',
            '&chco=AA0033|80C65A|FFCC33|7777CC',
            '&chds=-1.667,98.333',
            '&chd=t:' . implode(',', $valores),
            '&chdl=' . implode('|', $legendas),
            '&chdlp=b',
            '&chp=0',
            '&chl=' . implode('|', $descricoes),
            '&chma=25,6,7|0,2',
        ];
    }
}
