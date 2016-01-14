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
use Spiral\Guard\Entities\Guard;
use Spiral\Guard\GuardInterface;
use Spiral\Guard\GuardManager;
use Spiral\Guard\RolesInterface;
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
        //Default guard implementation
        GuardInterface::class => Guard::class,

        //Default actor (has to be re-binded in code)
        ActorInterface::class => [GuardManager::class, 'defaultActor']
    ];

    /**
     * We are keeping rules and associations global per application environment (in memory), you
     * can always overwrite it manually.
     *
     * @var array
     */
    protected $singletons = [
        RolesInterface::class => [GuardManager::class, 'roleManager'],
        RulesInterface::class => [GuardManager::class, 'ruleManager']
    ];
}