<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Tests\Security\Traits\Fixtures;


use Interop\Container\ContainerInterface;
use Spiral\Security\Traits\GuardedTrait;

/**
 * Class Guarded
 *
 * @package Spiral\Tests\Security\Traits\Fixtures
 */
class Guarded
{
    use GuardedTrait {
        allows as public;
        denies as public;
        resolvePermission as public;
    }

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function setIocContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    protected function iocContainer()
    {
        return $this->container;
    }
}