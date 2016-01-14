<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

interface LibraryInterface
{
    /**
     * @return array
     */
    public function definePermissions();

    /**
     * @return array
     */
    public function defineAssociations();

    /**
     * @return array
     */
    public function defineRules();
}