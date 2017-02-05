<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Tests\Security\Rules;

use Spiral\Security\ActorInterface;
use Spiral\Security\RuleInterface;
use Spiral\Security\Rules\CallableRule;


/**
 * Class CallableRuleTest
 *
 * @package Spiral\Tests\Security\Rules
 */
class CallableRuleTest extends \PHPUnit_Framework_TestCase
{
    const OPERATION = 'test';
    const CONTEXT   = [];

    public function testAllow()
    {
        /** @var ActorInterface $actor */
        $actor = $this->createMock(ActorInterface::class);
        $context = [];

        /** @var \PHPUnit_Framework_MockObject_MockObject|callable $callable */
        $callable = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $callable->method('__invoke')
            ->with($actor, static::OPERATION, $context)
            ->willReturn(true, false);

        /** @var RuleInterface $rule */
        $rule = new CallableRule($callable);

        $this->assertTrue($rule->allows($actor, static::OPERATION, $context));
        $this->assertFalse($rule->allows($actor, static::OPERATION, $context));
    }
}