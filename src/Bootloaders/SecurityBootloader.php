<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Bootloaders;

use Spiral\Core\Bootloaders\Bootloader;

/**
 * Security bootloader.
 */
class SecurityBootloader extends Bootloader
{
    const SINGLETONS = [
        PermissionsInterface::class => PermissionManager::class,
        RulesInterface::class       => RuleManager::class,
    ];

    const BINDINGS = [
        GuardInterface::class => Guard::class
    ];
}
