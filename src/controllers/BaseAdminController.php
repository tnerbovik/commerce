<?php

namespace craft\commerce\controllers;

use Craft;

/**
 * Class Base Admin Controller
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2015, Pixel & Tonic, Inc.
 * @license   https://craftcommerce.com/license Craft Commerce License Agreement
 * @see       https://craftcommerce.com
 * @package   craft.plugins.commerce.controllers
 * @since     1.0
 */
class BaseAdminController extends BaseController
{
    protected $allowAnonymous = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public function init()
    {
        // All system setting actions require an admin
        Craft::$app->getUser()->requireAdmin();

        parent::init();
    }
}
