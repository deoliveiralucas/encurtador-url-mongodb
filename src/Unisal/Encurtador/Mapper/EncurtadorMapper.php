<?php

namespace Unisal\Encurtador\Mapper;

use Unisal\Encurtador\Mapper\IMapper;

/**
 * @author Lucas de Oliveira
 */
class EncurtadorMapper implements IMapper
{
    /**
     * @var \MongoCollection
     */
    protected $mongoCollection;
    
    /**
     * Nome da collection
     * @var string
     */
    protected $collection = 'links';
    
    public function __construct(\MongoDB $mongoDB)
    {
        $this->mongoCollection = $mongoDB->selectCollection($this->collection);
    }
    
    public function find(array $filter, array $fields = array())
    {
        $links = $this->mongoCollection->find($filter, $fields);
        return $links;
    }

    public function findOne(array $filter, array $fields = array())
    {
        $link = $this->mongoCollection->findOne($filter, $fields);
        return $link;
    }

    public function save(array $dados)
    {
        return $this->mongoCollection->save($dados);
    }
    
    public function update(array $where, array $object)
    {
        return $this->mongoCollection->update($where, $object);
    }
    
    public function findSortedByDate(array $filter, $limit = 10)
    {
        return $this
            ->mongoCollection
            ->find($filter)
            ->sort(array('horario' => -1))
            ->limit($limit)
        ;
    }
}
