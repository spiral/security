<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard\Support\Declaration;

use Spiral\Guard\Library;
use Spiral\Reactor\ClassDeclaration;
use Spiral\Reactor\DependedInterface;

class LibraryDeclaration extends ClassDeclaration implements DependedInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            Library::class => null
        ];
    }
}