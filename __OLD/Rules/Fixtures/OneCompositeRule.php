<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Security\Tests\Rules\Fixtures;


use Spiral\Security\Rules\CompositeRule;

/**
 * Class OneCompositeRule
 *
 * @package Spiral\Security\Tests\Actors
 */
class OneCompositeRule extends CompositeRule
{
    const RULES     = ['test.create', 'test.update', 'test.delete'];
    const BEHAVIOUR = self::AT_LEAST_ONE;
}