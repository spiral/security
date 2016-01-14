<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Entities;

use Interop\Container\ContainerInterface;
use Spiral\Core\Component;
use Spiral\Guard\ActorInterface;
use Spiral\Guard\Exceptions\PermissionException;
use Spiral\Guard\RulesInterface;

class RuleManager extends Component implements RulesInterface
{
    /**
     * @var array
     */
    private $rules = [];

    /**
     * @var StarPatterns
     */
    private $starPatterns = null;

    /**
     * @var ContainerInterface
     */
    protected $container = null;

    /**
     * RuleManager constructor.
     *
     * @param ContainerInterface $container
     * @param StarPatterns|null  $starPatterns
     */
    public function __construct(ContainerInterface $container, StarPatterns $starPatterns = null)
    {
        $this->container = $container;

        if (empty($starPatterns)) {
            $starPatterns = new StarPatterns();
        }

        $this->starPatterns = $starPatterns;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPermission($permission)
    {
        if (isset($this->rules[$permission])) {
            return true;
        }

        foreach ($this->rules as $pattern => $rules) {
            if ($this->starPatterns->matches($permission, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function addRule($permission, callable $rule)
    {
        $this->rules[$permission][] = $rule;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function removeRule($permission, callable $rule)
    {
        if (!$this->hasPermission($permission)) {
            throw new PermissionException("Undefined permission {$permission}.");
        }

        $this->rules[$permission] = array_filter($this->rules[$permission],
            function ($element) use ($rule) {
                return $element != $rule;
            });

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function check($permission, ActorInterface $actor, array $context)
    {
        foreach ($this->getRules($permission) as $rule) {
            if (is_string($rule)) {
                //todo: needs unification (InvokerInterface)
                $rule = $this->container->get($rule);
            }

            if (is_array($rule)) {
                if (is_string($rule[0])) {
                    $rule[0] = $this->container->get($rule[0]);
                }
            }

            if (call_user_func($rule, $permission, $actor, $context) == true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get every associated permission rule. Generator.
     *
     * @param string $permission
     * @return array
     */
    private function getRules($permission)
    {
        if (!$this->hasPermission($permission)) {
            throw new PermissionException("Undefined permission {$permission}.");
        }

        foreach ($this->rules as $pattern => $rules) {
            if ($pattern == $permission || $this->starPatterns->matches($permission, $pattern)) {
                foreach ($rules as $rule) {
                    yield $rule;
                }
            }
        }
    }
}