<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

use Interop\Container\ContainerInterface;
use Spiral\Core\Component;
use Spiral\Core\Container\SingletonInterface;
use Spiral\Core\FactoryInterface;
use Spiral\Core\HippocampusInterface;
use Spiral\Guard\Configs\GuardConfig;
use Spiral\Guard\Entities\RoleManager;
use Spiral\Guard\Entities\RuleManager;

/**
 * Guard and associations manager.
 */
class GuardManager extends Component implements SingletonInterface
{
    /**
     * Declarative singleton (by default).
     */
    const SINGLETON = self::class;

    /**
     * Memory section.
     */
    const MEMORY = 'guard';

    /**
     * @var GuardConfig
     */
    private $config = null;

    /**
     * @var HippocampusInterface
     */
    protected $memory = null;

    /**
     * @var FactoryInterface
     */
    protected $factory = null;

    /**
     * @param GuardConfig          $config
     * @param HippocampusInterface $memory
     * @param FactoryInterface     $factory
     */
    public function __construct(
        GuardConfig $config,
        HippocampusInterface $memory,
        FactoryInterface $factory
    ) {
        $this->config = $config;
        $this->memory = $memory;
        $this->factory = $factory;

        $this->initLibraries();
    }

    /**
     * Mount guard library (it's permissions, rules and roles). Library information will not be
     * cached.
     *
     * Attention, you will have to drop already initiated Role and Rule manages manually!
     *
     * @see reload()
     * @param LibraryInterface $interface
     * @return $this
     */
    public function register(LibraryInterface $interface)
    {
        return $this;
    }

    /**
     * Reload guard manager cache.
     *
     * Attention, only internal manager association and rule classes will be reloaded, you will
     * have to replace container singletons manually!
     *
     * Example:
     * $container->bind(
     *      RolesInterface::$class,
     *      $guardManager->reload()->roleManager()
     * );
     *
     * Attention #2, libraries mounted to guard manager manually has to be re-added after reload.
     *
     * @return $this
     */
    public function reload()
    {
        $this->initLibraries(true);

        return $this;
    }

    /**
     * Get list of registered permissions in a form of array. Permissions list are library driven
     * and might not include dynamic permissions.
     *
     * @return array
     */
    public function getPermissions()
    {
        //todo: crap
    }

    /**
     * @return ActorInterface
     */
    public function defaultActor()
    {
        return $this->factory->make(
            $this->config->defaultActor()
        );
    }

    /**
     * @todo optimize using schema cache?
     * @return RoleManager
     */
    public function roleManager()
    {
        $roles = $this->factory->make(RoleManager::class);

        //Populating?

        return $roles;
    }

    /**
     * @todo optimize using schema cache?
     * @return RuleManager
     */
    public function ruleManager()
    {
        $rules = $this->factory->make(RuleManager::class);

        //Populating?

        return $rules;
    }

    private function initLibraries($reset = false)
    {

    }
}