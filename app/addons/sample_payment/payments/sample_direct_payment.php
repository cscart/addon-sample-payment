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
use Tygh\Http;

defined('BOOTSTRAP') or die('Access denied');

/** @var int $order_id */
/** @var array $order_info */
/** @var array $processor_data */

/**
 * Put your API URL here
 */
$payment_api_url = fn_url('sample_payment.api');

/**
 * Put your payment data here
 */
$post_data = [
    // Some customer data
    'customer_email' => $order_info['email'],
    // Some order data
    'payment_sum'    => $order_info['total'],
    'order_id'       => $order_id,
    // Payment API interaction settings
    'login'          => $processor_data['processor_params']['login'],
    'shared_secret'  => $processor_data['processor_params']['shared_secret'],
];

$payment_api_response = Http::post($payment_api_url, $post_data);
$payment_api_response = json_decode($payment_api_response, true);

$pp_response = [];

/**
 * Process payment API response here
 */
if ($payment_api_response['status'] === 'SUCCESS') {
    $pp_response['order_status'] = OrderStatuses::PAID;
    $pp_response['transaction_id'] = $payment_api_response['transaction_id'];
} else {
    $pp_response['order_status'] = OrderStatuses::FAILED;
    $pp_response['reason_text'] = $payment_api_response['error'];
}

return $pp_response;
