<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

/**
 * Invocable rule.
 */
interface RuleInterface
{
    /**
     * @param string         $permission
     * @param ActorInterface $actor
     * @param array          $context
     * @return bool
     */
    public function __invoke($permission, ActorInterface $actor, array $context);
}