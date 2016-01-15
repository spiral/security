<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security;

use Spiral\Security\Exceptions\PermissionException;
use Spiral\Security\Exceptions\RoleException;

/**
 * Class responsible for Role/Permission/Rule mapping.
 */
interface PermissionsInterface
{
    /**
     * @param bool $role
     * @return bool
     */
    public function hasRole($role);

    /**
     * Register new role.
     *
     * @param string $role
     * @throws RoleException
     */
    public function addRole($role);

    /**
     * Remove existed guard role and every association it has.
     *
     * @param string $role
     * @throws RoleException
     */
    public function removeRole($role);

    /**
     * List of every known role.
     *
     * @return array
     */
    public function getRoles();

    /**
     * Get role/permission behaviour.
     *
     * @see GuardInterface::ALLOW
     * @param bool   $role
     * @param string $permission
     * @return int|RuleInterface
     * @throws RoleException
     * @throws PermissionException
     */
    public function getRule($role, $permission);

    /**
     * Associate (allow) existed role with one or multiple permissions and specific behaviour.
     * Pattern based associations are supported using star syntax.
     *
     * $associations->allow('admin', '*', GuardInterface::ALLOW);
     * $associations->allow('user', 'posts.*', AuthorRule::class);
     *
     * Attention, role must be added previously!
     *
     * You can always create composite rules by creating decorating rule.
     *
     * @see GuardInterface::ALLOW
     * @see addRole()
     * @param string       $role
     * @param string|array $permission
     * @param bool|string  $rule When supplied as string rule must be pointing to RuleInterface
     *                           class.
     * @throws RoleException
     * @throws PermissionException
     */
    public function associate($role, $permission, $rule = GuardInterface::ALLOW);

    /**
     * Deassociate (remove) role with one or multiple permissions. This is not forbid method,
     * but rather remove association.
     *
     * @param string       $role
     * @param string|array $permission
     * @throws RoleException
     * @throws PermissionException
     */
    public function deassociate($role, $permission);
}