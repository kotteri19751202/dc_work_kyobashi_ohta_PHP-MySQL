<?php
// Model（model.php）を読み込む
require_once 'model.php';
 
$product_data = [];
$pdo = get_connection();
$product_data = get_product_list( $pdo );
$product_data = h_array( $product_data) ;
 
// View(view.php）読み込み
include_once 'view.php';
