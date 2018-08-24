<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Security\Tests\Rules\Fixtures;


use Spiral\Security\Rules\CompositeRule;

/**
 * Class AllCompositeRule
 *
 * @package Spiral\Security\Tests\Rules\Fixtures
 */
class AllCompositeRule extends CompositeRule
{
    const RULES     = ['test.create', 'test.update', 'test.delete'];
    const BEHAVIOUR = self::ALL;
}