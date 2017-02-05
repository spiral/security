<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Tests\Security\Actors;

use Spiral\Security\ActorInterface;
use Spiral\Security\Actors\NullActor;


/**
 * Class NullActorTest
 *
 * @package Spiral\Tests\Security\Actors
 */
class NullActorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRoles()
    {
        /** @var ActorInterface $actor */
        $actor = new NullActor();

        $this->assertEquals([], $actor->getRoles());
    }
}