<?php if(!class_exists('ntpl')){exit;}?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $META["title"];?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php  echo DATA_DIR;?>library/bootstrap/normalize.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php  echo DATA_DIR;?>library/bootstrap/bootstrap-theme.min.css" />
        <?php echo $CssComponents;?>
        <link rel="stylesheet" type="text/css" href="<?php  echo DATA_DIR;?>library/bootstrap/docs.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php  echo CDN_SERVER;?>/<?php  echo APPLICATION_NAME;?>/data/themes/<?php echo $Theme_Directory;?>/css/style.css" />
        <?php echo $Hook["header"];?>
    </head>
    
    <body>
    	<div class="container-fluid">
        	<div class="row" id="AdminBoard">
            	<div class="col-xs-6 col-md-4" id="left-sidebar">
                	<ul id="admin-functions">
                    	<li>
                        	<a href="<?php  echo ADMIN_BASE;?>Products/">Sản phẩm</a>
                            <ul class="submenu">
                            	<li><a href="<?php  echo ADMIN_BASE;?>Products/Action/Add/">Thêm sản phẩm</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Products/Category/">Danh mục sản phẩm</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Products/Category/Add/">Thêm danh mục</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Products/Group/">Nhóm sản phẩm</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Products/Group/Add/">Thêm nhóm</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Products/Comments/">Quản lý bình luận</a></li>
                            </ul>
                      	</li>
                    	<li>
                        	<a href="<?php  echo ADMIN_BASE;?>Articles/">Bài viết</a>
                            <ul class="submenu">
                            	<li><a href="<?php  echo ADMIN_BASE;?>Articles/Add/">Thêm bài viết</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Articles/Category/">Chuyên mục bài viết</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Articles/Category/Add/">Thêm chuyên mục</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Articles/Group/">Nhóm bài viết</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Articles/Group/Add/">Thêm nhóm</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Articles/Comments/">Quản lý bình luận</a></li>
                            </ul>
                      	</li>
                        <li>
                        	<a href="<?php  echo ADMIN_BASE;?>Media/">Quản lý tệp tin</a>
                            <ul class="submenu">
                            	<li><a href="<?php  echo ADMIN_BASE;?>Media/upload/">Tải lên tệp tin</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Media/setting/">Cài đặt sử dụng</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Media/info/">Thông tin sử dụng</a></li>
                            </ul>
                      	</li>
                        <li>
                        	<a href="<?php  echo ADMIN_BASE;?>Analytics/">Phân tích website</a>
                            <ul class="submenu">
                            	<li><a href="<?php  echo ADMIN_BASE;?>Analytics/Trafic/">Lưu lượng truy cập</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Analytics/Referer/">Nguồn truy cập</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Analytics/ErrorReported/">Thông báo lỗi</a></li>
                            </ul>
                      	</li>
                        <li>
                        	<a href="<?php  echo ADMIN_BASE;?>Template/">Cài đặt giao diện</a>
                            <ul class="submenu">
                                <li><a href="<?php  echo ADMIN_BASE;?>Template/Design/">Tùy chỉnh giao diện</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Template/Menu/">Quản lý menu</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Template/Theme/">Chọn giao diện</a></li>
                            </ul>
                      	</li>
                        <li>
                        	<a href="<?php  echo ADMIN_BASE;?>Settings/">Thiết lập website</a>
                            <ul class="submenu">
                            	<li><a href="<?php  echo ADMIN_BASE;?>Settings/System/">Thiết lập chung</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Settings/Seo/">Cài đặt SEO</a></li>
                            </ul>
                      	</li>
                        <li><a href="<?php  echo ADMIN_BASE;?>logout">Đăng xuất</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-8 box" id="main-board">
                	<ol class="breadcrumb" id="board-breadcrumbs">
                    	<?php $counter1=-1; if( isset($State) && is_array($State) && sizeof($State) ) foreach( $State as $key1 => $StateItem ){ $counter1++; ?>
                        <li><a href="<?php echo $StateItem["route"];?>"><?php echo $StateItem["title"];?></a></li>
                        <?php } ?>
                    </ol>
                    <?php echo $PageHeader;?>
                    <?php $counter1=-1; if( isset($Notify) && is_array($Notify) && sizeof($Notify) ) foreach( $Notify as $key1 => $_notify ){ $counter1++; ?>
                    <div class="alert alert-<?php echo $_notify["type"];?>"><?php echo $_notify["content"];?></div>
                    <?php } ?>
                	<?php echo $BODY;?>
                    <?php echo $Page;?>
                </div>
            </div>
      	</div>
        <?php echo $Hook["footer"];?>
    </body>
</html>