<?php
/**
 * Guard component configuration file. Attention, configs might include runtime code which
 * depended on environment values only.
 *
 * @see GuardConfig
 */

return [
    //Roles to be associated with default actor
    'defaultActor' => ['guest'],
    /*
     * TODO: Write some useful comment.
     */
    'libraries'    => [
        /*{{libraries}}*/
    ],
    /*
     * Default set of rules to be applied for given permissions or permission patterns. You can
     * always add or remove rules in runtime using RulesInterface.
     *
     * Example:
     * 'post.*' => Rules\PostRule::class //Applied for every post related permission
     */
    'rules'        => [
        /*{{rules}}*/
    ]
];