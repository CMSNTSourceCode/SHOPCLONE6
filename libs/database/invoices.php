<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}




function whereInvoicePending($payment_method, $amount)
{
    $CMSNT = new DB();
    return $CMSNT->get_list(
        "SELECT * FROM `invoices` WHERE 
        `status` = 0 AND 
        `payment_method` = '$payment_method' AND 
        `pay` <= '$amount' AND 
        `fake` = 0 AND
        ".time()." - `create_time` < ".$CMSNT->site('invoice_expiration')."
        ORDER BY id DESC "
    );
}
function queryCancelInvoices()
{
    $CMSNT = new DB();
    $CMSNT->update("invoices", [
        'status'    => 2
    ], " `status` = 0 AND ".time()." - `create_time` > ".$CMSNT->site('invoice_expiration')." ");
    return true;
}
