<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security;

/**
 * Context specific operation rule.
 */
interface RuleInterface
{
    /**
     * @param ActorInterface $actor
     * @param string         $operation
     * @param array          $context
     * @return bool
     */
    public function allows(ActorInterface $actor, $operation, array $context);
}