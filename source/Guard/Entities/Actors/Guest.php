<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Entities\Actors;

use Spiral\Guard\ActorInterface;

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
