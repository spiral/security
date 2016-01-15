<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security;

use Spiral\Core\ResolverInterface;
use Spiral\Security\Exceptions\RuleException;

/**
 * Rule class provides ability to route check request to a specified method (by default check)
 * using resolver interface. As side effect check method will support method injections.
 *
 * Example:
 *
 * class MyRule extends Rule
 * {
 *      protected $supports = ['post.(save|delete)'];
 *
 *      public function check($actor, $post)
 *      {
 *          return $post->author_id == $actor->id;
 *      }
 * }
 */
abstract class Rule implements RuleInterface
{
    /**
     * Method to be used for checking.
     */
    const CHECK_METHOD = 'check';

    /**
     * Set of aliases to be used for method injection.
     *
     * @var array
     */
    protected $aliases = [
        'user' => 'actor'
    ];

    /**
     * @var ResolverInterface
     */
    protected $resolver = null;

    /**
     * @param ResolverInterface $resolver
     */
    public function __construct(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function allows(ActorInterface $actor, $permission, array $context)
    {
        $parameters = compact('actor', 'operation', 'context') + $context;

        //Mounting aliases
        foreach ($this->aliases as $target => $alias) {
            $parameters[$target] = $parameters[$alias];
        }

        $method = new \ReflectionMethod($this, static::CHECK_METHOD);
        $method->setAccessible(true);

        try {
            return $method->invokeArgs($this,
                $this->resolver->resolveArguments($method, $parameters));
        } catch (\Exception $e) {
            throw new RuleException(
                '[' . get_class($this) . '] ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}