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
use shornuk\sendinblue\models\Contact;

use Craft;
use craft\base\Component;
use craft\elements\User;

use GuzzleHttp\Client;
use yii\base\Exception;

use SendinBlue\Client\ApiException;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\ListsApi;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Model\GetExtendedList;
use SendinBlue\Client\Model\CreateContact;
use SendinBlue\Client\Model\AddContactToList;
use SendinBlue\Client\Model\RemoveContactFromList;

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
        if ($this->_client === null)
        {
            $this->_client = new Client();
        }
        return $this->_client;
    }

    /**
    * Returns a API Instance.
    * @return Client
    * @throws \Exception if our API key is missing.
    */
    public function getApiInstance($api = 'contacts')
    {
        // Check the API key is set
        $this->isConfigured = !empty($this->settings->apiKey);

        if (!$this->isConfigured)
        {
            throw new Exception('API Key is required.');
        }
        switch ($api)
        {
            case 'lists':
                return new ListsApi($this->getClient(), Configuration::getDefaultConfiguration()->setApiKey('api-key', Craft::parseEnv($this->settings->apiKey)));
                break;

            case 'contacts':
                return new ContactsApi($this->getClient(), Configuration::getDefaultConfiguration()->setApiKey('api-key', Craft::parseEnv($this->settings->apiKey)));
                break;
        }

    }

    /**
    * Create a contact in Sendinblue.
    * @param User $element The user that we're checking exists in SendinBlue.
    * @return bool Whether the user exists.
    */
    public function createContact(String $email)
    {
        try
        {
            // Check if the user exists, if so return true
            $response = $this->getApiInstance()->createContact(new CreateContact(['email' => $email]));
        }
        catch (ApiException $e)
        {
            // 'duplicate_parameter' means contact already exists, return.
            $response = json_decode($e->getResponseBody(), true);
            if ($response['code'] === 'duplicate_parameter')
            {
                return false;
            }
        }
        return true;
    }

    public function getContactInfo(String $email)
    {
        if (!$this->contactExists($email))
        {
            $this->createContact($email);
        }
        try
        {
            $response = $this->getApiInstance()->getContactInfo($email);
        }
        catch (ApiException $e)
        {
            // 'duplicate_parameter' means contact already exists, return.
            $response = json_decode($e->getResponseBody(), true);
            if ($response['code'] === 'duplicate_parameter')
            {
                return false;
            }
        }
        return $response;
    }

    public function addContactToList(String $email, Int $list)
    {
        try
        {
            // Check if the user exists, if so return true
            $response = $this->getApiInstance('lists')->addContactToList($list, new AddContactToList(['emails'=>[ $email ]]));
        }
        catch (ApiException $e)
        {
            // 'duplicate_parameter' means contact already exists, return.
            $response = json_decode($e->getResponseBody(), true);
            if ($response['code'] === 'duplicate_parameter')
            {
                return false;
            }
        }
        return true;
    }

    public function removeContactFromList(String $email, Int $list)
    {
        try
        {
            // Check if the user exists, if so return true
            $response = $this->getApiInstance('lists')->removeContactFromList($list, new RemoveContactFromList(['emails'=>[ $email ]]));
        }
        catch (ApiException $e)
        {
            // 'duplicate_parameter' means contact already exists, return.
            $response = json_decode($e->getResponseBody(), true);
            if ($response['code'] === 'duplicate_parameter')
            {
                return false;
            }
        }
        return true;
    }

    public function subscribeToList($email, Int $list)
    {
        if (!$this->contactExists($email))
        {
            $this->createContact($email);
        }
        return $this->addContactToList($email, $list);
    }

    public function unsubscribeFromList($email, Int $list)
    {
        if (!$this->contactExists($email))
        {
            $this->createContact($email);
        }
        return $this->removeContactFromList($email, $list);
    }




    /**
    * Check a user exists.
    * @param User $element The user that we're checking exists in SendinBlue.
    * @return bool Whether the user exists.
    */
    public function contactExists(String $email): bool
    {
        try
        {
            // Check if the user exists, if so return true
            $response = $this->getApiInstance()->getContactInfo($email);
            if ($response->getEmail())
            {
                return true;
            }
        }
        catch (ApiException $e)
        {
            // 'document_not_found' means no contact exists
            $response = json_decode($e->getResponseBody(), true);
            if ($response['code'] === 'document_not_found')
            {
                return false;
            }
        }
    }


    /**
    * Gets all lists in users Sendin blue account.
    * @param array of settings, limit and offset (not yet implemented).
    * @return array all available lists.
    * @throws Exception if lists cannot be got
    */
    public function getLists($params = []): Array
    {
        try
        {
            $response = $this->getApiInstance()->getLists(null, 0);
        }
        catch (Exception $e)
        {
            throw new Exception('Exception when calling ContactsApi->getLists: ', $e->getMessage(), PHP_EOL);
        }
        return $response->getLists();
    }

    /**
    * Gets a list by ID from users sendinblue account.
    * @param Int $id list ID.
    * @return array Extended list details.
    * @throws Exception if list cannot be got
    */
    public function getListById(Int $id)
    {
        try
        {
            $response = $this->getApiInstance()->getList($id);
        }
        catch (Exception $e)
        {
            throw new Exception('Exception when calling ContactsApi->getList: ', $e->getMessage(), PHP_EOL);
        }
        return $response;
    }

}
