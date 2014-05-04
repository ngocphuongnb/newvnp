<?php

if(!defined('THEME_BLOCK')) die('Error!');

$TPL = TPL::File($_BlockData['template']);

$publtime = CURRENT_TIME - $_BlockData['from_date'] * 86400;
$Products = DB::Query('product', USER_DOMAIN)
			->Where('add_time', '>', $publtime)->_AND()
			->Where('add_time', '<', CURRENT_TIME)->_AND()
			->Where('product_groupids', 'INCLUDE', $_BlockData['product_group'])
			->Limit($_BlockData['num_rows'])->Order('product_id', 'DESC')->Get()->Result;

$Products = array_map(function($Product) {
	$Product['product_url'] = Router::Generate('ProductDetail', 
												array(	'product'	=> $Product['product_url'] ,
														'HashID'	=> Crypt::EncryptHashID($Product['product_id'],PRODUCT_HASHID)
											));
	$Product['product_thumb'] = ThumbBase . THUMB_SIZE . $Product['product_image'];
	return $Product;
}, $Products);
//n($_BlockData);
$TPL->Assign('Products', $Products);
$TPL->Assign('Config', $_BlockData);
$TPL->Assign('BLOCK', $Block);
$_BlockContent = $TPL->Output();

//n(DB::Log());

?>