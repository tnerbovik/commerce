<?php
namespace Craft;

/**
 * Class Commerce_DiscountsController
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2015, Pixel & Tonic, Inc.
 * @license   http://craftcommerce.com/license Craft Commerce License Agreement
 * @see       http://craftcommerce.com
 * @package   craft.plugins.commerce.controllers
 * @since     1.0
 */
class Commerce_DiscountsController extends Commerce_BaseCpController
{

    /**
     * @throws HttpException
     */
    public function init()
    {
        craft()->userSession->requirePermission('commerce-managePromotions');
        parent::init();
    }

    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        $discounts = craft()->commerce_discounts->getAllDiscounts(['order' => 'name']);
        $this->renderTemplate('commerce/promotions/discounts/index',
            compact('discounts'));
    }

    /**
     * Create/Edit Discount
     *
     * @param array $variables
     *
     * @throws HttpException
     */
    public function actionEdit(array $variables = [])
    {
        if (empty($variables['discount'])) {
            if (!empty($variables['id'])) {
                $id = $variables['id'];
                $variables['discount'] = craft()->commerce_discounts->getDiscountById($id);

                if (!$variables['discount']) {
                    throw new HttpException(404);
                }
            } else {
                $variables['discount'] = new Commerce_DiscountModel();
            }
        }

        if (!empty($variables['id'])) {
            $variables['title'] = $variables['discount']->name;
        } else {
            $variables['title'] = Craft::t('Create a Discount');
        }

        //getting user groups map
        if (craft()->getEdition() == Craft::Pro) {
            $groups = craft()->userGroups->getAllGroups();
            $variables['groups'] = \CHtml::listData($groups, 'id', 'name');
        } else {
            $variables['groups'] = [];
        }

        //getting product types maps
        $types = craft()->commerce_productTypes->getAllProductTypes();
        $variables['types'] = \CHtml::listData($types, 'id', 'name');

        $variables['products'] = null;
        $products = $productIds = [];
        if (empty($variables['id'])) {
            $productIds = explode('|', craft()->request->getParam('productIds'));
        } else {
            $productIds = $variables['discount']->getProductsIds();
        }
        foreach ($productIds as $productId) {
            $product = craft()->commerce_products->getProductById($productId);
            if($product){
                $products[] = $product;
            }
        }
        $variables['products'] = $products;

        $this->renderTemplate('commerce/promotions/discounts/_edit', $variables);
    }

    /**
     * @throws HttpException
     */
    public function actionSave()
    {
        $this->requirePostRequest();

        $discount = new Commerce_DiscountModel();

        // Shared attributes
        $fields = [
            'id',
            'name',
            'description',
            'dateFrom',
            'dateTo',
            'enabled',
            'purchaseTotal',
            'purchaseQty',
            'baseDiscount',
            'perItemDiscount',
            'percentDiscount',
            'freeShipping',
            'excludeOnSale',
            'code',
            'perUserLimit',
            'totalUseLimit'
        ];
        foreach ($fields as $field) {
            $discount->$field = craft()->request->getPost($field);
        }

        $products = craft()->request->getPost('products', []);
        if (!$products) {
            $products = [];
        }
        $productTypes = craft()->request->getPost('productTypes', []);
        $groups = craft()->request->getPost('groups', []);

        // Save it
        if (craft()->commerce_discounts->saveDiscount($discount, $groups, $productTypes,
            $products)
        ) {
            craft()->userSession->setNotice(Craft::t('Discount saved.'));
            $this->redirectToPostedUrl($discount);
        } else {
            craft()->userSession->setError(Craft::t('Couldn’t save discount.'));
        }

        // Send the model back to the template
        craft()->urlManager->setRouteVariables(['discount' => $discount]);
    }

    /**
     * @throws HttpException
     */
    public function actionDelete()
    {
        $this->requirePostRequest();
        $this->requireAjaxRequest();

        $id = craft()->request->getRequiredPost('id');

        craft()->commerce_discounts->deleteDiscountById($id);
        $this->returnJson(['success' => true]);
    }

}
