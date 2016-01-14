<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Entities;

use Spiral\Core\Component;
use Spiral\Debug\Traits\LoggerTrait;
use Spiral\Guard\ActorInterface;
use Spiral\Guard\AssociationsInterface;
use Spiral\Guard\GuardInterface;
use Spiral\Guard\RulesInterface;

/**
 * Checks permissions using given actor.
 */
class Guard extends Component implements GuardInterface
{
    use LoggerTrait;

    /**
     * @var ActorInterface
     */
    private $actor = null;

    /**
     * @var AssociationsInterface
     */
    private $associations = null;

    /**
     * @var RulesInterface
     */
    private $rules = null;

    /**
     * @param ActorInterface        $actor
     * @param AssociationsInterface $associations
     * @param RulesInterface        $rules
     */
    public function __construct(
        ActorInterface $actor,
        AssociationsInterface $associations,
        RulesInterface $rules
    ) {
        $this->actor = $actor;
        $this->associations = $associations;
        $this->rules = $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function allows($permission, array $context = [])
    {
        foreach ($this->actor->getRoles() as $role) {
            if ($this->associations->hasAssociation($role, $permission)) {
                return true;
            }
        }

        if ($this->rules->checksPermission($permission)) {
            return $this->rules->check($this->actor, $permission, $context);
        }

        $this->logger()->warning("Undefined permissions {permission}.", compact('permission'));

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * {@inheritdoc}
     */
    public function withActor(ActorInterface $actor)
    {
        $guard = clone $this;
        $guard->actor = $actor;

        return $guard;
    }
}