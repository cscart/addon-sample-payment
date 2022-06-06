{*
 * This is a sample payment gateway implementation.
 * You don't need this for your integration!
 *}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    >
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sample Payment Gateway</title>
</head>
<body style="font-family: sans-serif">
<div style="margin: 20px auto; text-align: center; max-width: 320px;">
    <div style="font-size: 35px; margin-bottom: 20px">
        #{$order_id}: {include file="common/price.tpl" value = $payment_sum}
    </div>

    <div>
        <a style="display: block; box-sizing: border-box; width: 100%; margin-bottom: 20px; background: lightgrey; padding: 10px; border: 1px solid darkgrey; border-radius: 4px; text-decoration: none; color: dimgrey; text-transform: uppercase;"
           href="{$cancel_url}"
        >
            {__("cancel")}
        </a>

        <a style="display: block; box-sizing: border-box; width: 100%; margin-bottom: 20px; background: lightblue; padding: 10px; border: 1px solid cadetblue; border-radius: 4px; text-decoration: none; color: white; text-transform: uppercase;"
           href="{$return_url}"
        >
            {__("accept")}
        </a>
    </div>
</div>
</body>
</html>

