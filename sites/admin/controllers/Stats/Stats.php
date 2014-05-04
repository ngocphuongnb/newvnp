<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');
define('STATS_BASE', Router::BasePath() . '/Stats/');

class Stats
{
	public function main() {
		Helper::State('Thống kê sử dụng', STATS_BASE . 'upload/');
		Helper::Header('Thống kê sử dụng');
		Theme::SetTitle('Thống kê sử dụng');
		
		Theme::AddCssComponent('Forms,InputGroups,Tables,ButtonGroups');
		Theme::JsHeader('ChartJS', CDN_SERVER . '/data/library/chart.js');
		$UserInfo = DB::Query('customers', '', DB::Slave())
							->Where('subname', '=', USER_DOMAIN)
							->Cache(USER_CACHE_PATH)
							->Get()->Result[0];
							
		$PackageInfo = DB::Query('web_package', '', DB::Slave())
							->Where('package_id', '=', $UserInfo['package_id'])
							->Get()->Result[0];
		$Q = 'SELECT SUM(media_size) FROM `' . DB::Prefix() . USER_DOMAIN . '_media` ';
		$TotalSize = DB::CustomQuery($Q)->fetch_row();
		$Stats['memory'] = $TotalSize[0]/$PackageInfo['limit_memory']*100;
		$Stats['article'] = $UserInfo['total_article']/$PackageInfo['limit_article']*100;
		$Stats['product'] = $UserInfo['total_product']/$PackageInfo['limit_product']*100;
		
		Theme::JsFooter('MemoryChart', 'var ctx = document.getElementById("MemoryUsage").getContext("2d");var data = [{value: ' . $Stats['memory'] . ',color:"#F38630"},{value : 100,color : "#69D2E7"}];new Chart(ctx).Pie(data);', 'inline');
		Theme::JsFooter('ArticleChart', 'var ctx = document.getElementById("ProductStats").getContext("2d");var data = [{value: ' . $Stats['article'] . ',color:"#F38630"},{value : 100,color : "#69D2E7"}];new Chart(ctx).Pie(data);', 'inline');
		Theme::JsFooter('ProductChart', 'var ctx = document.getElementById("ArticleStats").getContext("2d");var data = [{value: ' . $Stats['product'] . ',color:"#F38630"},{value : 100,color : "#69D2E7"}];new Chart(ctx).Pie(data);', 'inline');
		
		$File = TPL::File('main');
		$File->Assign('Stats', $Stats);
		$File->Assign('Package', $PackageInfo);
		Theme::$Body = $File->Output();
	}
}

?>