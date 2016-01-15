<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Entities\Actors;

use Spiral\Security\ActorInterface;

class Guest implements ActorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return ['guest'];
    }
}
