<?php

namespace Hautelook\AliceBundle\Tests\Functional\Command;

use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Doctrine\Bundle\FixturesBundle\Command\LoadDataFixturesDoctrineCommand;
use Hautelook\AliceBundle\Tests\Functional\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class DoctrineFixtureTest extends TestCase
{
    /**
     * @var Application
     */
    private $application;

    public function testFixture()
    {
        $command = $this->application->find('doctrine:fixtures:load');

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(), array('interactive' => false));

        $display = $commandTester->getDisplay();

        $this->assertContains('> purging database', $display);
        $this->assertContains(
            '> loading Hautelook\AliceBundle\Tests\Functional\TestBundle\DataFixtures\ORM\FixtureLoader1',
            $display
        );
        $this->assertContains(
            '> loading Hautelook\AliceBundle\Tests\Functional\TestBundle\DataFixtures\ORM\FixtureLoader2',
            $display
        );

        $this->verifyProducts();
        $this->verifyBrands();
    }

    protected function setUp()
    {
        parent::setUp();

        $this->application = new Application(self::getKernel());
        $this->application->add(new LoadDataFixturesDoctrineCommand());
        $this->application->add(new CreateSchemaDoctrineCommand());

        $this->createDB();
    }

    private function createDB()
    {
        $command = $this->application->find('doctrine:schema:create');

        $commandTester = new CommandTester($command);
        $commandTester->execute(array());
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private function getDoctrine()
    {
        return $this->application->getKernel()->getContainer()->get('doctrine');
    }

    private function verifyProducts()
    {
        for ($i = 1; $i <= 10; $i++) {
            /** @var $brand \Hautelook\AliceBundle\Tests\Functional\TestBundle\Entity\Product */
            $product = $this->getDoctrine()->getManager()->find(
                'Hautelook\AliceBundle\Tests\Functional\TestBundle\Entity\Product',
                $i
            );
            $this->assertStringStartsWith('Awesome Product', $product->getDescription());

            // Make sure every product has a brand
            $this->assertInstanceOf(
                'Hautelook\AliceBundle\Tests\Functional\TestBundle\Entity\Brand',
                $product->getBrand()
            );
        }
    }

    private function verifyBrands()
    {
        for ($i = 1; $i <= 10; $i++) {
            /** @var $brand \Hautelook\AliceBundle\Tests\Functional\TestBundle\Entity\Brand */
            $brand = $this->getDoctrine()->getManager()->find(
                'Hautelook\AliceBundle\Tests\Functional\TestBundle\Entity\Brand',
                $i
            );
        }
    }
}
