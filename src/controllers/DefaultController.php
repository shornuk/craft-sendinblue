<?php
/**
 * SendinBlue plugin for Craft CMS 3.x
 *
 * Integration with SendinBlue API. Create, update and delete sendinblue Contacts from with Craft
 *
 * @link      shorn.co.uk
 * @copyright Copyright (c) 2020 Sean Hill
 */

namespace shornuk\sendinblue\controllers;

use shornuk\sendinblue\SendinBlue;

use Craft;
use craft\web\Controller;

/**
 * Default Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Sean Hill
 * @package   SendinBlue
 * @since     0.0.1
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/sendin-blue/default
     *
     * @return mixed
     */
    public function actionIndex()
        {
            // Get the request
            // $this->requirePostRequest();
            // $request  = Craft::$app->getRequest();
            // $plugin   = Plugin::getInstance();

            // $response = [];
            // $response['success'] = true;
            // // Create a new signup
            // $contact = new Contact();
            // $contact->email = $request->getBodyParam('email');

            // if(!$contact->validate()){
            //     $response['success'] = false;
            //     $response['errors']  = $contact->getErrors();
            //     return $this->asJson($response);
            // }

            // $response = Sendinblue::$plugin->api->createContact($signup);

            // return $this->asJson($response);
        }

}
