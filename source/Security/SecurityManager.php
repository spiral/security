<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security;

use Interop\Container\ContainerInterface;
use Spiral\Core\Component;
use Spiral\Core\Container\SingletonInterface;
use Spiral\Core\FactoryInterface;
use Spiral\Security\Configs\SecurityConfig;

/**
 * Security manager responsible only for registering security libraries to be later used for
 * R/P/R mapping.
 */
class SecurityManager extends Component implements SingletonInterface
{
    /**
     * Declarative singleton (by default).
     */
    const SINGLETON = self::class;

    /**
     * @var SecurityConfig
     */
    private $config = null;

    /**
     * Libraries added in runtime.
     *
     * @var LibraryInterface[]
     */
    private $libraries = [];

    /**
     * @param SecurityConfig   $config
     * @param FactoryInterface $factory
     */
    public function __construct(SecurityConfig $config, FactoryInterface $factory)
    {
        $this->config = $config;

        foreach ($this->config->getLibraries() as $library) {
            $this->register($factory->make($library));
        }
    }

    /**
     * Mount security library.
     *
     * @param LibraryInterface $library
     * @return $this
     */
    public function register(LibraryInterface $library)
    {
        $this->libraries[] = $library;

        return $this;
    }

    /**
     * Returns list of every available permissions gathered from libraries.
     *
     * @return array
     */
    public function definedPermissions()
    {
        $result = [];

        foreach ($this->libraries as $library) {
            $result = array_merge($result, $library->definePermissions());
        }

        return $result;
    }

    public function definedRules()
    {
        $result = [];

//        foreach ($this->libraries as $library) {
//            $result = array_merge($result, $library->definePermissions());
//        }

        return $result;
    }
}