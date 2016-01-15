<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security;

/**
 * Default (static) library implementation which utilizes default property values as needed data.
 *
 * Libraries are generally used to register set of available permissions and rules. R/P/R mapping
 * must be performed separately.
 */
class Library implements LibraryInterface
{
    /**
     * @var array
     */
    protected $permissions = [];

    /**
     * Definition must be performed in a form of permission/pattern => [rules]
     *
     * Example:
     *
     * protected $rules = [
     *      'post.(save|delete)' => [AuthorRule::class]
     * ];
     *
     * @var array
     */
    protected $rules = [];

    /**
     * {@inheritdoc}
     *
     * @todo support simplified definition syntax ("post.[create,update,delete]")
     */
    public function definePermissions()
    {
        return $this->permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function defineRules()
    {
        return $this->rules;
    }
}