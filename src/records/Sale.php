<?php

namespace craft\commerce\records;

use craft\db\ActiveRecord;
use craft\records\UserGroup;

/**
 * Sale record.
 *
 * @property int           $id
 * @property string        $name
 * @property string        $description
 * @property \DateTime     $dateFrom
 * @property \DateTime     $dateTo
 * @property string        $discountType
 * @property float         $discountAmount
 * @property bool          $allGroups
 * @property bool          $allProducts
 * @property bool          $allProductTypes
 * @property bool          $enabled
 *
 * @property Product[]     $products
 * @property ProductType[] $productTypes
 * @property UserGroup[]   $groups
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2015, Pixel & Tonic, Inc.
 * @license   https://craftcommerce.com/license Craft Commerce License Agreement
 * @see       https://craftcommerce.com
 * @package   craft.plugins.commerce.records
 * @since     1.0
 */
class Sale extends ActiveRecord
{
    const TYPE_PERCENT = 'percent';
    const TYPE_FLAT = 'flat';

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'commerce_sales';
    }

//    /**
//     * @return array
//     */
//    public function defineRelations()
//    {
//        return [
//            'groups' => [
//                static::MANY_MANY,
//                'UserGroup',
//                'commerce_sale_usergroups(saleId, userGroupId)'
//            ],
//            'products' => [
//                static::MANY_MANY,
//                'Product',
//                'commerce_sale_products(saleId, productId)'
//            ],
//            'productTypes' => [
//                static::MANY_MANY,
//                'ProductType',
//                'commerce_sale_producttypes(saleId, productTypeId)'
//            ],
//        ];
//    }
//
//    /**
//     * @return array
//     */
//    protected function defineAttributes()
//    {
//        return [
//            'name' => [AttributeType::Name, 'required' => true],
//            'description' => AttributeType::Mixed,
//            'dateFrom' => AttributeType::DateTime,
//            'dateTo' => AttributeType::DateTime,
//            'discountType' => [
//                AttributeType::Enum,
//                'values' => [self::TYPE_PERCENT, self::TYPE_FLAT],
//                'required' => true
//            ],
//            'discountAmount' => [
//                AttributeType::Number,
//                'decimals' => 4,
//                'required' => true
//            ],
//            'allGroups' => [
//                AttributeType::Bool,
//                'required' => true,
//                'default' => 0
//            ],
//            'allProducts' => [
//                AttributeType::Bool,
//                'required' => true,
//                'default' => 0
//            ],
//            'allProductTypes' => [
//                AttributeType::Bool,
//                'required' => true,
//                'default' => 0
//            ],
//            'enabled' => [
//                AttributeType::Bool,
//                'required' => true,
//                'default' => 1
//            ],
//        ];
//    }

}