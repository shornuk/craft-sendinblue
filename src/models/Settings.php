<?php
/**
 * SendinBlue plugin for Craft CMS 3.x
 *
 * Integration with SendinBlue API. Create, update and delete sendinblue Contacts from with Craft
 *
 * @link      shorn.co.uk
 * @copyright Copyright (c) 2020 Sean Hill
 */

namespace shornuk\sendinblue\models;

use shornuk\sendinblue\SendinBlue;

use Craft;
use craft\base\Model;
use craft\behaviors\EnvAttributeParserBehavior;

/**
 * SendinBlue Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Sean Hill
 * @package   SendinBlue
 * @since     0.0.1
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

     /**
     * @var string An API key to used for accessing the Send in Blue API
     */
    public $apiKey;

    // Public Methods
    // =========================================================================

    public function behaviors(): array
    {
        return [
            'parser' => [
                'class' => EnvAttributeParserBehavior::class,
                'attributes' => ['apiKey'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'apiKey' => Craft::t('sendinblue', 'API Key'),
        ];
    }

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
            ['apiKey', 'required']
        ];
    }
}
