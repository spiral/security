<?php

declare(strict_types=1);

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Tests\Traits\Fixtures;

class GuardedWithNamespace extends Guarded
{
    public const GUARD_NAMESPACE = 'test';
}
