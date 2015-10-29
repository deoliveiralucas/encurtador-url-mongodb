<?php

namespace Unisal\Encurtador\Service;

/**
 * @author Lucas Oliveira
 */
class PeriodoService
{
    
    /**
     * Retorna texto traduzido de quanto tempo atrás foi criado a URL
     * @param integer $horario
     * @return string
     */
    public function traduzirTempo($horario)
    {
        $periodos = $this->getPeriodos();
        $lengths = $this->getLengths();
        
        $now = time();
        $unixDate = $horario;

        if ($now > $unixDate) {
            $diff = $now - $unixDate;
            $tense = "atrás";
        } else {
            $diff = $unixDate - $now;
            $tense = "agora";
        }

        for ($j = 0; $diff >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $diff /= $lengths[$j];
        }

        $diff = round($diff);

        if ($diff != 1) {
            $periodos[$j] .= "s";
        }

        return sprintf("%s %s %s", $diff, $periodos[$j], $tense);
    }
    
    protected function getPeriodos()
    {
        return [
            "segundo",
            "minuto",
            "hora",
            "dia",
            "semana",
            "mese",
            "ano",
            "década"
        ];
    }
    
    protected function getLengths()
    {
        return [
            "60",
            "60",
            "24",
            "7",
            "4.35",
            "12",
            "10"
        ];
    }
    
    /**
     * Retorna o dia da semana traduzido
     * @param string $data
     * @return string
     */
    public function getDiaSemana($data)
    {
        $diasSemana = array(
            'Domingo',
            'Segunda',
            'Terça',
            'Quarta',
            'Quinta',
            'Sexta',
            'Sábado',
        );

        $dia = $diasSemana[date('w', strtotime($data))];
        if ($data == date('Y-m-d')) {
            $dia = 'Hoje';
        } elseif ($data == date('Y-m-d', strtotime('-1 day'))) {
            $dia = 'Ontem';
        }

        return $dia;
    }
}
