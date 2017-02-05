<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security;

use Spiral\Core\Component;
use Spiral\Core\Container\SingletonInterface;
use Spiral\Security\Exceptions\PermissionException;
use Spiral\Security\Exceptions\RoleException;
use Spiral\Security\Rules\ForbidRule;
use Spiral\Support\Patternizer;

/**
 * Default implementation of associations repository and manager. Provides ability to set
 * permissions in bulk using * syntax.
 *
 * Attention, this class is serializable and can be cached in memory.
 *
 * Example:
 * $associations->associate('admin', '*');
 * $associations->associate('editor', 'posts.*', Allows::class);
 * $associations->associate('user', 'posts.*', Forbid::class);
 */
class PermissionManager extends Component implements PermissionsInterface, SingletonInterface
{
    /**
     * Roles associated with their permissions.
     *
     * @var array
     */
    private $permissions = [];

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
    public function __construct(RulesInterface $rules, Patternizer $patternizer)
    {
        $this->rules = $rules;
        $this->patternizer = $patternizer;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole(string $role): bool
    {
        return array_key_exists($role, $this->permissions);
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function addRole(string $role): PermissionManager
    {
        if ($this->hasRole($role)) {
            throw new RoleException("Role '{$role}' already exists");
        }

        $this->permissions[$role] = [
            //No associated permissions
        ];

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function removeRole(string $role): PermissionManager
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'");
        }

        unset($this->permissions[$role]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return array_keys($this->permissions);
    }

    /**
     * {@inheritdoc}
     */
    public function getRule(string $role, string $permission): RuleInterface
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'");
        }

        //Behaviour points to rule
        return $this->rules->get(
            $this->findRule($role, $permission)
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return $this|self
     */
    public function associate(
        string $role,
        string $permission,
        string $rule = 'Spiral\Security\Rules\AllowRule'
    ): PermissionManager {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'");
        }

        if (!$this->rules->has($rule)) {
            throw new PermissionException("Undefined rule '{$rule}'");
        }

        $this->permissions[$role][$permission] = $rule;

        return $this;
    }

    /**
     * Associate role/permission with Forbid rule.
     *
     * @param string $role
     * @param string $permission
     *
     * @return $this|self
     *
     * @throws RoleException
     * @throws PermissionException
     */
    public function deassociate(string $role, string $permission): PermissionManager
    {
        return $this->associate($role, $permission, ForbidRule::class);
    }

    /**
     * @param string $role
     * @param string $permission
     *
     * @return string
     *
     * @throws PermissionException
     */
    private function findRule(string $role, string $permission): string
    {
        if (isset($this->permissions[$role][$permission])) {
            //O(1) check
            return $this->permissions[$role][$permission];
        }

        //Matching using star syntax
        foreach ($this->permissions[$role] as $pattern => $rule) {
            if ($this->patternizer->matches($permission, $pattern)) {
                return $rule;
            }
        }

        throw new PermissionException(
            "Unable to resolve role/permission association for '{$role}'/'{$permission}'"
        );
    }
}