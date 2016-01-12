<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Entities;

use Spiral\Core\Component;
use Spiral\Guard\AssociationsInterface;
use Spiral\Guard\Exceptions\PermissionException;
use Spiral\Guard\Exceptions\RoleException;

/**
 * Default implementation of associations repository and manager. Provides ability to set
 * permissions in bulk using * syntax.
 *
 * Example:
 * $associations->associate('admin', '*');
 * $associations->associate('editor', 'posts.*');
 */
class AssociationManager extends Component implements AssociationsInterface
{
    /**
     * Roles associated with their permissions.
     *
     * @var array
     */
    private $associations = [];

    /**
     * @param array $associations
     */
    public function __construct(array $associations = [])
    {
        $this->mountAssociations($associations);
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
    public function hasAssociation($role, $permission)
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'.");
        }

        if (!is_string($permission)) {
            throw new RoleException("Invalid permission type, strings only.");
        }

        if (!preg_match('/^[a-z0-9_\-\.]$/i', $permission)) {
            throw new PermissionException("Invalid permission format of '{$permission}'.");
        }

        if (isset($this->associations[$role][$permission])) {
            return true;
        }

        //Checking using star syntax
        foreach ($this->associations[$role] as $pattern) {
            if (strpos($pattern, '*') !== false) {
                if (preg_match($this->getRegex($pattern), $permission)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function associate($role, $permission)
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'.");
        }

        if (!is_string($permission)) {
            throw new RoleException("Invalid permission type, strings only.");
        }

        if (!preg_match('#^[a-z0-9_\-\.\*]$#i', $permission)) {
            throw new PermissionException("Invalid permission format of '{$permission}'.");
        }

        foreach ((array)$permission as $item) {
            $this->associations[$role][$item] = true;
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
                throw new PermissionException("Undefined permission {$permission}.");
            }

            unset($this->associations[$role][$item]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAssociations()
    {
        $result = [];
        foreach ($this->associations as $role => $permissions) {
            $result[$role] = array_keys($permissions);
        }

        return $result;
    }

    /**
     * @param array $an_array
     * @return self
     */
    static function __set_state($an_array)
    {
        $associations = new self();
        $associations->associations = $an_array['associations'];

        return $associations;
    }

    /**
     * Mounts associations using user friendly format.
     *
     * @param array $associations
     */
    private function mountAssociations(array $associations)
    {
        foreach ($associations as $role => $permissions) {
            $this->associations[$role] = array_fill_keys($permissions, true);
        }
    }

    /**
     * @param string $pattern
     * @return string
     */
    private function getRegex($pattern)
    {
        $regex = str_replace('*', '[a-z0-9_\-]+', addcslashes($pattern, '.-'));

        return "#^{$regex}$#i";
    }
}