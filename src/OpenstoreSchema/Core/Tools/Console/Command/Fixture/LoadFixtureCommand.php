<?php

/*
 * opentore-schema-core
 *
 * @author    Vanvelthem Sébastien
 * @link      https://github.com/belgattitude/openstore-schema-core
 * @copyright Copyright (c) 2015-2017 Vanvelthem Sébastien
 * @license   MIT License, https://github.com/belgattitude/openstore-schema-core/blob/master/LICENSE.md
 *
 */

namespace OpenstoreSchema\Core\Tools\Console\Command\Fixture;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Loader;

class LoadFixtureCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'openstore:schema:load-fixture';

    protected function configure()
    {
        $this
        ->setName($this->name)
        ->setDescription(
            'Load default fixtures on a fresh install.'
        )
        ->addOption('fixtures', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The directory to load data fixtures from.')
        ->addOption('append', null, InputOption::VALUE_NONE, 'Append the data fixtures instead of deleting all data from the database first.')
        ->addOption('purge-with-truncate', null, InputOption::VALUE_NONE, 'Purge data by using a database-level TRUNCATE statement');

        $this->setHelp(
            <<<'EOT'
The <info>%command.name%</info> command generates the SQL needed to load default
fixtures in the database

EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emHelper = $this->getHelper('em');

        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $emHelper->getEntityManager();

        $loader = new Loader();

        if (!$input->getOption('fixtures')) {
            throw new \Exception('Required cli arg missing (--fixtures)');
        }

        if (!$input->getOption('append')) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('Your database will be cleared (use --append to prevent)?', false);

            if (!$helper->ask($input, $output, $question)) {
                return 1;
            }
        }

        $dirOrFile = $input->getOption('fixtures');
        $paths = is_array($dirOrFile) ? $dirOrFile : [$dirOrFile];

        foreach ($paths as $path) {
            if (is_string($path) && is_dir($path)) {
                $loader->loadFromDirectory($path);
            } elseif (is_string($path) && is_file($path)) {
                $loader->loadFromFile($path);
            }
        }

        $fixtures = $loader->getFixtures();
        if (!$fixtures) {
            throw new \InvalidArgumentException(
                sprintf('Could not find any fixtures to load in: %s', "\n\n- " . implode("\n- ", $paths))
            );
        }

        $purger = new ORMPurger($em);
        $purger->setPurgeMode($input->getOption('purge-with-truncate') ? ORMPurger::PURGE_MODE_TRUNCATE : ORMPurger::PURGE_MODE_DELETE);

        $executor = new ORMExecutor($em, $purger);
        $executor->setLogger(function ($message) use ($output) {
            $output->writeln(sprintf('  <comment>></comment> <info>%s</info>', $message));
        });

        //$multiple_transactions = false; //$input->getOption('multiple-transactions');
        $append = true; //$input->getOption('append');
        $executor->execute($fixtures, $append);

        return 0;
    }

    /**
     * Return underlying database connection.
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function getConnection()
    {
        return $this->getHelper('db')->getConnection();
    }
}
