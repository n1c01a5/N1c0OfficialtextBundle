<?php

namespace N1c0\OfficialtextBundle\Tests\Handler;

use N1c0\OfficialtextBundle\Handler\OfficialtextHandler;
use N1c0\OfficialtextBundle\Model\OfficialtextInterface;
use N1c0\OfficialtextBundle\Entity\Officialtext;

class OfficialtextHandlerTest extends \PHPUnit_Framework_TestCase
{
    const PAGE_CLASS = 'n1c0\OfficialtextBundle\Tests\Handler\DummyOfficialtext';

    /** @var OfficialtextHandler */
    protected $officialtextHandler;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }
        
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::PAGE_CLASS))
            ->will($this->returnValue($this->repository));
        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::PAGE_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::PAGE_CLASS));
    }


    public function testGet()
    {
        $id = 1;
        $officialtext = $this->getOfficialtext();
        $this->repository->expects($this->once())->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($officialtext));

        $this->officialtextHandler = $this->createOfficialtextHandler($this->om, static::PAGE_CLASS,  $this->formFactory);

        $this->officialtextHandler->get($id);
    }

    public function testAll()
    {
        $offset = 1;
        $limit = 2;

        $officialtexts = $this->getOfficialtexts(2);
        $this->repository->expects($this->once())->method('findBy')
            ->with(array(), null, $limit, $offset)
            ->will($this->returnValue($officialtexts));

        $this->officialtextHandler = $this->createOfficialtextHandler($this->om, static::PAGE_CLASS,  $this->formFactory);

        $all = $this->officialtextHandler->all($limit, $offset);

        $this->assertEquals($officialtexts, $all);
    }

    public function testPost()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $officialtext = $this->getOfficialtext();
        $officialtext->setTitle($title);
        $officialtext->setBody($body);

        $form = $this->getMock('n1c0\OfficialtextBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($officialtext));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->officialtextHandler = $this->createOfficialtextHandler($this->om, static::PAGE_CLASS,  $this->formFactory);
        $officialtextObject = $this->officialtextHandler->post($parameters);

        $this->assertEquals($officialtextObject, $officialtext);
    }

    /**
     * @expectedException n1c0\OfficialtextBundle\Exception\InvalidFormException
     */
    public function testPostShouldRaiseException()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $officialtext = $this->getOfficialtext();
        $officialtext->setTitle($title);
        $officialtext->setBody($body);

        $form = $this->getMock('n1c0\OfficialtextBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->officialtextHandler = $this->createOfficialtextHandler($this->om, static::PAGE_CLASS,  $this->formFactory);
        $this->officialtextHandler->post($parameters);
    }

    public function testPut()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $officialtext = $this->getOfficialtext();
        $officialtext->setTitle($title);
        $officialtext->setBody($body);

        $form = $this->getMock('n1c0\OfficialtextBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($officialtext));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->officialtextHandler = $this->createOfficialtextHandler($this->om, static::PAGE_CLASS,  $this->formFactory);
        $officialtextObject = $this->officialtextHandler->put($officialtext, $parameters);

        $this->assertEquals($officialtextObject, $officialtext);
    }

    public function testPatch()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('body' => $body);

        $officialtext = $this->getOfficialtext();
        $officialtext->setTitle($title);
        $officialtext->setBody($body);

        $form = $this->getMock('n1c0\OfficialtextBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($officialtext));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->officialtextHandler = $this->createOfficialtextHandler($this->om, static::PAGE_CLASS,  $this->formFactory);
        $officialtextObject = $this->officialtextHandler->patch($officialtext, $parameters);

        $this->assertEquals($officialtextObject, $officialtext);
    }


    protected function createOfficialtextHandler($objectManager, $officialtextClass, $formFactory)
    {
        return new OfficialtextHandler($objectManager, $officialtextClass, $formFactory);
    }

    protected function getOfficialtext()
    {
        $officialtextClass = static::PAGE_CLASS;

        return new $officialtextClass();
    }

    protected function getOfficialtexts($maxOfficialtexts = 5)
    {
        $officialtexts = array();
        for($i = 0; $i < $maxOfficialtexts; $i++) {
            $officialtexts[] = $this->getOfficialtext();
        }

        return $officialtexts;
    }
}

class DummyOfficialtext extends Officialtext
{
}
