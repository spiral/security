<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Traits;

use Spiral\Core\ContainerInterface;
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
     * @see      guard()
     * @internal instance specific, can be null
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
     */
    public function guard()
    {
        if (empty($this->guard)) {
            $this->guard = $this->container()->get(GuardInterface::class);
        }

        return $this->guard;
    }

    /**
     * @param string $permission
     * @param array  $context
     * @return bool
     */
    protected function allows($permission, array $context = [])
    {
        return $this->guard()->allows(
            $this->resolvePermission($permission),
            $context
        );
    }

    /**
     * @param string $permission
     * @param array  $context
     * @return bool
     */
    protected function denies($permission, array $context = [])
    {
        return !$this->allows($permission, $context);
    }

    /**
     * Automatically prepend permission name with local RBAC namespace.
     *
     * @param string $permission
     * @return string
     */
    private function resolvePermission($permission)
    {
        if (defined('self::GUARD_NAMESPACE')) {
            //Yay! Isolation
            $permission = static::GUARD_NAMESPACE . GuardInterface::NS_SEPARATOR . $permission;
        }

        return $permission;
    }

    /**
     * @return ContainerInterface
     */
    abstract protected function container();
}