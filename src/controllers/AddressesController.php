<?php

namespace craft\commerce\controllers;

use Craft;
use craft\commerce\models\Address as AddressModel;
use craft\commerce\Plugin;
use yii\web\HttpException;

/** @noinspection */

/**
 * Class Address Controller
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2015, Pixel & Tonic, Inc.
 * @license   http://craftcommerce.com/license Craft Commerce License Agreement
 * @see       http://craftcommerce.com
 * @package   craft.plugins.commerce.controllers
 * @since     1.0
 */
class AddressController extends BaseAdminController
{

    /**
     * @throws HttpException
     */
    public function init()
    {
        $this->requirePermission('commerce-manageOrders');
        parent::init();
    }

    /**
     * Edit Address
     *
     * @param array $variables
     *
     * @throws HttpException
     */
    public function actionEdit(array $variables = [])
    {
        if (empty($variables['address'])) {
            if (empty($variables['addressId'])) {
                throw new HttpException(404);
            }

            $id = $variables['addressId'];
            $variables['address'] = Plugin::getInstance()->getAddresses()->getAddressById($id);

            if (!$variables['address']) {
                throw new HttpException(404);
            }
        }

        $variables['title'] = Craft::t('commerce', 'Edit Address', ['id' => $variables['addressId']]);

        $variables['countries'] = Plugin::getInstance()->getCountries()->getAllCountriesListData();
        $variables['states'] = Plugin::getInstance()->getStates()->getStatesGroupedByCountries();

        $this->renderTemplate('commerce/addresses/_edit', $variables);
    }

    /**
     * @throws HttpException
     */
    public function actionSave()
    {
        $this->requirePostRequest();

        $id = Craft::$app->getRequest()->getRequiredParam('id');
        $address = Plugin::getInstance()->getAddresses()->getAddressById($id);

        if (!$address) {
            $address = new AddressModel();
        }

        // Shared attributes
        $attributes = [
            'attention',
            'title',
            'firstName',
            'lastName',
            'address1',
            'address2',
            'city',
            'zipCode',
            'phone',
            'alternativePhone',
            'businessName',
            'businessTaxId',
            'businessId',
            'countryId',
            'stateValue'
        ];
        foreach ($attributes as $attr) {
            $address->$attr = Craft::$app->getRequest()->getParam($attr);
        }

        // Save it
        if (Plugin::getInstance()->getAddresses()->saveAddress($address)) {

            if (Craft::$app->getRequest()->isAjax) {
                $this->asJson(['success' => true, 'address' => $address]);
            }

            Craft::$app->getSession()->setNotice(Craft::t('commerce', 'Address saved.'));
            $this->redirectToPostedUrl();
        } else {
            if (Craft::$app->getRequest()->isAjax) {
                $this->asJson([
                    'error' => Craft::t('commerce', 'Couldn’t save address.'),
                    'errors' => $address->errors
                ]);
            }

            Craft::$app->getSession()->setError(Craft::t('commerce', 'Couldn’t save address.'));
        }

        // Send the model back to the template
        Craft::$app->getUrlManager()->setRouteParams(['address' => $address]);
    }

    /**
     * @throws HttpException
     */
    public function actionDelete()
    {
        $this->requirePostRequest();
        $this->requireAcceptsJson();

        $id = Craft::$app->getRequest()->getRequiredParam('id');

        Plugin::getInstance()->getAddresses()->deleteAddressById($id);
        $this->asJson(['success' => true]);
    }
}
