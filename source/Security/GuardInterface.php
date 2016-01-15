<?php
/**
 * Spiral Framework.
 *
 * @license MIT
 * @author  Anton Titov (Wolfy-J)
 */
namespace Spiral\Security;

/**
 * Guard interface is responsible for high level permission management.
 */
interface GuardInterface
{
    /**
     * Namespace separator in permission names. Only used as helper constant.
     */
    const NS_SEPARATOR = '.';

    /**
     * Role/permissions association behaviour (rule).
     */
    const UNDEFINED = false;
    const ALLOW     = true;

    /**
     * Check if given operation are allowed. Has to check associations between operation and
     * actor/session roles based on given rules (binary vs context specific).
     *
     * @param string $permission
     * @param array  $context Permissions specific context.
     * @return mixed
     */
    public function allows($permission, array $context = []);

    /**
     * Get associated actor instance.
     *
     * @return ActorInterface
     */
    public function getActor();

    /**
     * Create an instance or GuardInterface associated with different actor. Method must not
     * alter existed guard which has to be counted as immutable.
     *
     * @param ActorInterface $actor
     * @return self
     */
    public function withActor(ActorInterface $actor);
}