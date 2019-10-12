<?php

declare(strict_types=1);

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Security\Tests\Actors;

use PHPUnit\Framework\TestCase;
use Spiral\Security\ActorInterface;
use Spiral\Security\Actor\Guest;

class GuestTest extends TestCase
{
    public function testGetRoles(): void
    {
        /** @var ActorInterface $actor */
        $actor = new Guest();

        $this->assertEquals([Guest::ROLE], $actor->getRoles());
    }
}
