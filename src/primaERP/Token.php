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
class Token extends Authentication
{
    /**
     * Saves obejct instace (singleton...).
     *
     * @var Shared
     */
    private static $_instance = null;

    /**
     * Token
     *
     * @param mixed $init
     * @param array $options
     */
    public function __construct($init = null, $options = array())
    {
        parent::__construct($init, $options);
        $this->refreshToken();
    }

    public function authentication()
    {
        $this->defaultUrlParams['apikey'] = $this->apikey;
    }

    /**
     * Current Token String
     *
     * @return string
     */
    public function getTokenString()
    {
        if ($this->isTokenExpired()) {
            $this->refreshToken();
        }
        return $this->getDataValue('token');
    }


    
    public function takeData($data)
    {
        if (isset($data['expiration']) && preg_match('/([0-9]+)/',
                $data['expiration'], $expire)) {
            $data['expiration'] = intval($expire[1]);
        }
        return parent::takeData($data);
    }

    /**
     * Check Access Token expiration state
     *
     * @return boolean
     */
    public function isTokenExpired()
    {
        $expireTime = $this->getDataValue('expiration') - time();
        return $expireTime < 5;
    }

    public function requestFreshToken()
    {
        return $this->requestData('login', 'GET');
    }

    public function refreshToken()
    {
        $this->takeData($this->requestFreshToken());
    }

    /**
     * Pri vytvareni objektu pomoci funkce singleton (ma stejne parametry, jako konstruktor)
     * se bude v ramci behu programu pouzivat pouze jedna jeho Instance (ta prvni).
     *
     * @param string $class název třídy jenž má být zinstancována
     *
     * @link   http://docs.php.net/en/language.oop5.patterns.html Dokumentace a priklad
     *
     * @return \Ease\Shared
     */
    public static function singleton()
    {
        if (!isset(self::$_instance)) {
            $class           = __CLASS__;
            self::$_instance = new $class();
        }

        return self::$_instance;
    }

    /**
     * Vrací se.
     *
     * @return Shared
     */
    public static function &instanced()
    {
        $tokener = self::singleton();

        return $tokener;
    }
}
