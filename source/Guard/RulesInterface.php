<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

/**
 * Rules supplied in a form of class name will be resolved using FactoryInterface.
 *
 * Rule signature must match: RuleInterface!
 */
interface RulesInterface
{
    /**
     * Check if given permission known to rules.
     *
     * @param string $permission
     * @return bool
     */
    public function checksPermission($permission);

    /**
     * Associate rule with a given permission. Rule can be supplied in callable form. Star
     * syntax are supported.
     *
     * Example:
     * $this->addRule('post.*', Rules\PostRule::class);
     * $this->addRule('post.*', function($actor, $permission, $context) {
     *     return $actor instanceof User && $context['post']->author_id == $actor->id;
     * });
     *
     * @param string   $permission
     * @param callable $rule
     */
    public function addRule($permission, callable $rule);

    /**
     * Remove previously associated permission rule.
     *
     * @param string   $permission
     * @param callable $rule
     */
    public function removeRule($permission, callable $rule);

    /**
     * Check permission using set of registered rules.
     *
     * @param ActorInterface $actor
     * @param string         $permission
     * @param array          $context
     * @return bool
     */
    public function check(ActorInterface $actor, $permission, array $context);
}