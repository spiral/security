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
use Spiral\Guard\Entities\AssociationManager;
use Spiral\Guard\Entities\RuleManager;

/**
 * Guard and associations manager.
 */
class GuardManager extends Component implements SingletonInterface
{
    const SINGLETON = self::class;

    /**
     * Needed for rule manager.
     *
     * @var ContainerInterface
     */
    protected $container = null;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Reload guard manager cache.
     *
     * Attention, only internal manager association and rule classes will be reloaded, you will
     * have to replace container singletons manually!
     *
     * Example:
     * $container->bind(
     *      AssociationsInterface::$class,
     *      $guardManager->reload->associationManager()
     * );
     *
     * @return $this
     */
    public function reload()
    {
        return $this;
    }

    /**
     * @return AssociationManager
     */
    public function associationManager()
    {
        return new AssociationManager([]);
    }

    /**
     * @return RuleManager
     */
    public function ruleManager()
    {
        return new RuleManager($this->container);
    }
}