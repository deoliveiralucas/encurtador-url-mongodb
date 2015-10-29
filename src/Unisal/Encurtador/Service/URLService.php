<?php

namespace Unisal\Encurtador\Service;

/**
 * @author Lucas Oliveira
 */
class URLService
{
    
    /**
     * Retorna algumas informações da URL
     * @param string $url
     * @return array
     */
    public function getURLInfo($url)
    {
        // Obtêm HTML da URL informada
        $html = file_get_contents($url);

        // Array que receberá os dados extraídos
        $dados = [];

        // Se a URL retornou algum conteúdo
        if (strlen($html) > 0) {
            // Tenta obter o título da página
            preg_match("#<title>(.*?)\</title>#si", $html, $title);
            $dados["titulo"] = $title[1];

            // Tenta obter a descrição da página
            preg_match('/<meta(?=[^>]*name="description")\s[^>]*content="([^>]*)"/si', $html, $descricao);
            $dados["descricao"] = (isset($descricao[1])) ? $descricao[1] : 'Descrição não encontrada.';

            // Tenta obter o favicon da página
            $dados["icone"] = $this->getFavIconImage($html);
        }

        // Retorna array com os dados da página (caso exista)
        return $dados;
    }
    
    protected function getFavIconImage($html)
    {
        $matches = [];
        
        preg_match('/<link.*?rel=("|\').*icon("|\').*?href=("|\')(.*?)("|\')/i', $html, $matches);
        if (count($matches) > 4) {
            return trim($matches[4]);
        }

        preg_match('/<link.*?href=("|\')(.*?)("|\').*?rel=("|\').*icon("|\')/i', $html, $matches);
        if (count($matches) > 2) {
            return trim($matches[2]);
        }
        
        return '';
    }
}
