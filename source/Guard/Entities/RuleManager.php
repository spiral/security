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

/**
 * Provides ability to associate custom business rule with a given permission or pattern.
 */
class RuleManager extends Component implements RulesInterface
{
    /**
     * @var array
     */
    private $rules = [];

    /**
     * @var Patternizer
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
     * @param Patternizer|null   $starPatterns
     */
    public function __construct(ContainerInterface $container, Patternizer $starPatterns = null)
    {
        $this->container = $container;

        if (empty($starPatterns)) {
            $starPatterns = new Patternizer();
        }

        $this->starPatterns = $starPatterns;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRule($permission)
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
    public function setRule($permission, $rule)
    {
        $this->rules[$permission] = $rule;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function removeRole($permission)
    {
        if (!$this->hasRule($permission)) {
            throw new PermissionException("Undefined permission {$permission}.");
        }

        unset($this->rules[$permission]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function check($permission, ActorInterface $actor, array $context)
    {
        $rule = $this->getRule($permission);

        //todo: needs unification (InvokerInterface)
        if (is_string($rule)) {
            $rule = $this->container->get($rule);
        }

        if (is_array($rule)) {
            if (is_string($rule[0])) {
                $rule[0] = $this->container->get($rule[0]);
            }
        }

        return call_user_func($rule, $permission, $actor, $context) == true;
    }

    /**
     * Get every associated permission rule. Generator.
     *
     * @param string $permission
     * @return callable
     * @throws PermissionException
     */
    private function getRule($permission)
    {
        foreach ($this->rules as $pattern => $rule) {
            if ($pattern == $permission || $this->starPatterns->matches($permission, $pattern)) {
                return $rule;
            }
        }

        throw new PermissionException("Undefined permission {$permission}.");
    }
}