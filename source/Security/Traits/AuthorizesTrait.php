<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security\Traits;

use Spiral\Core\Exceptions\ControllerException;

/**
 * Provides ability to raise authorize errors by controllers.
 */
trait AuthorizesTrait
{
    use GuardedTrait;

    /**
     * Authorize permission or thrown controller exception.
     *
     * @param string $permission
     * @param array  $context
     * @return bool
     * @throws ControllerException
     */
    protected function authorize($permission, array $context = [])
    {
        if (!$this->allows($permission, $context)) {
            $name = $this->resolvePermission($permission);
            throw new ControllerException(
                "Unauthorized permission '{$name}'.",
                ControllerException::FORBIDDEN
            );
        }

        return true;
    }
}