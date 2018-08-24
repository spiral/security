<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Security\Tests\Actors;

use Spiral\Security\ActorInterface;
use Spiral\Security\Actors\Guest;


/**
 * Class GuestTest
 *
 * @package Spiral\Security\Tests\Actors
 */
class GuestTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRoles()
    {
        /** @var ActorInterface $actor */
        $actor = new Guest();

        $this->assertEquals([Guest::ROLE], $actor->getRoles());
    }
}