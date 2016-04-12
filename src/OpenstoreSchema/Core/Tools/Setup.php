<?php

namespace OpenstoreSchema\Core\Tools;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\Common\Cache as DoctrineCache;
use Doctrine\ORM\Tools\Setup as DoctrineSetup;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Gedmo;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\Common\EventManager;

class Setup
{

    /**
     * @var array
     */
    protected $dbParams;

    /**
     * Paths to store entities
     * @var array
     */
    protected $paths;


    /**
     * Entity namespace
     * @var string
     */
    protected $namespace;

    /**
     *
     * @var string development|production
     */
    protected $env;

    /**
     *
     * @var string
     */
    protected $proxy_path;

    /**
     * Constructor
     * @param array $dbParams database connection configuration
     * @param array $paths paths to look for entities
     * @param string $namespace entity namespace
     */
    public function __construct(array $dbParams, array $paths, $namespace)
    {
        $this->dbParams = $dbParams;
        $this->paths = $paths;
        $this->namespace = $namespace;
        $this->proxy_path = sys_get_temp_dir();
    }

    /**
     * @var string production|development
     */
    public function setEnvironment($env)
    {
        $this->env = $env;
    }

    /**
     *
     * @param string $path
     */
    public function setProxyPath($path)
    {
        $this->proxy_path = $path;
    }


    /**
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        $cache = new DoctrineCache\ArrayCache();

        $annotationReader = new AnnotationReader();
        $cachedAnnotationReader = new CachedReader(
            $annotationReader,
            $cache
        );

        // create a driver chain for metadata reading
        $driverChain = new MappingDriverChain();

        // load superclass metadata mapping only, into driver chain
        // also registers Gedmo annotations.NOTE: you can personalize it
        Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM(
            $driverChain, // our metadata driver chain, to hook into
            $cachedAnnotationReader // our cached annotation reader
        );

        // now we want to register our application entities,
        // for that we need another metadata driver used for Entity namespace
        $annotationDriver = new AnnotationDriver(
            $cachedAnnotationReader, // our cached annotation reader
            $this->paths
        );


        $driverChain->addDriver($annotationDriver, $this->namespace);

        // general ORM configuration

        $isDevMode = $this->env != "production";
        $config = DoctrineSetup::createAnnotationMetadataConfiguration($this->paths, $isDevMode);
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        $config->setMetadataDriverImpl($driverChain);
        $config->setProxyDir($this->proxy_path);
        $config->setProxyNamespace($this->namespace . '\Proxy');
        $config->setAutoGenerateProxyClasses($isDevMode);


        // Third, create event manager and hook prefered extension listeners
        $evm = new EventManager();

        // gedmo extension listeners
        // sluggable
        $sluggableListener = new Gedmo\Sluggable\SluggableListener();
        // you should set the used annotation reader to listener, to avoid creating new one for mapping drivers
        $sluggableListener->setAnnotationReader($cachedAnnotationReader);
        $evm->addEventSubscriber($sluggableListener);

        // tree
        $treeListener = new Gedmo\Tree\TreeListener();
        $treeListener->setAnnotationReader($cachedAnnotationReader);
        $evm->addEventSubscriber($treeListener);

        // loggable, not used in example
        $loggableListener = new Gedmo\Loggable\LoggableListener;
        $loggableListener->setAnnotationReader($cachedAnnotationReader);
        $loggableListener->setUsername('unknown');
        $evm->addEventSubscriber($loggableListener);

        // timestampable
        $timestampableListener = new Gedmo\Timestampable\TimestampableListener();
        $timestampableListener->setAnnotationReader($cachedAnnotationReader);
        $evm->addEventSubscriber($timestampableListener);

        // blameable
        $blameableListener = new Gedmo\Blameable\BlameableListener();
        $blameableListener->setAnnotationReader($cachedAnnotationReader);
        $blameableListener->setUserValue('unknown'); // determine from your environment
        $evm->addEventSubscriber($blameableListener);

        // translatable - buggy !!!
        /*
        $translatableListener = new Gedmo\Translatable\TranslatableListener();
        // current translation locale should be set from session or hook later into the listener
        // most important, before entity manager is flushed
        $translatableListener->setTranslatableLocale('en');
        $translatableListener->setDefaultLocale('en');
        $translatableListener->setAnnotationReader($cachedAnnotationReader);
        $evm->addEventSubscriber($translatableListener);
        */

        // sortable, not used in example
        $sortableListener = new Gedmo\Sortable\SortableListener;
        $sortableListener->setAnnotationReader($cachedAnnotationReader);
        $evm->addEventSubscriber($sortableListener);

        // mysql set names UTF-8 if required
        $evm->addEventSubscriber(new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit());

        // Finally, create entity manager
        return EntityManager::create($this->dbParams, $config, $evm);
    }
}
