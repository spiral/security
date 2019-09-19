<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Tests\Traits;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Spiral\Core\Container;
use Spiral\Core\ContainerScope;
use Spiral\Security\GuardInterface;
use Spiral\Security\Tests\Traits\Fixtures\Guarded;
use Spiral\Security\Tests\Traits\Fixtures\GuardedWithNamespace;
use Spiral\Security\Traits\GuardedTrait;

class GuardedTraitTest extends TestCase
{
    const OPERATION = 'test';
    const CONTEXT = [];

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|GuardedTrait
     */
    private $trait;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|GuardInterface
     */
    private $guard;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface
     */
    private $container;

    public function setUp()
    {
        $this->trait = $this->getMockForTrait(GuardedTrait::class);
        $this->guard = $this->createMock(GuardInterface::class);
        $this->container = $this->createMock(ContainerInterface::class);
    }

    public function testGetGuardFromContainer()
    {
        $this->container->method('has')->willReturn(true);
        $this->container->method('get')->will($this->returnValue($this->guard));

        ContainerScope::runScope($this->container, function () {
            $this->assertEquals($this->guard, $this->trait->getGuard());
        });
    }

    /**
     * @expectedException \Spiral\Core\Exception\ScopeException
     */
    public function testGuardScopeException()
    {
        $this->container->method('has')->willReturn(false);

        ContainerScope::runScope($this->container, function () {
            $this->assertEquals($this->guard, $this->trait->getGuard());
        });
    }

    /**
     * @expectedException \Spiral\Core\Exception\ScopeException
     */
    public function testGuardScopeException2()
    {
        $this->assertEquals($this->guard, $this->trait->getGuard());
    }

    public function testAllows()
    {
        $this->guard->method('allows')
            ->with(static::OPERATION, static::CONTEXT)
            ->will($this->returnValue(true));

        $guarded = new Guarded();

        $container = new Container();
        $container->bind(GuardInterface::class, $this->guard);

        ContainerScope::runScope($container, function () use ($guarded) {
            $this->assertTrue($guarded->allows(static::OPERATION, static::CONTEXT));
            $this->assertFalse($guarded->denies(static::OPERATION, static::CONTEXT));
        });
    }

    public function testResolvePermission()
    {
        $guarded = new Guarded();
        $this->assertEquals(static::OPERATION, $guarded->resolvePermission(static::OPERATION));

        $guarded = new GuardedWithNamespace();
        $resolvedPermission = GuardedWithNamespace::GUARD_NAMESPACE . '.' . static::OPERATION;
        $this->assertEquals($resolvedPermission, $guarded->resolvePermission(static::OPERATION));
    }
}
