<?php

namespace Hautelook\AliceBundle\Tests\Functional\TestBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class FixtureLoader1 extends DataFixtureLoader implements DependentFixtureInterface
{
    /**
     * Returns an array of file paths to fixtures
     *
     * @return string[]
     */
    protected function getFixtures()
    {
        return array(
            __DIR__ . '/product.yml',
        );
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return string[]
     */
    function getDependencies()
    {
        return array(
            'Hautelook\AliceBundle\Tests\Functional\TestBundle\DataFixtures\ORM\FixtureLoader2',
        );
    }
}
