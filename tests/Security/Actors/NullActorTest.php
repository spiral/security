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
use Spiral\Security\Actor\NullActor;

class NullActorTest extends TestCase
{
    public function testGetRoles()
    {
        /** @var ActorInterface $actor */
        $actor = new NullActor();

        $this->assertEquals([], $actor->getRoles());
    }
}
