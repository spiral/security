<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Entities;

use Spiral\Core\Component;
use Spiral\Security\Exceptions\PermissionException;
use Spiral\Security\Exceptions\RoleException;
use Spiral\Security\GuardInterface;
use Spiral\Security\PermissionsInterface;
use Spiral\Security\RulesInterface;
use Spiral\Security\Support\Patternizer;

/**
 * Default implementation of associations repository and manager. Provides ability to set
 * permissions in bulk using * syntax.
 *
 * Attention, this class is serializable and can be cached in memory.
 *
 * Example:
 * $associations->associate('admin', '*');
 * $associations->associate('editor', 'posts.*');
 */
class PermissionManager extends Component implements PermissionsInterface
{
    /**
     * Roles associated with their permissions.
     *
     * @var array
     */
    private $associations = [];
    
    /**
     * Roles deassociated with their permissions.
     *
     * @var array
     */
    private $deassociations = [];

    /**
     * @var RulesInterface
     */
    private $rules = null;

    /**
     * @var Patternizer
     */
    private $patternizer = null;

    /**
     * @param RulesInterface   $rules
     * @param Patternizer|null $patternizer
     */
    public function __construct(RulesInterface $rules, Patternizer $patternizer = null)
    {
        $this->rules = $rules;
        $this->patternizer = !empty($patternizer) ? $patternizer : new Patternizer();
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        return array_key_exists($role, $this->associations);
    }

    /**
     * {@inheritdoc}
     */
    public function addRole($role)
    {
        if ($this->hasRole($role)) {
            throw new RoleException("Role '{$role}' already exists.");
        }

        $this->associations[$role] = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeRole($role)
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'.");
        }

        unset($this->associations[$role]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return array_keys($this->associations);
    }

    /**
     * {@inheritdoc}
     */
    public function getRule($role, $permission)
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'.");
        }

        if (!is_string($permission)) {
            throw new RoleException("Invalid permission type, strings only.");
        }

        $rule = $this->findRule($role, $permission);
        if ($rule === GuardInterface::ALLOW || $rule === GuardInterface::UNDEFINED) {
            return $rule;
        }

        //Behaviour points to rule
        return $this->rules->get($rule);
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function associate($role, $permission, $rule = GuardInterface::ALLOW)
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'.");
        }

        if ($rule !== GuardInterface::ALLOW) {
            if (!$this->rules->has($rule)) {
                throw new PermissionException("Invalid permission rule '{$rule}'");
            }
        }

        foreach ((array)$permission as $item) {
            $this->associations[$role][$item] = $rule;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function deassociate($role, $permission)
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'.");
        }

        foreach ((array)$permission as $item) {
            if (!isset($this->associations[$role][$item])) {
                $this->deassociations[$role][] = $item;
            } else {
                unset($this->associations[$role][$item]);
            }
        }

        return $this;
    }

    /**
     * @param string $role
     * @param string $permission
     * @return bool|string
     */
    private function findRule($role, $permission)
    {
        if (isset($this->deassociations[$role]) && in_array($permission, $this->deassociations[$role])) {
            return GuardInterface::UNDEFINED;
        }

        if (isset($this->associations[$role][$permission])) {
            //O(1) check
            return $this->associations[$role][$permission];
        } else {
            //Checking using star syntax
            foreach ($this->associations[$role] as $pattern => $behaviour) {
                if ($this->patternizer->matches($permission, $pattern)) {
                    return $behaviour;
                }
            }
        }

        return GuardInterface::UNDEFINED;
    }
}
