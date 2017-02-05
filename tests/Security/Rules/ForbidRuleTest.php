<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Tests\Security\Rules;

use Spiral\Security\ActorInterface;
use Spiral\Security\RuleInterface;
use Spiral\Security\Rules\ForbidRule;


/**
 * Class ForbidRuleTest
 *
 * @package Spiral\Tests\Security\Rules
 */
class ForbidRuleTest extends \PHPUnit_Framework_TestCase
{
    const OPERATION = 'test';
    const CONTEXT   = [];

    public function testAllow()
    {
        /** @var RuleInterface $rule */
        $rule = new ForbidRule();
        /** @var ActorInterface $actor */
        $actor = $this->createMock(ActorInterface::class);

        $this->assertFalse($rule->allows($actor, static::OPERATION, static::CONTEXT));
    }
}