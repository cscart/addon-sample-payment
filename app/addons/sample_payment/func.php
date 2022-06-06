<?php
/***************************************************************************
 *                                                                          *
 *   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
 *                                                                          *
 * This  is  commercial  software,  only  users  who have purchased a valid *
 * license  and  accept  to the terms of the  License Agreement can install *
 * and use this program.                                                    *
 *                                                                          *
 ****************************************************************************
 * PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
 * "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
 ****************************************************************************/

use Tygh\Enum\ObjectStatuses;
use Tygh\Enum\YesNo;

defined('BOOTSTRAP') or die('Access denied');

/**
 * Creates payment processor on add-on installation.
 *
 * @return void
 */
function fn_sample_payment_add_payment_processor()
{
    db_query(
        'INSERT INTO ?:payment_processors ?e',
        [
            'processor'          => 'Sample Gateway Payment (redirect customer to payment server)',
            'processor_script'   => SAMPLE_GATEWAY_PROCESSOR,
            'processor_template' => 'views/orders/components/payments/cc_outside.tpl',
            'admin_template'     => 'sample_gateway_payment.tpl',
            'callback'           => YesNo::NO,
            'type'               => 'P',
        ]
    );

    db_query(
        'INSERT INTO ?:payment_processors ?e',
        [
            'processor'          => 'Sample Direct Payment (create payment by API)',
            'processor_script'   => SAMPLE_DIRECT_PROCESSOR,
            'processor_template' => 'views/orders/components/payments/cc_outside.tpl',
            'admin_template'     => 'sample_direct_payment.tpl',
            'callback'           => YesNo::NO,
            'type'               => 'P',
        ]
    );
}

/**
 * Removes payments processors and disables payment methods on add-on uninstallation.
 *
 * @return void
 */
function fn_sample_payment_delete_payment_processor()
{
    $addon_processor_ids = db_get_fields(
        'SELECT processor_id FROM ?:payment_processors WHERE processor_script IN (?a)',
        [SAMPLE_GATEWAY_PROCESSOR, SAMPLE_DIRECT_PROCESSOR]
    );

    db_query(
        'UPDATE ?:payments SET status = ?s, processor_params = ?s, processor_id = ?i WHERE processor_id IN (?n)',
        ObjectStatuses::DISABLED,
        '',
        0,
        $addon_processor_ids
    );

    db_query(
        'DELETE FROM ?:payment_processors WHERE processor_id IN (?n)',
        $addon_processor_ids
    );
}
