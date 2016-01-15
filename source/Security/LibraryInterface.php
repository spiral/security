<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Security;

interface LibraryInterface
{
    /**
     * Role/permissions association behaviour (rule).
     */
    const ALLOW = GuardInterface::ALLOW;

    /**
     * List of defined library specific permission.
     *
     * @return array
     */
    public function definePermissions();

    /**
     * List of declared rule classes.
     *
     * @return array
     */
    public function defineRules();
}