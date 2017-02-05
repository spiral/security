<?php
/**
 * Spiral, Core Components
 *
 * @author Wolfy-J
 */

namespace Spiral\Security\Rules;

use Spiral\Core\Container\SingletonInterface;
use Spiral\Security\ActorInterface;
use Spiral\Security\RuleInterface;

/**
 * Always positive rule.
 */
final class AllowRule implements RuleInterface, SingletonInterface
{
    /**
     * {@inheritdoc}
     */
    public function allows(ActorInterface $actor, string $permission, array $context): bool
    {
        return true;
    }
}