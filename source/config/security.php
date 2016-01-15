<?php
/**
 * Security component configuration file. Attention, configs might include runtime code which
 * depended on environment values only.
 *
 * @see SecurityConfig
 */
use Spiral\Security;

return [
    /*
     * Default actor instance to used if no other instance were found.
     */
    'defaultActor' => Security\Entities\Actors\Guest::class,

    /*
     * List set of library classes (Spiral\Guard\Library parent) used to describe set of
     * permissions and associated rules.
     */
    'libraries'    => [
        /*{{libraries}}*/
    ]
];