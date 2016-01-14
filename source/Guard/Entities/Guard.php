<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Entities;

use Psr\Log\LoggerAwareInterface;
use Spiral\Core\Component;
use Spiral\Debug\Traits\LoggerTrait;
use Spiral\Guard\ActorInterface;
use Spiral\Guard\Exceptions\GuardException;
use Spiral\Guard\GuardInterface;
use Spiral\Guard\RolesInterface;
use Spiral\Guard\RulesInterface;

/**
 * Checks permissions using given actor.
 */
class Guard extends Component implements GuardInterface, LoggerAwareInterface
{
    use LoggerTrait;

    /**
     * @var ActorInterface
     */
    private $actor = null;

    /**
     * @var RolesInterface
     */
    private $associations = null;

    /**
     * @var RulesInterface
     */
    private $rules = null;

    /**
     * @param ActorInterface $actor
     * @param RolesInterface $associations
     * @param RulesInterface $rules
     */
    public function __construct(
        ActorInterface $actor,
        RolesInterface $associations,
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
            if (!$this->associations->hasRole($role)) {
                continue;
            }

            switch ($this->associations->getBehaviour($role, $permission)) {
                case self::ALWAYS_ALLOW:
                    return true;
                case self::ALWAYS_FORBID:
                    return true;
                case self::FOLLOW_THE_RULES:
                    if ($this->checkRule($permission, $context)) {
                        return true;
                    }
            }
        }

        $this->logger()->warning(
            "Unable to resolve behaviour or rule(s) for permission '{permission}'.",
            compact('permission')
        );

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

    /**
     * @param string $permission
     * @param array  $context
     * @return bool
     */
    private function checkRule($permission, array $context)
    {
        if (!$this->rules->hasRule($permission)) {
            /*
             * We are not allowing users to set FOLLOW_RULES behaviour without associated rule,
             * this is not safe.
             */
            throw new GuardException("Unable to locate rule(s) for '{$permission}' permission.");
        }

        return $this->rules->check($permission, $this->actor, $context);
    }
}