<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Entities;

use Spiral\Core\Component;
use Spiral\Guard\Exceptions\PermissionException;
use Spiral\Guard\Exceptions\RoleException;
use Spiral\Guard\GuardInterface;
use Spiral\Guard\RolesInterface;

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
class RoleManager extends Component implements RolesInterface
{
    /**
     * Roles associated with their permissions.
     *
     * @var array
     */
    private $associations = [];

    /**
     * @var StarPatterns
     */
    private $starPatterns = null;

    /**
     * @param StarPatterns|null $starPatterns
     */
    public function __construct(StarPatterns $starPatterns = null)
    {
        if (empty($starPatterns)) {
            $starPatterns = new StarPatterns();
        }

        $this->starPatterns = $starPatterns;
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
    public function getBehaviour($role, $permission)
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'.");
        }

        if (!is_string($permission)) {
            throw new RoleException("Invalid permission type, strings only.");
        }

        if (isset($this->associations[$role][$permission])) {
            //O(1) check
            return $this->associations[$role][$permission];
        }

        //Checking using star syntax
        foreach ($this->associations[$role] as $pattern => $behaviour) {
            if ($this->starPatterns->matches($permission, $pattern)) {
                return $behaviour;
            }
        }

        return GuardInterface::UNDEFINED;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function associate($role, $permission, $behaviour = GuardInterface::ALWAYS_ALLOW)
    {
        if (!$this->hasRole($role)) {
            throw new RoleException("Undefined role '{$role}'.");
        }

        if (!in_array($behaviour, [
            GuardInterface::ALWAYS_ALLOW,
            GuardInterface::ALWAYS_FORBID,
            GuardInterface::FOLLOW_RULES
        ])
        ) {
            throw new PermissionException("Invalid behaviour value");
        }

        foreach ((array)$permission as $item) {
            $this->associations[$role][$item] = $behaviour;
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
     * @param array $an_array
     * @return RoleManager
     */
    static function __set_state($an_array)
    {
        $associations = new self();
        $associations->associations = $an_array['associations'];

        return $associations;
    }
}