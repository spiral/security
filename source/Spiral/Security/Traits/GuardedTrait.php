<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Traits;

use Interop\Container\ContainerInterface;
use Spiral\Core\Exceptions\ScopeException;
use Spiral\Security\GuardInterface;

/**
 * Embeds GuardInterface functionality into class and provides ability to isolate permissions
 * using guard namespace.
 */
trait GuardedTrait
{
    /**
     * Instance specific guard instance.
     *
     * @see getGuard()
     * @var GuardInterface|null
     */
    private $guard = null;

    /**
     * Set instance specific guard.
     *
     * @param GuardInterface $guard
     */
    public function setGuard(GuardInterface $guard)
    {
        $this->guard = $guard;
    }

    /**
     * @return GuardInterface
     *
     * @throws ScopeException
     */
    public function getGuard(): GuardInterface
    {
        if (empty($this->guard)) {

            $container = $this->iocContainer();

            if (empty($container)) {
                throw new ScopeException("Unable to create guard, no container is available");
            }

            $this->guard = $container->get(GuardInterface::class);
        }

        return $this->guard;
    }

    /**
     * @param string $permission
     * @param array  $context
     *
     * @return bool
     */
    protected function allows(string $permission, array $context = []): bool
    {
        return $this->getGuard()->allows($this->resolvePermission($permission), $context);
    }

    /**
     * @param string $permission
     * @param array  $context
     *
     * @return bool
     */
    protected function denies(string $permission, array $context = []): bool
    {
        return !$this->allows($permission, $context);
    }

    /**
     * Automatically prepend permission name with local RBAC namespace.
     *
     * @param string $permission
     *
     * @return string
     */
    protected function resolvePermission(string $permission): string
    {
        if (defined('static::GUARD_NAMESPACE')) {
            //Yay! Isolation
            $permission = constant(get_called_class() . '::' . 'GUARD_NAMESPACE') . '.' . $permission;
        }

        return $permission;
    }

    /**
     * @return ContainerInterface|null
     */
    abstract protected function iocContainer();
}