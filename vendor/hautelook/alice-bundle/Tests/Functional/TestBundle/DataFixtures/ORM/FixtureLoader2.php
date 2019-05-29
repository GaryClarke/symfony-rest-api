<?php

namespace Hautelook\AliceBundle\Tests\Functional\TestBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class FixtureLoader2 extends DataFixtureLoader
{
    /**
     * Returns an array of file paths to fixtures
     *
     * @return string[]
     */
    protected function getFixtures()
    {
        return array(
            __DIR__ . '/brand.yml',
        );
    }
}
