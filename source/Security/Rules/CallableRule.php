<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Rules;

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
    public function allows(ActorInterface $actor, $permission, array $context)
    {
        return (bool)call_user_func($this->callable, $actor, $permission, $context);
    }
}