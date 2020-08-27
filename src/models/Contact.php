<?php
/**
 * SendinBlue plugin for Craft CMS 3.x
 * Integration with SendinBlue API. Create, update and delete sendinblue Contacts from with Craft
 *
 * @link      shorn.co.uk
 * @copyright Copyright (c) 2020 Sean Hill
 */

namespace shornuk\sendinblue\models;

use shornuk\sendinblue\SendinBlue;

use Craft;
use craft\base\Model;

/**
 * @author    Sean Hill
 * @package   SendinBlue
 * @since     0.0.1
 */
class Contact extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $email;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'email'],
            ['email', 'required']
        ];
    }
}
