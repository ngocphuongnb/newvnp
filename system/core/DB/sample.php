<?php


DB::Query('ct_types')->Where('ct_type_id', '=', 1, DB::INT);
DB::Query('ct_types')->Where('ct_type_id', '<>', 1, DB::INT);
DB::Query('ct_types')->Where('ct_type_id', 'IN', '1,2,3,4,5', DB::INT);
DB::Query('ct_types')->Where('ct_type_id', 'IN', array(1,2,3,4,5), DB::INT);
DB::Query('ct_types')->Where('_full_name', 'IN', 'nguyen, ngoc, phuong', DB::STRING);
DB::Query('ct_types')->Where('_full_name', 'IN', array('nguyen', 'ngoc', 'phuong'), DB::STRING);

DB::Query('ct_types')->Where('ct_type_id', 'INCLUDE', 1, DB::INT);
DB::Query('ct_types')->Where('_full_name', 'INCLUDE', 'phuong', DB::STRING);

DB::Query('ct_types')->Where('ct_type_id', 'INCLUDE', '1,2,3,4,5', DB::INT);
DB::Query('ct_types')->Where('ct_type_id', 'INCLUDE', array(1,2,3,4,5), DB::INT);
DB::Query('ct_types')->Where('_full_name', 'INCLUDE', 'nguyen, ngoc, phuong', DB::STRING);
DB::Query('ct_types')->Where('_full_name', 'INCLUDE', array('nguyen', 'ngoc', 'phuong'), DB::STRING);

DB::Query('ct_types')
		->Where('ct_type_id', '=', 1)->AND()
		->GroupWhere('group1', function($query) {
					   $query->Where('type', '=', 1)->AND
							 ->Where('status', '=', 0);
				   })->AND()
		->GroupWhere('group2', function($query) {
					   $query->Where('type', '=', 1)->AND
							 ->Where('status', '=', 0);
				   })->OR();


?>