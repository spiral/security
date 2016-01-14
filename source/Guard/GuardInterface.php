<?php
/**
 * Spiral Framework.
 *
 * @license MIT
 * @author  Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

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
     * Role/permissions association behaviours.
     */
    const UNDEFINED        = 0;
    const ALWAYS_ALLOW     = 1;
    const ALWAYS_FORBID    = 2;
    const FOLLOW_THE_RULES = 3;
    const USE_RULES        = self::FOLLOW_THE_RULES;
    const CONTEXT_SPECIFIC = self::FOLLOW_THE_RULES;

    /**
     * Check if given permission are allowed. Has to check associations between permission and
     * actor roles. If no roles matched guard has to check permission fallback rule(s) if any
     * presented.
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