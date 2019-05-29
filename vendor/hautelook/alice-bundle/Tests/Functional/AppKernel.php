<?php

namespace Hautelook\AliceBundle\Tests\Functional;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Hautelook\AliceBundle\HautelookAliceBundle;
use Hautelook\AliceBundle\Tests\Functional\TestBundle\TestBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return array(
            new FrameworkBundle(),
            new HautelookAliceBundle(),
            new DoctrineBundle(),
            new DoctrineFixturesBundle(),

            new TestBundle(),
        );
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir().'/AliceBundle/';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
