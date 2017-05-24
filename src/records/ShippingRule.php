<?php

namespace craft\commerce\records;

use craft\db\ActiveRecord;

/**
 * Shipping rule record.
 *
 * @property int            $id
 * @property string         $name
 * @property string         $description
 * @property int            $shippingZoneId
 * @property int            $methodId
 * @property int            $priority
 * @property bool           $enabled
 * @property int            $minQty
 * @property int            $maxQty
 * @property float          $minTotal
 * @property float          $maxTotal
 * @property float          $minWeight
 * @property float          $maxWeight
 * @property float          $baseRate
 * @property float          $perItemRate
 * @property float          $weightRate
 * @property float          $percentageRate
 * @property float          $minRate
 * @property float          $maxRate
 *
 * @property Country        $country
 * @property State          $state
 * @property ShippingMethod $method
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2015, Pixel & Tonic, Inc.
 * @license   https://craftcommerce.com/license Craft Commerce License Agreement
 * @see       https://craftcommerce.com
 * @package   craft.plugins.commerce.records
 * @since     1.0
 */
class ShippingRule extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'commerce_shippingrules';
    }

//    /**
//     * @return array
//     */
//    public function defineIndexes()
//    {
//        return [
//            ['columns' => ['name'], 'unique' => true],
//            ['columns' => ['methodId']],
//        ];
//    }
//
//    /**
//     * @return array
//     */
//    public function defineRelations()
//    {
//        return [
//            'shippingZone' => [self::BELONGS_TO, 'ShippingZone', 'onDelete' => static::SET_NULL],
//            'method' => [
//                self::BELONGS_TO,
//                'ShippingMethod',
//                'required' => true
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
//            'name' => [AttributeType::String, 'required' => true],
//            'description' => [AttributeType::String],
//            'methodId' => [AttributeType::Number, 'required' => true],
//            'priority' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0
//            ],
//            'enabled' => [
//                AttributeType::Bool,
//                'required' => true,
//                'default' => 1
//            ],
//            //filters
//            'minQty' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0
//            ],
//            'maxQty' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0
//            ],
//            'minTotal' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//            'maxTotal' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//            'minWeight' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//            'maxWeight' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//            //charges
//            'baseRate' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//            'perItemRate' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//            'weightRate' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//            'percentageRate' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//            'minRate' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//            'maxRate' => [
//                AttributeType::Number,
//                'required' => true,
//                'default' => 0,
//                'decimals' => 4
//            ],
//        ];
//    }
}