<?php

/**** Mapping for module News - Home ****/
Router::map('NewsHome', '/tin-tuc' . URL_EXT, 'NewsHome', 'GET' );
/**** Mapping for module News - Category ****/
Router::map('NewsCategory', '/tin-tuc/[:category]' . URL_EXT, 'NewsCategory', 'GET' );
/**** Mapping for module News - Group ****/
Router::map('NewsGroup', '/tin-tuc/[:group]/', 'NewsGroup', 'GET' );
/**** Mapping for module News - Detail ****/
Router::map('NewsDetail', '/tin-tuc/[:article]-[a:HashID]' . URL_EXT, 'NewsDetail', 'GET' );

/**** Mapping for module Product - Home ****/
Router::map('ProductHome', '/', 'ProductHome', 'GET' );
/**** Mapping for module Product - Category ****/
Router::map('ProductCategory', '/[:category]' . URL_EXT, 'ProductCategory', 'GET' );
Router::map('ProductCategoryPage', '/[:category]/page-[i:page]' . URL_EXT, 'ProductCategory', 'GET' );
/**** Mapping for module Product - Group ****/
Router::map('ProductGroup', '/san-pham/[:group]' . URL_EXT, 'ProductGroup', 'GET' );
/**** Mapping for module Product - Detail ****/
Router::map('ProductDetail', '/[:product]/[a:HashID]' . URL_EXT, 'ProductDetail', 'GET' );

/**** Mapping for static page ****/
Router::map('StaticPage', '/[:page]/', 'StaticPage', 'GET' );

?>