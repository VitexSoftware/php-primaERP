<?php
/**
 * primaERP - Basic primaERP rest client class.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  (C) 2017 Spoje.Net
 */

namespace primaERP;

/**
 * Basic class
 *
 * @url http://devdoc.primaerp.com/
 */
class ApiClient extends \Ease\Brick
{
    /**
     * Version of IPEXB2B library
     *
     * @var string
     */
    public static $libVersion = '0.1';

    /**
     * Communication protocol version used.
     *
     * @var string API version
     */
    public $protoVersion = 'v1';

    /**
     * URL of object data in primaERP API
     * @var string url
     */
    public $apiURL = null;

    /**
     * Datový blok v poli odpovědi.
     * Data block in response field.
     *
     * @var string
     */
    public $resultField = 'results';

    /**
     * Section used by object
     *
     * @link http://devdoc.primaerp.com/rest/index.html
     * @var string
     */
    public $section = null;

    /**
     * Curl Handle.
     *
     * @var resource
     */
    public $curl = null;

    /**
     * tenant
     *
     * @link http://devdoc.primaerp.com/rest/authentication.html Identifikátor firmy
     * @var string
     */
    public $company = null;

    /**
     * Server[:port]
     * @var string
     */
    public $url = null;

    /**
     * REST API Username (usually user's email)
     * @var string
     */
    public $user = null;

    /**
     * REST API Password
     * @var string
     */
    public $password = null;

    /**
     * REST API Key
     * @var string
     */
    public $apikey = null;

    /**
     * @var array Pole HTTP hlaviček odesílaných s každým požadavkem
     */
    public $defaultHttpHeaders = ['User-Agent' => 'php-primaERP'];

    /**
     * Default additional request url parameters after question mark
     *
     * @link https://www.ipex.eu/api/dokumentace/ref/urls   Common params
     * @link https://www.ipex.eu/api/dokumentace/ref/paging Paging params
     * @var array
     */
    public $defaultUrlParams = ['limit' => 0];

    /**
     * Identifikační řetězec.
     *
     * @var string
     */
    public $init = null;

    /**
     * Sloupeček s názvem.
     *
     * @var string
     */
    public $nameColumn = 'nazev';

    /**
     * Sloupeček obsahující datum vložení záznamu do shopu.
     *
     * @var string
     */
    public $myCreateColumn = 'false';

    /**
     * Slopecek obsahujici datum poslení modifikace záznamu do shopu.
     *
     * @var string
     */
    public $myLastModifiedColumn = 'lastUpdate';

    /**
     * Klíčový idendifikátor záznamu.
     *
     * @var string
     */
    public $fbKeyColumn = 'id';

    /**
     * Informace o posledním HTTP requestu.
     *
     * @var *
     */
    public $curlInfo;

    /**
     * Informace o poslední HTTP chybě.
     *
     * @var string
     */
    public $lastCurlError = null;

    /**
     * Used codes storage.
     *
     * @var array
     */
    public $codes = null;

    /**
     * Last Inserted ID.
     *
     * @var int
     */
    public $lastInsertedID = null;

    /**
     * Raw Content of last curl response
     *
     * @var string
     */
    public $lastCurlResponse;

    /**
     * HTTP Response code of last request
     *
     * @var int
     */
    public $lastResponseCode = null;

    /**
     * Body data  for next curl POST operation
     *
     * @var string
     */
    protected $postFields = null;

    /**
     * Last operation result data or message(s)
     *
     * @var array
     */
    public $lastResult = null;

    /**
     * Nuber from  @rowCount
     * @var int
     */
    public $rowCount = null;

    /**
     * Parmetry pro URL
     * @link https://www.ipex.eu/api/dokumentace/ref/urls/ Všechny podporované parametry
     * @var array
     */
    public $urlParams = [
    ];

    /**
     * Save 404 results to log ?
     * @var boolean
     */
    protected $ignoreNotFound = false;

    /**
     * Array of errors caused by last request
     * @var array
     */
    private $errors = [];

    /**
     * Access Token Info
     * @var Token
     */
    protected $tokener = null;

    /**
     * Class for read only interaction with IPEX.
     *
     * @param mixed $init default record id or initial data
     * @param array $options Connection settings override
     */
    public function __construct($init = null, $options = [])
    {
        $this->init = $init;

        parent::__construct();
        $this->setUp($options);
        $this->curlInit();

        if (get_class($this) != 'primaERP\Token') {
            $this->tokener = Token::instanced();
        }

        if (!empty($init)) {
            $this->processInit($init);
        }
    }

    /**
     * SetUp Object to be ready for connect
     *
     * @param array $options Object Options (company,url,user,password,section,
     *                                       defaultUrlParams,debug)
     */
    public function setUp($options = [])
    {
        $this->setupProperty($options, 'url', 'PRIMAERP_URL');
        $this->setupProperty($options, 'user', 'PRIMAERP_LOGIN');
        $this->setupProperty($options, 'password', 'PRIMAERP_PASSWORD');
        $this->setupProperty($options, 'apikey', 'PRIMAERP_APIKEY');
        if (isset($options['section'])) {
            $this->setSection($options['section']);
        }
        $this->setupProperty($options, 'defaultUrlParams');
        $this->setupProperty($options, 'debug');
        $this->updateApiURL();
    }

    /**
     * Inicializace CURL
     */
    public function curlInit()
    {
        $this->curl = \curl_init(); // create curl resource
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true); // return content as a string from curl_exec
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true); // follow redirects (compatibility for future changes in IPEX)
        curl_setopt($this->curl, CURLOPT_HTTPAUTH, true);       // HTTP authentication
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false); // IPEX by default uses Self-Signed certificates
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_VERBOSE, ($this->debug === true)); // For debugging
        curl_setopt($this->curl, CURLOPT_USERPWD,
            $this->user.':'.$this->password); // set username and password
    }

    /**
     * Zinicializuje objekt dle daných dat. Možné hodnoty:
     *
     *  * 234                              - interní číslo záznamu k načtení
     *  * code:LOPATA                      - kód záznamu
     *  * BAGR                             - kód záznamu ka načtení
     *  * ['id'=>24,'nazev'=>'hoblík']     - pole hodnot k předvyplnění
     *  * 743.json?relations=adresa,vazby  - část url s parametry k načtení
     *
     * @param mixed $init číslo/"(code:)kód"/(část)URI záznamu k načtení | pole hodnot k předvyplnění
     */
    public function processInit($init)
    {
        if (empty($init) == false) {
            $this->loadFromAPI($init);
        }
    }

    /**
     * Nastaví Sekci pro Komunikaci.
     * Set section for communication
     *
     * @param string $section section pathName to use
     * @return boolean section switching status
     */
    public function setSection($section)
    {
        $this->section = $section;
        return $this->updateApiURL();
    }

    /**
     * Vrací právě používanou evidenci pro komunikaci
     * Obtain current used section
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Převede rekurzivně Objekt na pole.
     *
     * @param object|array $object
     *
     * @return array
     */
    public static function object2array($object)
    {
        $result = null;
        if (is_object($object)) {
            $objectData = get_object_vars($object);
            if (is_array($objectData) && count($objectData)) {
                $result = array_map('self::object2array', $objectData);
            }
        } else {
            if (is_array($object)) {
                foreach ($object as $item => $value) {
                    $result[$item] = self::object2array($value);
                }
            } else {
                $result = $object;
            }
        }

        return $result;
    }

    /**
     * Převede rekurzivně v poli všechny objekty na jejich identifikátory.
     *
     * @param object|array $object
     *
     * @return array
     */
    public static function objectToID($object)
    {
        $resultID = null;
        if (is_object($object)) {
            $resultID = $object->__toString();
        } else {
            if (is_array($object)) {
                foreach ($object as $item => $value) {
                    $resultID[$item] = self::objectToID($value);
                }
            } else { //String
                $resultID = $object;
            }
        }

        return $resultID;
    }

    /**
     * Připraví data pro odeslání do FlexiBee
     *
     * @param string $data
     */
    public function setPostFields($data)
    {
        $this->postFields = $data;
    }

    /**
     * Return basic URL for used Evidence
     *
     * @return string Evidence URL
     */
    public function getSectionURL()
    {
        $sectionUrl = $this->url.'/'.$this->protoVersion.'/';
        $section    = $this->getSection();
        if (!empty($section)) {
            $sectionUrl .= $section;
        }
        return $sectionUrl;
    }

    /**
     * Add suffix to Evidence URL
     *
     * @param string $urlSuffix
     *
     * @return string
     */
    public function sectionUrlWithSuffix($urlSuffix)
    {
        $sectionUrl = $this->getSectionURL();
        if (!empty($urlSuffix)) {
            $sectionUrl .= '/'.$urlSuffix;
        }
        return $sectionUrl;
    }

    /**
     * Update $this->apiURL
     */
    public function updateApiURL()
    {
        $this->apiURL = $this->getSectionURL();
    }

    /**
     * Funkce, která provede I/O operaci a vyhodnotí výsledek.
     *
     * @param string $urlSuffix část URL za identifikátorem firmy.
     * @param string $method    HTTP/REST metoda
     * 
     * @return array|boolean Výsledek operace
     */
    public function requestData($urlSuffix = null, $method = 'GET')
    {
        $this->rowCount = null;

        if (preg_match('/^http/', $urlSuffix)) {
            $url = $urlSuffix;
        } elseif ($urlSuffix[0] == '/') {
            $url = $this->url.$urlSuffix;
        } else {
            $url = $this->sectionUrlWithSuffix($urlSuffix);
        }

        $this->authentication();

        $url = $this->addDefaultUrlParams($url);

        $responseCode = $this->doCurlRequest($url, $method);

        return strlen($this->lastCurlResponse) ? $this->parseResponse($this->rawResponseToArray($this->lastCurlResponse,
                    $this->responseMimeType), $responseCode) : null;
    }

    public function authentication()
    {
        if (!is_null($this->tokener)) {
                $this->defaultUrlParams['token'] = $this->getTokenString();
        }
    }

    /**
     * Add params to url
     *
     * @param string  $url      originall url
     * @param array   $params   value to add
     * @param boolean $override replace already existing values ?
     *
     * @return string url with parameters added
     */
    public function addUrlParams($url, $params, $override = false)
    {
        $urlParts = parse_url($url);
        $urlFinal = $urlParts['scheme'].'://'.$urlParts['host'].$urlParts['path'];
        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $queryUrlParams);
            $urlParams = $override ? array_merge($params, $queryUrlParams) : array_merge($queryUrlParams,
                    $params);
        } else {
            $urlParams = $params;
        }

        $urlFinal .= '?'.http_build_query($urlParams);
        return $urlFinal;
    }

    /**
     * Add Default Url params to given url if not overrided
     *
     * @param string $urlRaw
     *
     * @return string url with default params added
     */
    public function addDefaultUrlParams($urlRaw)
    {
        return $this->addUrlParams($urlRaw, $this->defaultUrlParams, false);
    }

    /**
     * Parse primaERP API Response
     *
     * @param string $responseRaw raw response body
     *
     * @return array
     */
    public function rawResponseToArray($responseRaw)
    {
        $responseDecoded = json_decode($responseRaw, true, 10);
        $decodeError     = json_last_error_msg();
        if ($decodeError != 'No error') {
            $this->addStatusMessage('JSON Decoder: '.$decodeError, 'error');
            $this->addStatusMessage($responseRaw, 'debug');
        }
        return $responseDecoded;
    }

    /**
     * Parse Response array
     *
     * @param array $responseDecoded
     * @param int $responseCode Request Response Code
     *
     * @return array main data part of response
     */
    public function parseResponse($responseDecoded, $responseCode)
    {
        $response = null;
        switch ($responseCode) {
            case 201: //Success Write
                if (isset($responseDecoded[$this->resultField][0]['id'])) {
                    $this->lastInsertedID = $responseDecoded[$this->resultField][0]['id'];
                    $this->setMyKey($this->lastInsertedID);
                    $this->apiURL         = $this->getSectionURL().'/'.$this->lastInsertedID;
                } else {
                    $this->lastInsertedID = null;
                }
            case 200: //Success Read
                $response         = $this->lastResult = $responseDecoded;
                break;

            case 500: // Internal Server Error
            case 404: // Page not found
                if ($this->ignoreNotFound === true) {
                    break;
                }
            case 400: //Bad Request parameters
            default: //Something goes wrong
                $this->addStatusMessage($responseDecoded['status'].': '.
                    $this->curlInfo['url'], 'warning');
                if (is_array($responseDecoded)) {
                    $this->parseError($responseDecoded);
                }
                $this->logResult($responseDecoded, $this->curlInfo['url']);
                break;
        }
        return $response;
    }

    /**
     * Parse error message response
     *
     * @param array $responseDecoded
     * @return int number of errors processed
     */
    public function parseError(array $responseDecoded)
    {
        $this->errors = $responseDecoded;
        return count($this->errors);
    }

    /**
     * Vykonej HTTP požadavek
     *
     * @link https://www.ipex.eu/api/dokumentace/ref/urls/ Sestavování URL
     * @param string $url    URL požadavku
     * @param string $method HTTP Method GET|POST|PUT|OPTIONS|DELETE
     * @return int HTTP Response CODE
     */
    public function doCurlRequest($url, $method)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
// Nastavení samotné operace
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
//Vždy nastavíme byť i prázná postdata jako ochranu před chybou 411
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->postFields);

        $httpHeaders = $this->defaultHttpHeaders;

        if (!isset($httpHeaders['Accept'])) {
            $httpHeaders['Accept'] = 'application/json';
        }
        if (!isset($httpHeaders['Content-Type'])) {
            $httpHeaders['Content-Type'] = 'application/json';
        }
        $httpHeadersFinal = [];
        foreach ($httpHeaders as $key => $value) {
            if (($key == 'User-Agent') && ($value == 'php-primaERP')) {
                $value .= ' v'.self::$libVersion;
            }
            $httpHeadersFinal[] = $key.': '.$value;
        }

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $httpHeadersFinal);

// Proveď samotnou operaci
        $this->lastCurlResponse            = curl_exec($this->curl);
        $this->curlInfo                    = curl_getinfo($this->curl);
        $this->curlInfo['when']            = microtime();
        $this->curlInfo['request_headers'] = $httpHeadersFinal;
        $this->responseMimeType            = $this->curlInfo['content_type'];
        $this->lastResponseCode            = $this->curlInfo['http_code'];
        $this->lastCurlError               = curl_error($this->curl);
        if (strlen($this->lastCurlError)) {
            $this->addStatusMessage(sprintf('Curl Error (HTTP %d): %s',
                    $this->lastResponseCode, $this->lastCurlError), 'error');
        }

        if ($this->debug === true) {
            $this->saveDebugFiles();
        }

        return $this->lastResponseCode;
    }

    /**
     * Convert XML to array.
     *
     * @param string $xml
     *
     * @return array
     */
    public static function xml2array($xml)
    {
        $arr = [];

        if (is_string($xml)) {
            $xml = simplexml_load_string($xml);
        }

        foreach ($xml->children() as $r) {
            if (count($r->children()) == 0) {
                $arr[$r->getName()] = strval($r);
            } else {
                $arr[$r->getName()][] = self::xml2array($r);
            }
        }

        return $arr;
    }

    public function loadFromAPI($key)
    {
        return $this->takeData($this->requestData($key));
    }

    /**
     * Write Operation Result.
     *
     * @param array  $resultData
     * @param string $url        URL
     * @return boolean Log save success
     */
    public function logResult($resultData = null, $url = null)
    {
        $logResult = false;
        if (is_null($resultData)) {
            $resultData = $this->lastResult;
        }
        if (isset($url)) {
            $this->logger->addStatusMessage(urldecode($url));
        }
        if (array_key_exists('message', $resultData)) {
            $this->logger->addStatusMessage($resultData['code'].': '.$resultData['message'].array_key_exists('description',
                    $resultData) ? ' ('.$resultData['description'].')' : '',
                'warning');
        }

        return $logResult;
    }



        /**
     * Current Token String
     *
     * @return string
     */
    public function getTokenString()
    {
        return $this->tokener->getTokenString();
    }


    /**
     * Set or get ignore not found pages flag
     *
     * @param boolean $ignore set flag to
     *
     * @return boolean get flag state
     */
    public function ignore404($ignore = null)
    {
        if (!is_null($ignore)) {
            $this->ignoreNotFound = $ignore;
        }
        return $this->ignoreNotFound;
    }

    /**
     * Odpojení od IPEX.
     */
    public function disconnect()
    {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }
        $this->curl = null;
    }

    /**
     * Reconnect After unserialization
     */
    public function __wakeup()
    {
        parent::__wakeup();
        $this->curlInit();
    }

    /**
     * Disconnect CURL befere pass away
     */
    public function __destruct()
    {
        $this->disconnect();
    }
}
