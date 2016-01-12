<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

interface RulesInterface
{
    /**
     * Check if given permission known to rules.
     *
     * @param string $permission
     * @return bool
     */
    public function knowsPermission($permission);

    /**
     * Check permission using set of registered rules.
     *
     * @param string         $permission
     * @param ActorInterface $actor
     * @param array          $context
     * @return bool
     */
    public function check($permission, ActorInterface $actor, array $context);
}