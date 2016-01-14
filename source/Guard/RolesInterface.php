<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

use Spiral\Guard\Exceptions\PermissionException;
use Spiral\Guard\Exceptions\RoleException;

interface RolesInterface
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
     * @see GuardInterface::ALWAYS_ALLOW
     * @see GuardInterface::ALWAYS_FORBID
     * @see GuardInterface::FOLLOW_RULES
     * @param bool   $role
     * @param string $permission
     * @return int
     * @throws RoleException
     * @throws PermissionException
     */
    public function getBehaviour($role, $permission);

    /**
     * Associate (allow) existed role with one or multiple permissions and specific behaviour.
     * Pattern based associations are supported using star syntax.
     *
     * $associations->allow('admin', '*', GuardInterface::ALWAYS_ALLOW);
     * $associations->allow('user', 'posts.*', GuardInterface::FOLLOW_RULES);
     *
     * Attention, role must be added previously!
     *
     * @see GuardInterface::ALWAYS_ALLOW
     * @see GuardInterface::ALWAYS_FORBID
     * @see GuardInterface::FOLLOW_RULES
     * @see addRole()
     * @param string       $role
     * @param string|array $permission
     * @param int          $behaviour
     * @throws RoleException
     * @throws PermissionException
     */
    public function associate($role, $permission, $behaviour = GuardInterface::ALWAYS_ALLOW);

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