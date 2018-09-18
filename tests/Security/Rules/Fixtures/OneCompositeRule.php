<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Tests\Rules\Fixtures;

use Spiral\Security\Rule\CompositeRule;

/**
 * Class OneCompositeRule
 *
 * @package Spiral\Security\Tests\Actors
 */
class OneCompositeRule extends CompositeRule
{
    const RULES = ['test.create', 'test.update', 'test.delete'];
    const BEHAVIOUR = self::AT_LEAST_ONE;
}