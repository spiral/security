<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Tests\Actors;

use PHPUnit\Framework\TestCase;
use Spiral\Security\ActorInterface;
use Spiral\Security\Actors\Guest;


class GuestTest extends TestCase
{
    public function testGetRoles()
    {
        /** @var ActorInterface $actor */
        $actor = new Guest();

        $this->assertEquals([Guest::ROLE], $actor->getRoles());
    }
}