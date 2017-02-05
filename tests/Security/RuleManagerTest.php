<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Tests\Security;


use Interop\Container\ContainerInterface;
use Spiral\Security\Exceptions\RuleException;
use Spiral\Security\RuleInterface;
use Spiral\Security\RuleManager;
use Spiral\Security\Rules\CallableRule;

/**
 * Class RuleManagerTest
 *
 * @package Spiral\Tests\Security
 */
class RuleManagerTest extends \PHPUnit_Framework_TestCase
{
    const RULE_NAME = 'test';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface
     */
    private $container;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RuleInterface
     */
    private $rule;

    public function setUp()
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->rule = $this->createMock(RuleInterface::class);
    }

    public function testFlow()
    {
        $ruleClass = get_class($this->rule);

        $this->container->expects($this->once())->method('get')
            ->with($ruleClass)->willReturn($this->rule);

        $manager = new RuleManager($this->container);

        $this->assertEquals($manager, $manager->set(self::RULE_NAME, $ruleClass));
        $this->assertTrue($manager->has(self::RULE_NAME));
        $this->assertEquals($this->rule, $manager->get(self::RULE_NAME));
        $this->assertEquals($manager, $manager->remove(self::RULE_NAME));

        // other rule types
        $manager->set('RuleInterface', $this->rule);
        $this->assertEquals($this->rule, $manager->get('RuleInterface'));
        $manager->set('Closure', function () {
            return true;
        });
        $this->assertTrue($manager->get('Closure') instanceof CallableRule);
        $manager->set('Array', [$this, 'testFlow']);
        $this->assertTrue($manager->get('Array') instanceof CallableRule);
    }

    public function testHasWithNotRegisteredClass()
    {
        $ruleClass = get_class($this->rule);
        $manager = new RuleManager($this->container);

        $this->assertTrue($manager->has($ruleClass));
    }

    public function testSetRuleException()
    {
        $manager = new RuleManager($this->container);

        $this->expectException(RuleException::class);
        $manager->set(self::RULE_NAME);
    }

    public function testRemoveException()
    {
        $this->container->method('has')->with(self::RULE_NAME)->willReturn(false);

        $manager = new RuleManager($this->container);

        $this->expectException(RuleException::class);
        $manager->remove(self::RULE_NAME);
    }

    public function testGetWithUndefinedRule()
    {
        $this->container->method('has')->with(self::RULE_NAME)->willReturn(false);

        $manager = new RuleManager($this->container);

        $this->expectException(RuleException::class);
        $manager->get(static::RULE_NAME);
    }

    public function testGetWithSomethingOtherThanRule()
    {
        $ruleClass = \stdClass::class;
        $this->container->method('has')->with(self::RULE_NAME)->willReturn(true);

        $manager = new RuleManager($this->container);

        $this->expectException(RuleException::class);
        $manager->get($ruleClass);
    }
}