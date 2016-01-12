<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Actors;

use Spiral\Guard\ActorInterface;
use Spiral\Guard\Configs\GuardConfig;

class DefaultActor implements ActorInterface
{
    /**
     * @var array
     */
    private $roles = [];

    /**
     * @param GuardConfig $config
     */
    public function __construct(GuardConfig $config)
    {
        $this->roles = $config->defaultRoles();
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
