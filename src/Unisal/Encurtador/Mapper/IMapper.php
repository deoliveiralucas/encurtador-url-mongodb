<?php

namespace Unisal\Encurtador\Mapper;

/**
 * @author Lucas de Oliveira
 */
interface IMapper
{
    /**
     * Salva dados do array no banco de dados.
     * @param array $dados
     */
    public function save(array $dados);
    
    /**
     * Retorna um valor do banco de dados.
     * @param array $filter
     */
    public function findOne(array $filter, array $fields = array());
    
    /**
     * Retorna varios dados do banco.
     * @param array $filter
     */
    public function find(array $filter, array $fields = array());
    
    /**
     * Retorna varios dados ordenados por datahora e limitado.
     * @param array $filter
     * @param integer $limit
     */
    public function findSortedByDate(array $filter, $limit = 10);
    
    /**
     * Atualiza dados do banco
     * @param array $where
     * @param array $object
     */
    public function update(array $where, array $object);
}
