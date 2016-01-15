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
    const ROLE = 'guest';

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return [self::ROLE];
    }
}
