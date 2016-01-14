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

interface AssociationsInterface
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
     * Check if given role has association with specified permission (permission allowed for role).
     *
     * @param bool   $role
     * @param string $permission
     * @return bool
     * @throws RoleException
     * @throws PermissionException
     */
    public function hasAssociation($role, $permission);

    /**
     * Associate (allow) existed role with one or multiple permissions. Must support pattern based
     * associations:
     * $associations->associate('admin', '*');
     * $associations->associate('editor', 'posts.*');
     *
     * @todo forbids?
     * @param string       $role
     * @param string|array $permission
     * @throws RoleException
     * @throws PermissionException
     */
    public function associate($role, $permission);

    /**
     * Deassociate (deny) existed role with one or multiple permissions. This is not forbid method,
     * but rather remove association.
     *
     * @param string       $role
     * @param string|array $permission
     * @throws RoleException
     * @throws PermissionException
     */
    public function deassociate($role, $permission);

    /**
     * Return associated array where keys are known roles and value is array of permissions
     * associated with such role.
     *
     * @return array
     */
    public function getAssociations();
}