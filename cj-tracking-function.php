<?php

// Add tracking code snippet for Commisino Junction
// Add this function to your functions.php file
// Be sure to use a child theme if you aren't already!

add_action( 'woocommerce_thankyou', 'add_cj_tracking' );

function add_cj_tracking( $order_id ){
	$order = wc_get_order( $order_id );
	$line_items = $order->get_items();
    $itemcnt = 0;

    // Tracking scripts parts
    $start_tracking = '<iframe height="1" width="1" frameborder="0" scrolling="no" src="';
    $tracking_src = ['https://www.emjcd.com/tags/c?containerTagId=24646', '&CID=1536041', '&TYPE=401825&CURRENCY=USD'];
    $end_tracking = '" name="cj_conversion" ></iframe>';

    echo $start_tracking . $tracking_src[0];

    foreach ( $line_items as $item ) {
        $product = $order->get_product_from_item( $item );
        $sku = $product->get_sku();
        $qty = $item->get_quantity();
        $price = $product->get_price();
        $price_formatted = number_format($price, 2, '.', '');
        $itemcnt++;

        echo '&ITEM' . $itemcnt . '=' . $sku . '&AMT' . $itemcnt . '=' . $price_formatted . '&QTY' . $itemcnt . "=" . $qty . '&DCNT' . $itemcnt . '=0';
    }
    echo $tracking_src[1] . '&OID=Order' . $order_id . $tracking_src[2] . $end_tracking;
}
