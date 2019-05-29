<?php

namespace Hautelook\AliceBundle\Tests\Alice;

use Hautelook\AliceBundle\Alice\Doctrine;

/**
 * Class DoctrineTest
 * @author Baldur Rensch <baldur.rensch@hautelook.com>
 */
class DoctrineTest extends \PHPUnit_Framework_TestCase
{
    protected $objectManager;

    protected $doctrine;

    public function testDoctrineMerge()
    {
        $testObj = new \stdClass();

        $this->objectManager->expects($this->once())->method('merge')
            ->with($testObj);

        $this->doctrine->merge($testObj);
    }

    public function testDoctrineDetach()
    {
        $testObj = new \stdClass();

        $this->objectManager->expects($this->once())->method('detach')
            ->with($testObj);

        $this->doctrine->detach($testObj);
    }

    protected function setUp()
    {
        $this->objectManager = $this->getMockBuilder('Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->doctrine = new Doctrine($this->objectManager);
    }
}
