<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

/**
 * Default (static) library implementation which utilizes default property values as needed data.
 */
class Library implements LibraryInterface
{
    /**
     * @var array
     */
    protected $permissions = [];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $roles = [];

    /**
     * @todo add ability to specify permissions in a form "permission.[sub1,sub2,sub3]"
     * @return array
     */
    public function definePermissions()
    {
        return $this->permissions;
    }

    /**
     * @return array
     */
    public function defineRules()
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function defineRoles()
    {
        return $this->roles;
    }
}