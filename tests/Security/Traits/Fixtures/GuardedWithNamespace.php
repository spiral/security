<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Tests\Security\Traits\Fixtures;


/**
 * Class GuardedWithNamespace
 *
 * @package Spiral\Tests\Security\Traits\Fixtures
 */
class GuardedWithNamespace extends Guarded
{
    const GUARD_NAMESPACE = 'test';
}