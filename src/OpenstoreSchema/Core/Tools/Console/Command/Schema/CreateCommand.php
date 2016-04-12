<?php

namespace OpenstoreSchema\Core\Tools\Console\Command\Schema;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\Tools\SchemaTool;
use OpenstoreSchema\Core\Extra;

class CreateCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('openstore:schema:create')
             ->setDescription(
                 'Processes the schema and either create it directly on EntityManager Storage Connection or generate the SQL output.'
             )
        ->setDefinition([
            new InputOption(
                'dump-sql',
                null,
                InputOption::VALUE_NONE,
                'Instead of trying to apply generated SQLs into EntityManager Storage Connection, output them.'
            )
        ])
        ->setHelp(<<<EOT
Processes the schema and either create it directly on EntityManager Storage Connection or generate the SQL output.

<comment>Hint:</comment> If you have a database with tables that should not be managed
by the ORM, you can use a DBAL functionality to filter the tables and sequences down
on a global level:

    \$config->setFilterSchemaAssetsExpression(\$regexp);
EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function executeSchemaCommand(InputInterface $input, OutputInterface $output, SchemaTool $schemaTool, array $metadatas)
    {
        $extra = new Extra\MysqlExtra();
        if ($input->getOption('dump-sql')) {
            $sqls = $schemaTool->getCreateSchemaSql($metadatas);

            $output->writeln(implode(';' . PHP_EOL, $sqls) . ';');

            $ddls = $extra->getExtrasDDLWithDelimiter();
            $output->writeln($ddls);
        } else {
            $conn = $this->getConnection();

            $output->writeln('ATTENTION: This operation should not be executed in a production environment.' . PHP_EOL);



            $output->writeln('Creating database schema...');
            $schemaTool->createSchema($metadatas);

            $output->writeln('Recreating database extras...');
            $metadatas = $extra->getExtrasDDL();


            foreach ($metadatas as $key => $ddl) {
                $output->writeln("Executing: $key");
                $ret = $conn->exec($ddl);
            }
            $output->writeln('Database schema and extras created successfully!');
        }

        return 0;
    }
}
