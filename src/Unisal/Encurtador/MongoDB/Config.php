<?php

namespace Unisal\Encurtador\MongoDB;

/**
 * @author Lucas Oliveira
 */
class Config
{
    
    /**
     * Configura e retorna objeto para manipulação do MongoDB
     * @return \MongoClient
     */
    public static function getConnection()
    {
        $mongoClient = new \MongoClient();
        $mongoDB = $mongoClient->selectDB('unisal');
        
        return $mongoDB;
    }
}
