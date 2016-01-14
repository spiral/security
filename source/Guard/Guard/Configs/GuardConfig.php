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
        'defaultRoles' => []
    ];

    /**
     * @return array
     */
    public function defaultRoles()
    {
        return $this->config['defaultRoles'];
    }
}