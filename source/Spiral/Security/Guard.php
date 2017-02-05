<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security;

use Spiral\Core\Component;
use Spiral\Security\Exceptions\GuardException;

/**
 * Checks permissions using given actor.
 */
final class Guard extends Component implements GuardInterface
{
    /**
     * @var PermissionsInterface
     */
    private $permissions = null;

    /**
     * @var ActorInterface|null
     */
    private $actor = null;

    /**
     * Session specific roles.
     *
     * @var array
     */
    private $roles = [];

    /**
     * @param PermissionsInterface $permissions
     * @param ActorInterface       $actor
     * @param array                $roles Session specific roles.
     */
    public function __construct(
        PermissionsInterface $permissions,
        ActorInterface $actor = null,
        array $roles = []
    ) {
        $this->roles = $roles;
        $this->actor = $actor;
        $this->permissions = $permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function allows(string $permission, array $context = []): bool
    {
        foreach ($this->getRoles() as $role) {
            if (!$this->permissions->hasRole($role)) {
                continue;
            }

            $rule = $this->permissions->getRule($role, $permission);

            //Checking our rule
            return $rule->allows($this->getActor(), $permission, $context);
        }

        return false;
    }

    /**
     * Currently active actor/session roles.
     *
     * @return array
     *
     * @throws GuardException
     */
    public function getRoles(): array
    {
        return array_merge($this->roles, $this->getActor()->getRoles());
    }

    /**
     * Create instance of guard with session specific roles (existed roles will be droppped).
     *
     * @param array $roles
     *
     * @return self
     */
    public function withRoles(array $roles): Guard
    {
        $guard = clone $this;
        $guard->roles = $roles;

        return $guard;
    }

    /**
     * {@inheritdoc}
     *
     * @throws GuardException
     */
    public function getActor(): ActorInterface
    {
        if (empty($this->actor)) {
            throw new GuardException("Unable to get Guard Actor, no value set");
        }

        return $this->actor;
    }

    /**
     * {@inheritdoc}
     */
    public function withActor(ActorInterface $actor): GuardInterface
    {
        $guard = clone $this;
        $guard->actor = $actor;

        return $guard;
    }
}