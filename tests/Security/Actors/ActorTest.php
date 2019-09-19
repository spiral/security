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
use Spiral\Security\Actor\Actor;

class ActorTest extends TestCase
{
    public function testGetRoles()
    {
        $roles = ['user', 'admin'];

        /** @var ActorInterface $actor */
        $actor = new Actor($roles);

        $this->assertEquals($roles, $actor->getRoles());
    }
}
