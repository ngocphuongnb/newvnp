<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Product
{
	private $Category = 0;
	public function __construct() {
	}
	public function _main() {
		$LastestProduct;
	}
	
	public function Category($Route) {
		$CatAlias = $Route['params']['category'];
		$this->Category = DB::Query('product_category')->Where('product_category_url', '=', $CatAlias)->Get()->Result[0];
		$Products = DB::Query('product', USER_DOMAIN)->Where('product_catids', 'INCLUDE', $this->Category['product_category_id'])->Limit(4)->Order('product_id', 'DESC')->Get('product_id', Output::Paging())->Result;
		
		$Products = array_map(function($Product) {
			$Product['product_url'] =
			Router::Generate(	'ProductDetail', 
								array(	'product'	=> $Product['product_url'] ,
										'HashID'	=> Crypt::EncryptHashID($Product['product_id'],PRODUCT_HASHID)
							));
			$Product['product_thumb'] = ThumbBase . THUMB_SIZE . $Product['product_image'];
			return $Product;
		}, $Products);
		
		$TPL = TPL::File('product_cat');
		$TPL->Assign('Category', $this->Category);
		$TPL->Assign('Products', $Products);
		Output::$Paging['base_url'] = SITE_BASE . $CatAlias;
		Output::$Paging['ext'] = URL_EXT;
		Output::$Paging['bridge'] = '-';
		Theme::$Body = $TPL->Output();
	}
	
	public function Detail($Route) {
		$Params = $Route['params'];
		$IDs = Crypt::DecryptHashID($Params['HashID']);
		
		if(!empty($IDs)) {
			$GetProduct = DB::Query('product', USER_DOMAIN)
								->Where('product_url','=',$Params['product'])->_AND()
								->Where('product_id', '=', $IDs[0])
								->Get();
			if($GetProduct->num_rows != 1) trigger_error('Product not found!');
			else {
				$Product = $GetProduct->Result[0];
				$mtTitle = !empty($Product['meta_title']) ? $Product['meta_title'] : $Product['product_title'];
				Theme::SetTitle($mtTitle);
				$TPL = TPL::File('product_detail');
				$Product['product_thumb'] = ThumbBase . '220_220' . $Product['product_image'];
				$TPL->Assign('Product', $Product);
				Theme::$Body = $TPL->Output();
			}
		}
		else trigger_error('Product not found!');
	}
}


?>