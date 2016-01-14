<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

interface LibraryInterface
{
    /**
     * Role/permissions association behaviours.
     */
    const UNDEFINED        = GuardInterface::UNDEFINED;
    const ALWAYS_ALLOW     = GuardInterface::ALWAYS_ALLOW;
    const ALWAYS_FORBID    = GuardInterface::ALWAYS_FORBID;
    const FOLLOW_THE_RULES = GuardInterface::FOLLOW_THE_RULES;
    const RULE_BASED       = GuardInterface::FOLLOW_THE_RULES;
    const CONTEXT_SPECIFIC = GuardInterface::FOLLOW_THE_RULES;

    /**
     * @return array
     */
    public function definePermissions();

    /**
     * @return array
     */
    public function defineRoles();

    /**
     * @return array
     */
    public function defineRules();
}