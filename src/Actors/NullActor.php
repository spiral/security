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
 * Actor without any roles.
 */
class NullActor implements ActorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return [];
    }
}