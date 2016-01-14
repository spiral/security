<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

interface RuleInterface
{
    public function __invoke(ActorInterface $actor, $permission, array $context);
}