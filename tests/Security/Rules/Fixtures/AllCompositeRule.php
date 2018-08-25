<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
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
    const RULES = ['test.create', 'test.update', 'test.delete'];
    const BEHAVIOUR = self::ALL;
}