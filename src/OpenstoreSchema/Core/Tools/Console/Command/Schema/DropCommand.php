<?php

namespace OpenstoreSchema\Core\Tools\Console\Command\Schema;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\Tools\SchemaTool;

class DropCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('openstore:schema:drop')
             ->setDescription(
                 'Drop the current database schema.'
             )
        ->setHelp(<<<EOT
Drop the current database
EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function executeSchemaCommand(InputInterface $input, OutputInterface $output, SchemaTool $schemaTool, array $metadatas)
    {
        $conn = $this->getConnection();
        $current_db = $conn->getDatabase();


        $output->writeln('ATTENTION: This operation should not be executed in a production environment.' . PHP_EOL);

        $qhelper = $this->getHelper('question');

        $question = new Question\ConfirmationQuestion("Are you sure you want to drop database '$current_db' (y/n) ?", false);

        if (!$qhelper->ask($input, $output, $question)) {
            return;
        }

        $query = "drop database if exists $current_db";
        $ret = $conn->exec($query);

        return 0;
    }
}
