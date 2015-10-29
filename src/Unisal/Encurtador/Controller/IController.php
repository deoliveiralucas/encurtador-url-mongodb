<?php

namespace Unisal\Encurtador\Controller;

/**
 * Interface para ser implementada por um Controller
 * reponsável por manipular a requisição do usuário.
 * @author Lucas de Oliveira
 */
interface IController
{
    
    /**
     * Verifica se Controller consegue manipular
     * a requisição do usuário.
     * @return boolean
     */
    public function canHandle();

    /**
     * Manipula a requisição do usuário.
     */
    public function handle();
}
