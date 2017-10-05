<?php
/**
 * primaERP - Token handling Class.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  (C) 2017 Vitex Software
 */

namespace primaERP;

/**
 * Token handling Class.
 *
 * @url http://devdoc.primaerp.com/rest/authentication.html
 */
class Authentication extends ApiClient
{
    /**
     * Saves obejct instace (singleton...).
     *
     * @var Shared
     */
    private static $_instance = null;

    /**
     * Sekce užitá objektem.
     * Section used by object
     *
     * @var string
     */
    public $section = 'auth';

    /**
     * Token
     *
     * @param mixed $init
     * @param array $options
     */
    public function __construct($init = null, $options = array())
    {
        parent::__construct($init, $options);
    }

}
