<?php
namespace DefaultDataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use OpenstoreSchema\Core\Entity\ProductTarget;

class ProductTargetFixtureLoader implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $all = new ProductTarget();
        $all->setTitle('All');
        $all->setDescription('For all target audiences');
        $all->setReference('ALL');
        $all->setFlagExcludeEnduser(false);
        $all->getCreatedBy('fixtures');

        $pro = new ProductTarget();
        $pro->setTitle('Professional');
        $pro->setDescription('Only for professional');
        $pro->setReference('PRO');
        $pro->setFlagExcludeEnduser(false);
        $pro->getCreatedBy('fixtures');

        $shops = new ProductTarget();
        $shops->setTitle('Shops');
        $shops->setDescription('Only for shops');
        $shops->setReference('SHOPS');
        $shops->setFlagExcludeEnduser(true);
        $shops->getCreatedBy('fixtures');

        $logger = new class() extends EchoSQLLogger {

        };
        /**
         * @var $em \Doctrine\ORM\EntityManager
         */
        $em = $manager;

/*
        $em->getConnection()->getConfiguration()->setSQLLogger($logger);
*/
//        $em->beginTransaction();
        $em->persist($all);
        $em->persist($pro);
        $em->persist($shops);

        $manager->flush();
//      $em->rollback();

    }
}
