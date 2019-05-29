<?php

namespace Hautelook\AliceBundle\Alice;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Nelmio\Alice\ProcessorInterface;

/**
 * Class DataFixtureLoader
 *
 * @author Baldur Rensch <brensch@gmail.com>
 */
abstract class DataFixtureLoader implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     * @return ArrayCollection
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        /** @var $loader \Hautelook\AliceBundle\Alice\Loader */
        $loader = $this->container->get('hautelook_alice.loader');
        $loader->setObjectManager($manager);
        $loader->setProviders(array($this));

        foreach ($this->getProcessors() as $processor) {
            $loader->addProcessor($processor);
        }

        $loader->load($this->getFixtures());

        return $loader->getReferences();
    }

    /**
     * Returns an array of file paths to fixtures
     *
     * @return array<string>
     */
    abstract protected function getFixtures();

    /**
     * Returns an array of ProcessorInterface to process fixtures
     *
     * @return ProcessorInterface[]
     */
    protected function getProcessors()
    {
        return array();
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Find Entity by primary key(s)
     *
     * @param string               $className
     * @param string|array<string> $ids
     *
     * @return object
     */
    public function find($className, $ids)
    {
        return $this->manager->find($className, $ids);
    }

    /**
     * This is the identity provider that is currently not available in the stable version
     * of Alice 1.* This will be available natively in 2.
     *
     * @param mixed $input
     * @return mixed
     */
    public function identity($input)
    {
        return $input;
    }
}
