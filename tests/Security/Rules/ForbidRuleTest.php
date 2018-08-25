<?php
/**
 * /**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Spiral\Security\ActorInterface;
use Spiral\Security\RuleInterface;
use Spiral\Security\Rules\ForbidRule;

/**
 * Class ForbidRuleTest
 *
 * @package Spiral\Security\Tests\Rules
 */
class ForbidRuleTest extends TestCase
{
    const OPERATION = 'test';
    const CONTEXT = [];

    public function testAllow()
    {
        /** @var RuleInterface $rule */
        $rule = new ForbidRule();
        /** @var ActorInterface $actor */
        $actor = $this->createMock(ActorInterface::class);

        $this->assertFalse($rule->allows($actor, static::OPERATION, static::CONTEXT));
    }
}