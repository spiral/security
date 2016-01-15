<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Bootloaders;

use Spiral\Core\Bootloaders\Bootloader;
use Spiral\Core\FactoryInterface;
use Spiral\Security\ActorInterface;
use Spiral\Security\Configs\SecurityConfig;
use Spiral\Security\Entities\Guard;
use Spiral\Security\Entities\PermissionManager;
use Spiral\Security\Entities\RuleManager;
use Spiral\Security\GuardInterface;
use Spiral\Security\PermissionsInterface;
use Spiral\Security\RulesInterface;

/**
 * Bootloads guard functionality.
 */
class SecurityBootloader extends Bootloader
{
    /**
     * @var array
     */
    protected $bindings = [
        //Default guard implementation
        GuardInterface::class => Guard::class,

        //Default actor (has to be re-binded in code)
        ActorInterface::class => [self::class, 'defaultActor']
    ];

    /**
     * We are keeping rules and associations global per application environment (in memory), you
     * can always overwrite it manually.
     *
     * @var array
     */
    protected $singletons = [
        PermissionsInterface::class => PermissionManager::class,
        RulesInterface::class       => RuleManager::class
    ];

    /**
     * @param SecurityConfig   $config
     * @param FactoryInterface $factory
     * @return ActorInterface
     */
    public function defaultActor(SecurityConfig $config, FactoryInterface $factory)
    {
        return $factory->make($config->defaultActor());
    }
}