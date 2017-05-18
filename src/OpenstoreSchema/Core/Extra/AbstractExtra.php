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

namespace OpenstoreSchema\Core\Extra;

abstract class AbstractExtra
{
    /**
     * @return array
     */
    public function getExtrasDDL()
    {
        $stmts = array_merge(
            $this->getSqlAlters(),
            $this->getFunctions(),
            $this->getProcedures(),
            $this->getTriggers(),
            $this->getEvents()
        );

        foreach ($stmts as $idx => $operations) {
            if (is_array($operations)) {
                foreach ($operations as $key => $value) {
                    $stmts[$idx][$key] = trim($value);
                }
            }
        }

        return $stmts;
    }

    /**
     * Return DDL for database functions.
     *
     * @return array
     */
    abstract public function getFunctions();

    /**
     * Return DDL for database procedures.
     *
     * @return array
     */
    abstract public function getProcedures();

    /**
     * Return DDL for database triggers.
     *
     * @return array
     */
    abstract public function getTriggers();

    /**
     * Return DDL for database events.
     *
     * @return array
     */
    abstract public function getEvents();

    /**
     * Return DDL for database alters.
     *
     * @return array
     */
    abstract public function getSqlAlters();
}
