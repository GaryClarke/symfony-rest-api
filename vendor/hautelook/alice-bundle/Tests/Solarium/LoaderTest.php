<?php

namespace Hautelook\AliceBundle\Tests\Solarium;

use Hautelook\AliceBundle\Solarium\Loader;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
    private $logger;
    private $client;
    private $updateStatement;

    /**
     * @var Loader
     */
    private $loader;

    public function testLoading()
    {
        $this->loader->setClient($this->client);

        $this->loader->load(array('file1', 'file2'));
    }

    protected function setUp()
    {
        parent::setUp();

        $ymlLoader = $this->getMockBuilder('Nelmio\Alice\Loader\Yaml')
            ->disableOriginalConstructor()
            ->getMock();

        $ymlLoader->expects($this->any())->method('load')
            ->will($this->returnCallback(array($this, 'createMockDocument')));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->loader = new Loader(
            array(
                'yaml' => $ymlLoader,
            ),
            $this->logger
        );

        $this->client = $this->getMockBuilder('Solarium\Core\Client\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $this->updateStatement = $this->getMockBuilder('\Solarium\QueryType\Update\Query\Query')
            ->disableOriginalConstructor()
            ->getMock();

        $this->updateStatement->expects($this->at(0))
            ->method('addDocuments')
            ->with($this->createMockDocument('file1'));

        $this->updateStatement->expects($this->at(1))
            ->method('addDocuments')
            ->with($this->createMockDocument('file2'));

        $this->updateStatement->expects($this->once())
            ->method('addCommit');

        $this->client->expects($this->any())
            ->method('createUpdate')
            ->will($this->returnValue($this->updateStatement));

        $this->client->expects($this->once())->method('execute')
            ->with($this->updateStatement);
    }

    public function createMockDocument($arg)
    {
        $document = $this->getMockBuilder('Solarium\QueryType\Update\Query\Document\DocumentInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $document->originalFileName = $arg;

        return $document;
    }
}
