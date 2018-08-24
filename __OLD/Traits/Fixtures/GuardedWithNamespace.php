<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Security\Tests\Traits\Fixtures;


/**
 * Class GuardedWithNamespace
 *
 * @package Spiral\Security\Tests\Traits\Fixtures
 */
class GuardedWithNamespace extends Guarded
{
    const GUARD_NAMESPACE = 'test';
}