<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{$META.title}</title>
        {for $_TagContent in $METATAGS as $_TagName}
        <meta name="{$_TagName}" content="{$_TagContent}"/>
        {/for}
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {$CssComponents}
        <link rel="stylesheet" href="{#CDN_SERVER#}/fruits/css/style.css">
        {$Hook.header}
    </head>
    
    <body>
    	<div id="Container">
            <div class="Clear"></div>
            <div id="Outer">
                <div id="Header">
                    <div id="Logo">
                        <div id="LogoContainer">
                            <h1><a href="#">Sugar Shop<span>Đống Đa Hà Nội</span></a></h1>
                        </div>
                    </div>
                    <div class="Clear"></div>
                </div>
                <div id="Menu">
                    <div style="display: none;">
                        <div id="inline1" class="popup-cart"></div>
                        <a class="ProductAddButton" href="#">Popup Cart</a>
                    </div>
                    <div id="menu-container">
                        <ul id="nav">
                            <li id="nav-1" class="level0 nav-1 first current parent"><a href="#" ><span>Trang chủ</span> </a></li>
                            <li id="nav-2" class="level0 nav-2 parent"> <a href="#" > <span>Giới thiệu</span> </a></li>
                            <li id="nav-3" class="level0 nav-3 parent"> <a href="#" > <span>Sản phẩm</span> </a></li>
                            <li id="nav-4" class="level0 nav-4 parent"> <a href="#" > <span>Tin tức</span> </a></li>
                            <li id="nav-5" class="level0 nav-5 parent"> <a href="#" > <span>Bản đồ</span> </a></li>
                            <li id="nav-6" class="level0 nav-6 parent"> <a href="#" > <span>Liên hệ</span> </a></li>
                        </ul>
                    </div>
                    <div id="SearchForm">
                        <div id="SearchFormContainer">
                            <input name="" type="text" id="" class="search-input"/>
                            <input type="submit" name="" value="" id="" class="search-button" />
                            <a href="#" class="search-adv" title="Tìm kiếm nâng cao"> <span>+</span> </a>
                        </div>
                    </div>
                    <div class="Clear"></div>
                </div>
                <div id="Wrapper">
                    <div id="cphMain_Content">
                        <div id="cphMain_ctl00_LeftPane" class="left">
                            <div id="cate-menu" class="DefaultModule cate-menu">
                                <div class="defaultTitle cate-menu-title"> <span>Danh mục sản phẩm</span> </div>
                                <div class="defaultContent cate-menu-content">
                                    <ul>
                                        <li class="level0 level0-931612 first"><a href="#"> <span> Rau quả</span></a>
                                            <ul style="display: block;">
                                                <li class="level1 level1-931613 first"><a href="#"> <span> Trái cây nhập khẩu</span></a></li>
                                                <li class="level1 level1-931614"><a href="#"> <span> Hoa quả Việt Nam</span></a></li>
                                                <li class="level1 level1-931615"><a href="#"> <span> Rau sạch</span></a></li>
                                            </ul>
                                        </li>
                                        <li class="level0 level0-931616"><a href="#"> <span> Thực phẩm tươi sống</span></a>
                                            <ul style="display: block;">
                                                <li class="level1 level1-931617 first"><a href="#"> <span> Hải sản</span></a></li>
                                                <li class="level1 level1-931618"><a href="#"> <span> Thủy sản nước ngọt</span></a></li>
                                                <li class="level1 level1-931619"><a href="#"> <span> Các loại thịt</span></a></li>
                                            </ul>
                                        </li>
                                        <li class="level0 level0-931620"><a href="#"> <span> Ngũ cốc</span></a>
                                            <ul style="display: block;">
                                                <li class="level1 level1-931621 first"><a href="#"> <span> Ngũ cốc trong nước</span></a></li>
                                                <li class="level1 level1-931622"><a href="#"> <span> Ngũ cốc nhập khẩu</span></a></li>
                                                <li class="level1 level1-931623"><a href="#"> <span> Ngũ cốc đã qua chế biến</span></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="defaultFooter cate-menu-footer">
                                    <div></div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div id="cphMain_ctl00_ContentPane" class="center">
                            <div id="HomeFeaturedProducts" class="Block FeaturedProducts DefaultModule">
                                <div class="defaultTitle TitleContent"> <span>Sản phẩm nổi bật</span> </div>
                                <div class="defaultContent BlockContent">
                                    
                                </div>
                                <div class="defaultFooter FooterContent">
                                </div>
                                <div class="Clear"></div>
                            </div>
                        </div>
                        <div id="cphMain_ctl00_RightPane" class="right">
                            <div class="mini-cart DefaultModule">
                                <div class="defaultTitle mini-cart-title"> <span> Giỏ hàng</span></div>
                                <div class="defaultContent mini-cart-content">
                                    <div id="plist">
                                        <div class="non-product"> Chưa có sản phẩm nào trong giỏ hàng của bạn! </div>
                                    </div>
                                </div>
                                <div class="clear defaultFooter mini-cart-footer">
                                    <div> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="Clear"></div>
                </div>
                <div class="Clear"></div>
                <div id="Footer">
                    <div id="FooterContainer">
                        <p>(c) 2014 Sugar Shop<br/>
                            Địa chỉ: Đống Đa Hà Nội<br/>
                            Email: nguyenngocphuongnb@gmail.com</p>
                    </div>
                    <div id="Powerby"> Copyright  </div>
                </div>
                <div class="Clear"></div>
            </div>
        </div>
    </body>
</html>