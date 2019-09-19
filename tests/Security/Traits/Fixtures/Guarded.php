<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Tests\Traits\Fixtures;

use Spiral\Security\Traits\GuardedTrait;

class Guarded
{
    use GuardedTrait {
        allows as public;
        denies as public;
        resolvePermission as public;
    }
}
