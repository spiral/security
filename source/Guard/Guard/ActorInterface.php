<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral\Guard;

/**
 * ActorInterface used to represent active "player", in most of cases such interface is
 * implemented by User model.
 */
interface ActorInterface
{
    /**
     * Method must return list of roles associated with current operation is a form of array.
     *
     * @return array
     */
    public function getRoles();
}