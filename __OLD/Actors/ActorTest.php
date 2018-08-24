<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Security\Tests\Actors;

use Spiral\Security\ActorInterface;
use Spiral\Security\Actors\Actor;


/**
 * Class ActorTest
 *
 * @package Spiral\Security\Tests\Actors
 */
class ActorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRoles()
    {
        $roles = ['user', 'admin'];

        /** @var ActorInterface $actor */
        $actor = new Actor($roles);

        $this->assertEquals($roles, $actor->getRoles());
    }
}