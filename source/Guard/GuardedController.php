<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

use Spiral\Core\Controller;
use Spiral\Core\Exceptions\ControllerException;
use Spiral\Guard\Traits\GuardedTrait;

/**
 * Controller with guarding options and methods.
 *
 * You can locate non guarded actions using ClassLocatorInterface.
 */
class GuardedController extends Controller
{
    use GuardedTrait;

    /**
     * Isolates all controller permissions under given namespace.
     */
    const GUARD_NAMESPACE = '';

    /**
     * List of guarded actions associated with required permission.
     *
     * @var array
     */
    protected $guardedActions = [];

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
            throw new ControllerException(
                "Unauthorized permission {$permission}.",
                ControllerException::FORBIDDEN
            );
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function isExecutable(\ReflectionMethod $method)
    {
        if (!parent::isExecutable($method)) {
            return false;
        }

        $action = $this->actionName($method);

        if (isset($this->guardedActions[$action])) {
            return $this->allows($this->guardedActions[$action]);
        }

        return true;
    }

    /**
     * Normalized controller action name.
     *
     * @param \ReflectionMethod $method
     * @return string
     */
    private function actionName(\ReflectionMethod $method)
    {
        return lcfirst(substr(
            $method->getName(),
            strlen(static::ACTION_PREFIX),
            -1 * strlen(static::ACTION_POSTFIX)
        ));
    }
}