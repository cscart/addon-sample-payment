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

/**
 * This is a sample payment gateway implementation.
 * You don't need this for your integration!
 */

defined('BOOTSTRAP') or die('Access denied');

/** @var string $mode */

$transaction_id = implode('-', str_split(md5(TIME), 8));
$order_id = (int) $_REQUEST['order_id'];
$payment_sum = (float) $_REQUEST['payment_sum'];

if ($mode === 'gateway') {
    /** @var \Tygh\SmartyEngine\Core $view */
    $view = Tygh::$app['view'];

    $cancel_url = $_REQUEST['cancel_url'];
    $return_url = fn_link_attach(
        $_REQUEST['return_url'],
        "transaction_id={$transaction_id}"
    );
    $view->assign([
        'order_id'    => $order_id,
        'payment_sum' => $payment_sum,
        'return_url'  => $return_url,
        'cancel_url'  => $cancel_url,
    ]);

    $view->display('addons/sample_payment/views/sample_payment/gateway.tpl');
}

if ($mode === 'api') {
    header('Content-Type: application/json');

    if ($order_id % 2 === 0) {
        $response = [
            'status'         => 'SUCCESS',
            'transaction_id' => $transaction_id,
        ];
    } else {
        $response = [
            'status' => 'FAILURE',
            'error'  => 'Orders with even number will succeed, orders with odd numbers will fail.<br>Your order number is ' . $order_id,
        ];
    }

    echo json_encode($response);
}

return [CONTROLLER_STATUS_NO_CONTENT];
