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
use Spiral\Security\RulesInterface;

/**
 * Provides ability to evaluate multiple sub rules using boolean joiner.
 *
 * Example:
 *
 * class AuthorOrModeratorRule extends BooleanRule
 * {
 *      const JOINER = self::BOOLEAN_OR;
 *      protected $rules= [AuthorRule::class, ModeratorRule::class];
 * }
 *
 */
abstract class BooleanRule implements RuleInterface
{
    const BOOLEAN_AND = 'and';
    const BOOLEAN_OR  = 'or';

    /**
     * How to process results on sub rules.
     */
    const JOINER = self::BOOLEAN_AND;

    /**
     * Rules repository.
     *
     * @var RulesInterface
     */
    private $repository = null;

    /**
     * Rule rule names.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * @param RulesInterface $repository
     */
    public function __construct(RulesInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function allows(ActorInterface $actor, $permission, array $context)
    {
        $allowed = 0;
        foreach ($this->rules as $rule) {
            $rule = $this->repository->get($rule);

            if ($rule->allows($actor, $permission, $context)) {
                if (static::JOINER == self::BOOLEAN_OR) {
                    return true;
                }

                $allowed++;
            } elseif (static::JOINER == self::BOOLEAN_AND) {
                return false;
            }
        }

        return $allowed === count($this->rules);
    }
}