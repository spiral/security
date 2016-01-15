<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security;

use Spiral\Security\Exceptions\RuleException;

/**
 * Provides ability to represent security rules using string names.
 *
 * Example:
 * $rules->set('author-rule', Rules\AuthorRule::class);
 *
 * //Allow user to edit post based on "author-rule"
 * $permissions->associate('user', 'post.edit', 'author-rule');
 */
interface RulesInterface
{
    /**
     * Register new rule class under given name. Rule must either implement RuleInterface or
     * support signature: (ActorInterface $actor, $operation, array $context)
     *
     * Technically you can use this method as you use container bindings.
     *
     * @param string                 $name     Rule name in a string form.
     * @param callable|RuleInterface $rule     Rule, if kept as null rule name must be treated as
     *                                         class name for RuleInterface.
     * @throws RuleInterface
     */
    public function set($name, $rule = null);

    /**
     * Remove created rule.
     *
     * @param string $name
     * @throws RuleException
     */
    public function remove($name);

    /**
     * Check if requested rule exists.
     *
     * @param string $name
     * @return bool
     */
    public function has($name);

    /**
     * Get rule object based on it's name.
     *
     * @param string $name
     * @return RuleInterface
     * @throws RuleException
     */
    public function get($name);
}