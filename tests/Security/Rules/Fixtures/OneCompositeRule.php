<?php

declare(strict_types=1);

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
    public const RULES = ['test.create', 'test.update', 'test.delete'];
    public const BEHAVIOUR = self::AT_LEAST_ONE;
}
