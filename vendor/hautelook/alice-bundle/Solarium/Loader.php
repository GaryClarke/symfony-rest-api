<?php

namespace Hautelook\AliceBundle\Solarium;

use Psr\Log\LoggerInterface;
use Solarium\Core\Client\Client;

/**
 * @author Baldur Rensch <brensch@gmail.com>
 */
class Loader
{
    /**
     * @var array
     */
    private $providers = array();

    /**
     * @var array
     */
    private $loaders;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param                 $loaders
     * @param LoggerInterface $logger
     */
    public function __construct($loaders, LoggerInterface $logger = null)
    {
        $this->loaders = $loaders;
        $this->logger = $logger;
    }

    /**
     * @param array <string> $files
     *
     * @return array
     */
    public function load(array $files)
    {
        $update = $this->client->createUpdate();

        /** @var $loader \Nelmio\Alice\Loader\Base */
        $loader = $this->getLoader('yaml');
        $loader->setProviders($this->providers);

        foreach ($files as $file) {
            $update->addDocuments($loader->load($file));
        }

        $update->addCommit();

        if (null !== $update) {
            $this->client->execute($update);
        }
    }

    /**
     * @param array $providers
     */
    public function setProviders(array $providers)
    {
        $this->providers = $providers;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $key
     *
     * @throws \InvalidArgumentException
     * @return mixed
     */
    protected function getLoader($key)
    {
        if (empty($this->loaders[$key])) {
            throw new \InvalidArgumentException("Unknown loader type: {$key}");
        }

        /** @var $loader \Nelmio\Alice\LoaderInterface */
        $loader = $this->loaders[$key];

        return $loader;
    }
}
