<?php

namespace Hautelook\AliceBundle\Solarium;

use Solarium\Core\Client\Client;
use Solarium\Support\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Baldur Rensch <brensch@gmail.com>
 */
abstract class DataFixtureLoader implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param Client $client
     */
    public function load(Client $client)
    {
        /** @var $loader \Hautelook\AliceBundle\Solarium\Loader */
        $loader = $this->container->get('hautelook_alice.solarium.loader');
        $loader->setProviders(array($this));
        $loader->setClient($client);

        $loader->load($this->getFixtures());
    }

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    abstract public function getFixtures();
}
