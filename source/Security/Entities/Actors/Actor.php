<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Entities\Actors;

use Spiral\Security\ActorInterface;

/**
 * Simple actor.
 */
class Actor implements ActorInterface
{
    /**
     * @var array
     */
    private $roles = [];

    /**
     * @param array $roles
     */
    public function __construct(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
}