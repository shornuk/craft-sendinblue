<?php
/**
 * SendinBlue plugin for Craft CMS 3.x
 * Integration with SendinBlue API. Create, update and delete sendinblue Contacts from with Craft
 *
 * @link      shorn.co.uk
 * @copyright Copyright (c) 2020 Sean Hill
 */

namespace shornuk\sendinblue\services;

use shornuk\sendinblue\SendinBlue;

use Craft;
use craft\base\Component;
use craft\elements\User;

use GuzzleHttp\Client;
use yii\base\Exception;

use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\ContactsApi;
/**
 * @author    Sean Hill
 * @package   SendinBlue
 * @since     0.0.1
 */

class SendinBlueService extends Component
{
    // Public Properties
    // =========================================================================

   /**
    * @var \shornuk\sendinblue\models\Settings
    */
   public $settings;

   /**
    * @var string
    */
   protected static $apiBaseUrl = 'https://api.lever.co/v0/';

   /**
    * @var boolean
    */
   protected $isConfigured;


   // Private Properties
   // =========================================================================

   /**
    * @var \GuzzleHttp\Client
    */
   private $_client;

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();
        $this->settings = SendinBlue::$plugin->getSettings();
    }

    /**
     * Returns a configured Guzzle client.
     * @return Client
     * @throws \Exception if our API key is missing.
     */
    public function getClient(): Client
    {
        // Check the API key is set
        $this->isConfigured = !empty($this->settings->apiKey);

        if (!$this->isConfigured)
        {
            throw new Exception('API Key is required.');
        }

        if ($this->_client === null)
        {
            $this->_client = new Client([
                'base_uri' => self::$apiBaseUrl,
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept'       => 'application/json'
                ],
                'verify' => false,
                'debug' => false
            ]);
        }
        return $this->_client;
    }

    // function __construct() {

    //     $apiKey =  $this->pluginSettings->sibApiKey;
    //     $config = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);

    //     $this->apiInstance = new \SendinBlue\Client\Api\ContactsApi(
    //         new \GuzzleHttp\Client(),
    //         $config
    //     );
    // }

    public function getLists($params = []): Array
    {
        return array(1,2,3);
    }

}
