<?php

namespace shornuk\sendinblue\variables;

use shornuk\sendinblue\Sendinblue;
use shornuk\sendinblue\models\Contact;

use craft\elements\User;

class SendinblueVariable
{
    public function lists($params = [])
    {
        return Sendinblue::$plugin->api->getLists($params);
    }

    public function getListById(Int $id)
    {
        return Sendinblue::$plugin->api->getListById($id);
    }

    public function contactExists(String $email)
    {
        return Sendinblue::$plugin->api->contactExists($email);
    }

    public function createContact(String $email)
    {
        return Sendinblue::$plugin->api->createContact($email);
    }

}
