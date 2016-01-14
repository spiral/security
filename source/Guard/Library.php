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
     * Try to avoid supplying role-permissions associations on code level, use Albus or other
     * dynamic guard library to configure associations.
     *
     * @var array
     */
    protected $associations = [];

    /**
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
    public function defineAssociations()
    {
        return $this->associations;
    }
}