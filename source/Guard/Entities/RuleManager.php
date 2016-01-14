<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Entities;

use Spiral\Core\Component;
use Spiral\Core\FactoryInterface;
use Spiral\Core\ResolverInterface;
use Spiral\Guard\RulesInterface;

class RuleManager extends Component implements RulesInterface
{
    public function __construct(FactoryInterface $factory, ResolverInterface $resolver)
    {
    }
}