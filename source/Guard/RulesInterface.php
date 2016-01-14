<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

use Spiral\Guard\Exceptions\PermissionException;

/**
 * Rules supplied in a form of class name will be resolved using ContainerInterface.
 *
 * Rule signature must match: RuleInterface (permission, actor, context!);
 */
interface RulesInterface
{
    /**
     * Check if given permission known to rules.
     *
     * @param string $permission
     * @return bool
     */
    public function hasRule($permission);

    /**
     * Associate rule with a given permission. Rule can be supplied in callable form. Star
     * syntax are supported.
     *
     * Example:
     * $this->setRule('post.*', Rules\PostRule::class);
     * $this->setRule('post.*', function($permission, $actor, $context) {
     *     return $actor instanceof User && $context['post']->author_id == $actor->id;
     * });
     *
     * Example:
     * new CompoundRule(CompoundRule::ALL_TRUE, [Rule1::class, Rule2::class, ...]);
     *
     * @param string   $permission
     * @param callable $rule
     * @throws PermissionException
     */
    public function setRule($permission, $rule);

    /**
     * Remove previously associated permission rule.
     *
     * @param string $permission
     * @throws PermissionException
     */
    public function removeRole($permission);

    /**
     * Check permission using set of registered rules.
     *
     * @param string         $permission
     * @param ActorInterface $actor
     * @param array          $context
     * @return bool
     * @throws PermissionException
     * @throws RuleInterface
     */
    public function check($permission, ActorInterface $actor, array $context);
}