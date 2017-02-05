<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Tests\Security;


use Spiral\Security\ActorInterface;
use Spiral\Security\Exceptions\GuardException;
use Spiral\Security\Guard;
use Spiral\Security\PermissionsInterface;
use Spiral\Security\RuleInterface;

/**
 * Class GuardTest
 *
 * @package Spiral\Tests\Security
 */
class GuardTest extends \PHPUnit_Framework_TestCase
{
    const OPERATION = 'test';
    const CONTEXT   = [];

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|PermissionsInterface
     */
    private $permission;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ActorInterface
     */
    private $actor;

    /**
     * @var array
     */
    private $roles = ['user', 'admin'];

    public function setUp()
    {
        $this->permission = $this->createMock(PermissionsInterface::class);
        $this->actor = $this->createMock(ActorInterface::class);
    }

    public function testAllows()
    {
        $this->permission->method('hasRole')
            ->withConsecutive(['user'], ['admin'])
            ->willReturnOnConsecutiveCalls(false, true);

        $rule = $this->createMock(RuleInterface::class);
        $rule->expects($this->once())
            ->method('allows')
            ->with($this->actor, static::OPERATION, [])->willReturn(true);

        $this->permission->method('getRule')
            ->willReturn($rule);

        $guard = new Guard($this->permission, $this->actor, $this->roles);
        $this->assertTrue($guard->allows(static::OPERATION, static::CONTEXT));
    }

    public function testAllowsPermissionsHasNoRole()
    {
        $this->permission->method('hasRole')->with($this->anything())->willReturn(false);

        $guard = new Guard($this->permission, $this->actor, $this->roles);
        $this->assertFalse($guard->allows(static::OPERATION, static::CONTEXT));
    }

    public function testAllowsNoActor()
    {
        $guard = new Guard($this->permission, null, $this->roles);

        $this->expectException(GuardException::class);
        $guard->allows(static::OPERATION, static::CONTEXT);
    }

    public function testWithActor()
    {
        $guard = new Guard($this->permission);
        $guardWithActor = $guard->withActor($this->actor);

        $this->assertEquals($this->actor, $guardWithActor->getActor());
        $this->assertNotEquals($guard, $guardWithActor);
    }

    public function testWithRoles()
    {
        $guard = new Guard($this->permission, $this->actor);
        $guardWithRoles = $guard->withRoles($this->roles);

        $this->assertEquals($this->roles, $guardWithRoles->getRoles());
        $this->assertNotEquals($guard, $guardWithRoles);
    }
}