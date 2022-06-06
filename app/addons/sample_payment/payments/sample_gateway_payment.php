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

use Tygh\Enum\OrderStatuses;

defined('BOOTSTRAP') or die('Access denied');

// PAYMENT_NOTIFICATION constant is defined when requesting the "payment_notification" controller
if (defined('PAYMENT_NOTIFICATION')) {
    /** @var string $mode */

    $order_id = (int) $_REQUEST['order_id'];
    // Check that order was placed with this payment processor
    if (!fn_check_payment_script(SAMPLE_GATEWAY_PROCESSOR, $order_id)) {
        die('Access denied');
    }

    /**
     * Process return from payment gateway here.
     *
     * Check the mode of the return URL ----------↴
     * /index.php?dispatch=payment_notification.{mode}&payment={...}&order_id={...}
     */
    if ($mode === 'return') {
        $pp_response = [
            'order_status'   => OrderStatuses::PAID,
            'transaction_id' => (string) $_REQUEST['transaction_id'],
        ];
    } else {
        $pp_response = [
            'order_status' => OrderStatuses::INCOMPLETED,
        ];
    }

    fn_finish_payment($order_id, $pp_response);
    fn_order_placement_routines('route', $order_id);
}

/** @var int $order_id */
/** @var array $order_info */
/** @var array $processor_data */

/**
 * Put your payment gateway URL here
 */
$payment_gateway_url = fn_url('sample_payment.gateway');

/**
 * Put your payment data here
 */
$post_data = [
    // Some customer data
    'customer_email' => $order_info['email'],
    // Some order data
    'payment_sum'    => $order_info['total'],
    'order_id'       => $order_id,
    // Payment gateway interaction settings
    'login'          => $processor_data['processor_params']['login'],
    'shared_secret'  => $processor_data['processor_params']['shared_secret'],
    // Customer will be returned to this URL after payment — use the "payment_notification" controller
    'return_url'     => fn_url('payment_notification.return?payment=sample_gateway_payment&order_id=' . $order_id),
    // Customer will be returned to this URL after cancelling payment — use the "payment_notification" controller
    'cancel_url'     => fn_url('payment_notification.cancel?payment=sample_gateway_payment&order_id=' . $order_id),
];

fn_create_payment_form($payment_gateway_url, $post_data);
