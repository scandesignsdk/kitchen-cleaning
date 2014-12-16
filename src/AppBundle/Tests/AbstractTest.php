<?php
namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractTest extends KernelTestCase
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    static protected $entitymanager;

    /**
     * @var ContainerInterface
     */
    static protected $container;

    public static function setUpBeforeClass()
    {
        self::bootKernel();
        self::$container = static::$kernel->getContainer();
        self::$entitymanager = self::$container->get('doctrine.orm.entity_manager');
    }

}
