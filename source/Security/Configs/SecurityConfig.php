<?php
/**
 * Spiral Framework.
 *
 * @license MIT
 * @author  Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Configs;

use Spiral\Core\InjectableConfig;

/**
 * Security component configuration.
 */
class SecurityConfig extends InjectableConfig
{
    /**
     * Configuration section.
     */
    const CONFIG = 'modules/security';

    /**
     * @var array
     */
    protected $config = [
        'defaultActor' => null,
        'libraries'    => []
    ];

    /**
     * Default actor class.
     *
     * @return array
     */
    public function defaultActor()
    {
        return $this->config['defaultActor'];
    }

    /**
     * @return array
     */
    public function getLibraries()
    {
        return $this->config['libraries'];
    }
}