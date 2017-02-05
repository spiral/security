<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Actors;

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
