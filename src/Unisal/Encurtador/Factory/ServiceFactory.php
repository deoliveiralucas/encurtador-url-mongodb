<?php

namespace Unisal\Encurtador\Factory;

use Unisal\Encurtador\MongoDB\Config as MongoConfig;
use Unisal\Encurtador\Mapper\EncurtadorMapper;
use Unisal\Encurtador\Service\EncurtadorService;
use Unisal\Encurtador\Service\PeriodoService;
use Unisal\Encurtador\Service\URLService;
use Unisal\Encurtador\Service\GraficoGoogleService;

/**
 * Classe responsável por criar os objetos
 * @author Lucas Oliveira
 */
class ServiceFactory
{
    /**
     * @return EncurtadorService
     */
    public static function createEncurtadorService()
    {
        $mongoDB = MongoConfig::getConnection();
        $encurtadorService = new EncurtadorService(
            new EncurtadorMapper($mongoDB),
            new PeriodoService()
        );
        
        return $encurtadorService;
    }
    
    /**
     * @return PeriodoService
     */
    public static function createPeriodoService()
    {
        return new PeriodoService();
    }
    
    /**
     * @return URLService
     */
    public static function createURLService()
    {
        return new URLService();
    }
    
    /**
     * @return GraficoGoogleService
     */
    public static function createGraficoGoogleService()
    {
        return new GraficoGoogleService(self::createPeriodoService());
    }
}
