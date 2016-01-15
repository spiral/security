<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Entities;

use Spiral\Core\Component;
use Spiral\Security\ActorInterface;
use Spiral\Security\GuardInterface;
use Spiral\Security\PermissionsInterface;
use Spiral\Security\RuleInterface;

/**
 * Checks permissions using given actor.
 */
class Guard extends Component implements GuardInterface
{
    /**
     * @var ActorInterface
     */
    private $actor = null;

    /**
     * Session specific roles.
     *
     * @var array
     */
    private $roles = [];

    /**
     * @var PermissionsInterface
     */
    private $permissions = null;

    /**
     * @param array                $roles Session specific roles.
     * @param ActorInterface       $actor
     * @param PermissionsInterface $permissions
     */
    public function __construct(
        array $roles = [],
        ActorInterface $actor,
        PermissionsInterface $permissions
    ) {
        $this->roles = $roles;
        $this->actor = $actor;
        $this->permissions = $permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function allows($permission, array $context = [])
    {
        foreach ($this->getRoles() as $role) {
            if (!$this->permissions->hasRole($role)) {
                continue;
            }

            $rule = $this->permissions->getRule($role, $permission);
            if ($rule === self::ALLOW) {
                return true;
            }

            if ($rule instanceof RuleInterface) {
                if ($rule->allows($this->actor, $permission, $context)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Currently active actor/session roles.
     *
     * @return array
     */
    public function getRoles()
    {
        return array_merge($this->roles, $this->actor->getRoles());
    }

    /**
     * Create instance of guard with session specific roles (existed roles will be droppped).
     *
     * @param array $roles
     * @return Guard
     */
    public function withRoles(array $roles)
    {
        $guard = clone $this;
        $guard->roles = $roles;

        return $guard;
    }

    /**
     * {@inheritdoc}
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * {@inheritdoc}
     */
    public function withActor(ActorInterface $actor)
    {
        $guard = clone $this;
        $guard->actor = $actor;

        return $guard;
    }
}