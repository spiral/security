<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Tests\Security;


use Spiral\Security\Exceptions\PermissionException;
use Spiral\Security\Exceptions\RoleException;
use Spiral\Security\PermissionManager;
use Spiral\Security\Rules\AllowRule;
use Spiral\Security\Rules\ForbidRule;
use Spiral\Security\RulesInterface;
use Spiral\Support\Patternizer;

/**
 * Class PermissionManagerTest
 *
 * @package Spiral\Tests\Security
 */
class PermissionManagerTest extends \PHPUnit_Framework_TestCase
{
    const ROLE       = 'test';
    const PERMISSION = 'permission';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RulesInterface
     */
    private $rules;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Patternizer
     */
    private $patternizer;

    public function setUp()
    {
        $this->rules = $this->createMock(RulesInterface::class);
        $this->patternizer = $this->createMock(Patternizer::class);
    }

    public function testRoles()
    {
        $manager = new PermissionManager($this->rules, $this->patternizer);

        $this->assertFalse($manager->hasRole(static::ROLE));
        $this->assertEquals($manager, $manager->addRole(static::ROLE));
        $this->assertTrue($manager->hasRole(static::ROLE));
        $this->assertEquals($manager, $manager->removeRole(static::ROLE));
        $this->assertFalse($manager->hasRole(static::ROLE));

        $manager->addRole('one');
        $manager->addRole('two');
        $this->assertEquals(['one', 'two'], $manager->getRoles());
    }

    public function testAddRoleException()
    {
        $manager = new PermissionManager($this->rules, $this->patternizer);

        $this->expectException(RoleException::class);
        $manager->addRole(static::ROLE);
        $manager->addRole(static::ROLE);
    }

    public function testRemoveRoleException()
    {
        $manager = new PermissionManager($this->rules, $this->patternizer);

        $this->expectException(RoleException::class);
        $manager->removeRole(static::ROLE);
    }

    public function testAssociation()
    {
        $allowRule = new AllowRule();
        $forbidRule = new ForbidRule();

        $this->rules->method('has')->willReturn(true);
        $this->rules->method('get')
            ->withConsecutive([AllowRule::class], [AllowRule::class], [ForbidRule::class])
            ->willReturn($allowRule, $allowRule, $forbidRule);
        $this->patternizer->method('matches')->willReturn(true);

        $manager = new PermissionManager($this->rules, $this->patternizer);
        $manager->addRole(static::ROLE);

        // test simple permission
        $this->assertEquals($manager,
            $manager->associate(static::ROLE, static::PERMISSION, AllowRule::class));
        $this->assertEquals($allowRule, $manager->getRule(static::ROLE, static::PERMISSION));

        // test pattern permission
        $this->assertEquals($manager,
            $manager->associate(static::ROLE, static::PERMISSION . '*', AllowRule::class));
        $this->assertEquals($allowRule,
            $manager->getRule(static::ROLE, static::PERMISSION . '.' . static::PERMISSION));

        $this->assertEquals($manager, $manager->deassociate(static::ROLE, static::PERMISSION));
        $this->assertEquals($forbidRule, $manager->getRule(static::ROLE, static::PERMISSION));
    }

    public function testGetRuleRoleException()
    {
        $manager = new PermissionManager($this->rules, $this->patternizer);

        $this->expectException(RoleException::class);
        $manager->getRule(static::ROLE, static::PERMISSION);
    }

    public function testGetRulePermissionException()
    {
        $manager = new PermissionManager($this->rules, $this->patternizer);
        $manager->addRole(static::ROLE);

        $this->expectException(PermissionException::class);
        $manager->getRule(static::ROLE, static::PERMISSION);
    }

    public function testAssociateRoleException()
    {
        $manager = new PermissionManager($this->rules, $this->patternizer);

        $this->expectException(RoleException::class);
        $manager->associate(static::ROLE, static::PERMISSION);
    }

    public function testAssociatePermissionException()
    {
        $this->rules->method('get')->willReturn(false);

        $manager = new PermissionManager($this->rules, $this->patternizer);

        $manager->addRole(static::ROLE);
        $this->expectException(PermissionException::class);
        $manager->associate(static::ROLE, static::PERMISSION);
    }
}