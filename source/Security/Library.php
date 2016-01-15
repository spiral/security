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
     * You can define permissions using short syntax like that:
     *
     * protected $permissions = [
     *      'post.[create|update|delete]'
     * ];
     *
     * It will automatically expanded into 3 permissions:
     * post.create
     * post.update
     * post.delete
     *
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
     */
    public function definePermissions()
    {
        $result = [];
        foreach ($this->permissions as $permission) {
            $result = array_merge($result, $this->expand($permission));
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function defineRules()
    {
        return $this->rules;
    }

    /**
     * Expands permission expression into multiple permissions.
     *
     * Example:
     * post.[create|update|delete] => [post.create, post.update, post.delete]
     *
     * @param string $permission
     * @return array
     */
    private function expand($permission)
    {
        if (strpos($permission, GuardInterface::NS_SEPARATOR) !== false) {
            $separator = strpos($permission, GuardInterface::NS_SEPARATOR);

            $head = substr($permission, 0, $separator);
            $tail = substr($permission, $separator + strlen(GuardInterface::NS_SEPARATOR));

            $head = $this->expand($head);
            $tail = $this->expand($tail);

            //Multiplying
            $result = [];

            foreach ($head as $item) {
                foreach ($tail as $subItem) {
                    $result[] = $item . GuardInterface::NS_SEPARATOR . $subItem;
                }
            }

            return $result;
        }

        if (preg_match('#^\[(.+)\]$#', $permission, $matches)) {
            return explode('|', $matches[1]);
        }

        return [$permission];
    }
}