<?php


namespace OpenstoreSchema\Core\Tools\Console\Command\Schema;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\Tools\SchemaTool;

abstract class AbstractCommand extends Command
{
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param SchemaTool      $schemaTool
     * @param array           $metadatas
     *
     * @return null|int Null or 0 if everything went fine, or an error code.
     */
    abstract protected function executeSchemaCommand(InputInterface $input, OutputInterface $output, SchemaTool $schemaTool, array $metadatas);

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emHelper = $this->getHelper('em');

        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $emHelper->getEntityManager();

        $metadatas = $em->getMetadataFactory()->getAllMetadata();

        if (! empty($metadatas)) {
            // Create SchemaTool
            $tool = new SchemaTool($em);

            return $this->executeSchemaCommand($input, $output, $tool, $metadatas);
        } else {
            $output->writeln('No Metadata Classes to process.');
            return 0;
        }
    }

    /**
     * Return underlying database connection
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function getConnection()
    {
        return $this->getHelper('db')->getConnection();
    }
}
