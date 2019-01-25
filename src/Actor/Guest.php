<?php
declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Actor;

use Spiral\Security\ActorInterface;

/**
 * Actor with defined actor.
 */
class Guest implements ActorInterface
{
    const ROLE = 'guest';

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return [static::ROLE];
    }
}
