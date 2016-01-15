<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Support\Declaration;

use Spiral\Security\Rule;
use Spiral\Reactor\ClassDeclaration;
use Spiral\Reactor\DependedInterface;

/**
 * Declares rule.
 */
class RuleDeclaration extends ClassDeclaration implements DependedInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            Rule::class => null
        ];
    }
}