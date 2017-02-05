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
 * Context specific operation rule.
 */
interface RuleInterface
{
    /**
     * @param ActorInterface $actor
     * @param string         $permission
     * @param array          $context
     *
     * @return bool
     *
     * @throws RuleException
     */
    public function allows(ActorInterface $actor, string $permission, array $context): bool;
}