<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Entities\Actors;

use Spiral\Guard\ActorInterface;

/**
 * Actor without any roles.
 */
class NullActor implements ActorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return [];
    }
}