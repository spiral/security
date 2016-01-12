<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Bootloaders;

use Spiral\Core\Bootloaders\Bootloader;
use Spiral\Guard\ActorInterface;
use Spiral\Guard\Actors\DefaultActor;
use Spiral\Guard\AssociationsInterface;
use Spiral\Guard\Entities\Guard;
use Spiral\Guard\GuardInterface;
use Spiral\Guard\GuardManager;
use Spiral\Guard\RulesInterface;

/**
 * Bootloads guard functionality.
 */
class GuardBootloader extends Bootloader
{
    /**
     * @var array
     */
    protected $bindings = [
        //Default actor (has to be re-binded in code)
        ActorInterface::class => DefaultActor::class,

        //Default guard implementation
        GuardInterface::class => Guard::class,
    ];

    /**
     * @var array
     */
    protected $singletons = [
        AssociationsInterface::class => [self::class, 'associationManager'],
        RulesInterface::class        => [self::class, 'ruleManager']
    ];

    /**
     * @param GuardManager $guardManager
     * @return AssociationsInterface
     */
    public function associationManager(GuardManager $guardManager)
    {
        return $guardManager->associationManager();
    }

    /**
     * @param GuardManager $guardManager
     * @return RulesInterface
     */
    public function ruleManager(GuardManager $guardManager)
    {
        return $guardManager->ruleManager();
    }
}