<?php

namespace shornuk\sendinblue\variables;

use shornuk\sendinblue\Sendinblue;

class SendinblueVariable
{
    public function lists($params = [])
    {
        return Sendinblue::$plugin->api->getLists($params);
    }

}
