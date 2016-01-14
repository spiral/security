<?php
/**
 * Spiral Framework.
 *
 * @license MIT
 * @author  Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Configs;

use Spiral\Core\InjectableConfig;

/**
 * Guard component configuration.
 */
class GuardConfig extends InjectableConfig
{
    /**
     * Configuration section.
     */
    const CONFIG = 'modules/guard';

    /**
     * @var array
     */
    protected $config = [
        'defaultActor'   => null,
        'cacheLibraries' => true,
        'libraries'      => []
    ];

    /**
     * @return array
     */
    public function defaultActor()
    {
        return $this->config['defaultActor'];
    }

    /**
     * @return bool
     */
    public function cacheLibraries()
    {
        return $this->config['cacheLibraries'];
    }

    /**
     * @return array
     */
    public function getLibraries()
    {
        return $this->config['libraries'];
    }
}