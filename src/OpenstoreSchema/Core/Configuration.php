<?php

namespace OpenstoreSchema\Core;

class Configuration
{    
    /**
     *
     * @var array|null
     */
    protected static $paths;
    
    /**
     *
     * @var string
     */
    protected static $namespace = 'OpenstoreSchema\Core\Entity';
    
    /**
     * Return entity paths
     * 
     * @return array
     */
    static public function getEntityPaths()
    {
        if (self::$paths === null) {
            self::$paths = array(realpath(__DIR__ . DIRECTORY_SEPARATOR . 'Entity')); 
        } 
        return self::$paths;
    }
    
    
    /**
     * Return entity namespace
     * @return string
     */
    static public function getEntityNamespace()
    {
        return self::$namespace;
    }
    
    
    
}

