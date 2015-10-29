<?php

namespace Unisal\Encurtador\Service;

use Unisal\Encurtador\Mapper\IMapper;
use Unisal\Encurtador\Service\PeriodoService;

/**
 * @author Lucas de Oliveira
 */
class EncurtadorService
{
    
    /**
     * @var IMapper
     */
    protected $mapper;

    /**
     * @var type
     */
    protected $periodoService;
    
    public function __construct(IMapper $mapper, PeriodoService $periodoService)
    {
        $this->mapper = $mapper;
        $this->periodoService = $periodoService;
    }

    /**
     * Cria a url encurtada, salva no mongoDB
     * @param string $url
     * @return array
     * @throws \MongoException
     */
    public function encurtar($url)
    {
        $urlEncurtada = $this->gerarURLEncurtada();
        
        $dadosURL = array(
            'url' => $url,
            'url_encurtada' => $urlEncurtada,
            'horario' => time(),
            'link_acessos' => array()
        );
        
        try {
            $this->mapper->save($dadosURL);
        } catch (\Exception $e) {
            throw new \RuntimeException('Ops.. Ocorreu um problema ao salvar.');
        }
        
        return ['url_encurtada' => $urlEncurtada];
    }

    /**
     * Retorna ultimas urls encurtadas, pelo limite definido
     * @param integer $limit
     * @return array
     */
    public function getUltimasUrls($limit = 10)
    {
        $urls = $this->mapper->findSortedByDate(array(), $limit);
        
        $urlsFormatadas = [];
        foreach ($urls as $key => $url) {
            $urlsFormatadas[$key] = $url;
            $urlsFormatadas[$key]['horario'] = $this
                ->periodoService
                ->traduzirTempo($url['horario'])
            ;
        }
        return $urlsFormatadas;
    }
    
    public function getDetalhesURL($url)
    {
        if (! is_string($url) || is_null($url)) {
            throw new \InvalidArgumentException('Informe uma URL válida.');
        }
        
        $detalhesURL = $this->mapper->findOne(['url_encurtada' => $url]);
        if (! count($detalhesURL)) {
            throw new \RuntimeException('URL não encontrada.');
        }
        
        $infoURL = $this->getDiasEQtdVisualizacoes($detalhesURL);
        $detalhesURL['horario'] = $this
            ->periodoService
            ->traduzirTempo($detalhesURL['horario'])
        ;
        
        return [
            'detalhe' => $detalhesURL,
            'visualizacoes' => $infoURL['visualizacoes'],
            'dias' => $infoURL['dias']
        ];
    }
    
    /**
     * Atualiza acesso na URL para contar quantidades de acesso por dia
     * @param string $url
     * @return boolean
     */
    public function atualizarAcessoURL($url)
    {
        $whereURL = ['url_encurtada' => $url];
        $dataAtual = strtotime(date('Y-m-d') . '00:00:00');
        $where = array_merge($whereURL, ['link_acessos' => ['$elemMatch' => ['time' => $dataAtual]]]);
        $buscaAcessoDataAtual = $this->mapper->findOne($where, array('_id'));
        
        if (! empty($buscaAcessoDataAtual)) {
            $where = array_merge($whereURL, array('link_acessos.time' => $dataAtual));
            return $this->mapper->update($where, array('$inc' => array('link_acessos.$.count' => 1)));
        }
        
        $dadosAcesso = [
            'link_acessos' => [
                'time' => $dataAtual,
                'count' => 1
            ]
        ];
        return $this->mapper->update($whereURL, array('$push' => $dadosAcesso));
    }
    
    /**
     * Retorna a quantidade de visualizações dos últimos 4 dias
     * @param array $detalhesURL
     * @return array
     */
    protected function getDiasEQtdVisualizacoes($detalhesURL)
    {
        $visualizacoes = 0;
        $timeSemana = strtotime("-4 days");
        $dias = [];
        foreach ($detalhesURL['link_acessos'] as $acesso) {
            $visualizacoes += $acesso['count'];
            if ($acesso['time'] >= $timeSemana) {
                $dias[] = array(
                    'data' => date('Y-m-d', $acesso['time']),
                    'visualizacoes' => $acesso['count']
                );
            }
        }
        return [
            'visualizacoes' => $visualizacoes,
            'dias' => $dias
        ];
    }
    
    /**
     * Metódo para criar uma pequena string com caracteres aleatórios
     * @return string
     */
    protected function gerarURLEncurtada()
    {
        $tamanho = 8;
        $mapaCaracteres = md5(rand(1, 1000) . sha1(time()));
        $tag = [];

        for ($i = 1; $i <= $tamanho; $i++) {
            $caractere = $mapaCaracteres[mt_rand(0, strlen($mapaCaracteres) - 1)];
            $tag[] = $caractere;
        }

        shuffle($tag);
        return implode('', $tag);
    }
}
