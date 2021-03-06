<?php

declare(strict_types=1);

/*
 * opentore-schema-core
 *
 * @author    Vanvelthem Sébastien
 * @link      https://github.com/belgattitude/openstore-schema-core
 * @copyright Copyright (c) 2015-2017 Vanvelthem Sébastien
 * @license   MIT License, https://github.com/belgattitude/openstore-schema-core/blob/master/LICENSE.md
 *
 */

namespace OpenstoreSchema\Core\Tools\Console\Command\Schema;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\Tools\SchemaTool;
use OpenstoreSchema\Core\Extra;

class RecreateExtraCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('openstore:schema:recreate-extra')
             ->setDescription(
                 'Add database extra ddl like triggers, procedures, functions...'
             )
        ->setDefinition([
            new InputOption(
                'dump-sql',
                null,
                InputOption::VALUE_NONE,
                'Instead of trying to apply generated DDLs into EntityManager, output them.'
            )
        ])
        ->setHelp(
            <<<'EOT'
Processes the extra DDL statements and either create it directly on EntityManager Storage Connection or generate the SQL output.
EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function executeSchemaCommand(InputInterface $input, OutputInterface $output, SchemaTool $schemaTool, array $metadatas): ?int
    {
        $extra = new Extra\MysqlExtra();

        if ($input->getOption('dump-sql')) {
            $sqls = [];
            $ddls = $extra->getExtrasDDLWithDelimiter();

            $output->writeln($ddls);
        } else {
            $output->writeln('ATTENTION: This operation should not be executed in a production environment.' . PHP_EOL);

            $output->writeln('Recreating database extras...');
            $metadatas = $extra->getExtrasDDL();
            $connHelper = $this->getHelper('db');
            $conn = $connHelper->getConnection();

            foreach ($metadatas as $key => $ddl) {
                $output->writeln("Executing: $key");
                $ret = $conn->exec($ddl);
            }
            $output->writeln('Database extras (re-)created successfully!');
        }

        return 0;
    }
}
