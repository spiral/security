<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Rule;

use Spiral\Security\ActorInterface;
use Spiral\Security\RuleInterface;

/**
 * Wraps callable expression.
 */
class CallableRule implements RuleInterface
{
    /**
     * @var callable
     */
    private $callable = null;

    /**
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * {@inheritdoc}
     */
    public function allows(ActorInterface $actor, string $permission, array $context): bool
    {
        return (bool)call_user_func($this->callable, $actor, $permission, $context);
    }
}