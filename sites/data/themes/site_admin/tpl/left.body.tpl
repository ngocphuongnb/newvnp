<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{$META.title}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{#DATA_DIR#}library/bootstrap/normalize.min.css" />
        <link rel="stylesheet" type="text/css" href="{#DATA_DIR#}library/bootstrap/bootstrap-theme.min.css" />
        {$CssComponents}
        <link rel="stylesheet" type="text/css" href="{#DATA_DIR#}library/bootstrap/docs.min.css" />
        <link rel="stylesheet" type="text/css" href="{#CDN_SERVER#}/{#APPLICATION_NAME#}/data/themes/{$Theme_Directory}/css/style.css" />
        {$Hook.header}
    </head>
    
    <body>
    	<div class="container-fluid">
        	<div class="row" id="AdminBoard">
            	<a href="#nav" class="nav-toggle">Menu</a>
            	<div class="col-xs-6 col-md-4" id="left-sidebar" role="navigation">
                	<ul id="admin-functions">
                    	<li>
                        	<a href="{#ADMIN_BASE#}Products/">Sản phẩm</a>
                            <ul class="submenu">
                            	<li><a href="{#ADMIN_BASE#}Products/Action/Add/">Thêm sản phẩm</a></li>
                                <li><a href="{#ADMIN_BASE#}Products/Category/">Danh mục sản phẩm</a></li>
                                <li><a href="{#ADMIN_BASE#}Products/Category/Add/">Thêm danh mục</a></li>
                                <li><a href="{#ADMIN_BASE#}Products/Group/">Nhóm sản phẩm</a></li>
                                <li><a href="{#ADMIN_BASE#}Products/Group/Add/">Thêm nhóm</a></li>
                                <li><a href="{#ADMIN_BASE#}Products/Order/">Đơn hàng</a></li>
                                <li><a href="{#ADMIN_BASE#}Products/Tutorial/">Hướng dẫn mua hàng</a></li>
                                <li><a href="{#ADMIN_BASE#}Products/setting/">Cài đặt sản phẩm</a></li>
                            </ul>
                      	</li>
                    	<li>
                        	<a href="{#ADMIN_BASE#}Articles/">Bài viết</a>
                            <ul class="submenu">
                            	<li><a href="{#ADMIN_BASE#}Articles/Action/Add/">Thêm bài viết</a></li>
                                <li><a href="{#ADMIN_BASE#}Articles/Category/">Chuyên mục bài viết</a></li>
                                <!--
                                <li><a href="{#ADMIN_BASE#}Articles/Category/Add/">Thêm chuyên mục</a></li>
                                -->
                                <li><a href="{#ADMIN_BASE#}Articles/Group/">Nhóm bài viết</a></li>
                                <!--
                                <li><a href="{#ADMIN_BASE#}Articles/Group/Add/">Thêm nhóm</a></li>
                                -->
                            </ul>
                      	</li>
                        <li>
                        	<a href="{#ADMIN_BASE#}Template/">Cài đặt giao diện</a>
                            <ul class="submenu">
                                <li><a href="{#ADMIN_BASE#}Template/Design/">Tùy chỉnh giao diện</a></li>
                                <li><a href="{#ADMIN_BASE#}Template/MenuGroup/">Quản lý menu</a></li>
                                <li><a href="{#ADMIN_BASE#}Template/Theme/">Chọn giao diện</a></li>
                            </ul>
                      	</li>
                        <li>
                        	<a href="{#ADMIN_BASE#}Analytics/">Thống kê website</a>
                            <ul class="submenu">
                            	<li><a href="{#ADMIN_BASE#}Analytics/Trafic/">Lưu lượng truy cập</a></li>
                                <li><a href="{#ADMIN_BASE#}Analytics/ErrorReported/">Thông báo lỗi</a></li>
                                <li><a href="{#ADMIN_BASE#}Stats/">Thông tin sử dụng</a></li>
                            </ul>
                      	</li>
                        <li>
                        	<a href="{#ADMIN_BASE#}File/">Quản lý tệp tin</a>
                            <ul class="submenu">
                            	<li><a href="{#ADMIN_BASE#}File/upload/">Tải lên tệp tin</a></li>
                                <li><a href="{#ADMIN_BASE#}File/setting/">Cài đặt sử dụng</a></li>
                                <li><a href="{#ADMIN_BASE#}File/Help/">Hướng dẫn sử dụng</a></li>
                            </ul>
                      	</li>
                        <li>
                        	<a href="{#ADMIN_BASE#}Comments/">Quản lý bình luận</a>
                            <ul class="submenu">
                            	<li><a href="{#ADMIN_BASE#}Comments/contacts/">Phản hồi khách hàng</a></li>
                                <li><a href="{#ADMIN_BASE#}Comments/contact_form/">Cấu hình form liên hệ</a></li>
                                <li><a href="{#ADMIN_BASE#}Comments/online_support/">Hỗ trợ trực tuyến</a></li>
                            </ul>
                      	</li>
                        
                        
                        <li>
                        	<a href="{#ADMIN_BASE#}Settings/">Thiết lập website</a>
                            <ul class="submenu">
                            	<li><a href="{#ADMIN_BASE#}Settings/System/">Thiết lập chung</a></li>
                                <li><a href="{#ADMIN_BASE#}Settings/Seo/">Cài đặt SEO</a></li>
                            </ul>
                      	</li>
                        <li>
                        	<a href="{#ADMIN_BASE#}User/">Thông tin quản trị</a>
                            <ul class="submenu">
                            	<li><a href="{#ADMIN_BASE#}logout">Đăng xuất</a></li>
                            </ul>
                     	</li>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-8 box" id="main-board">
                	<ol class="breadcrumb" id="board-breadcrumbs">
                    	{for $StateItem in $State}
                        <li><a href="{$StateItem.route}">{$StateItem.title}</a></li>
                        {/for}
                    </ol>
                    {$PageHeader}
                    {for $_notifyType in $Notify}
                    	{for $_notify in $_notifyType}
                    		<div class="alert alert-{$_notify.type}">{$_notify.content}</div>
                       	{/for}
                    {/for}
                	{$BODY}
                    {$Page}
                </div>
            </div>
      	</div>
        {$Hook.footer}
    </body>
</html>