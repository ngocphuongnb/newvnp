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
    	{$Hook.before_body}
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
                    <div id="menu-container">
                        [@MainMenu@]
                    </div>
                    <div class="Clear"></div>
                </div>
                <div id="Wrapper">
                    <div id="cphMain_Content">
                        <div id="cphMain_ctl00_LeftPane" class="left">
                        	[@LeftSidebar@] 
                        </div>
                        <div id="cphMain_ctl00_ContentPane" class="center">
                        	[@BeforeMainContent@]
							[@MainContent@]
                            [@AfterMainContent@]
                            {$Page}
                        </div>
                        <div id="cphMain_ctl00_RightPane" class="right">
                        	[@RightSideBar@]
                        </div>
                    </div>
                    <div class="Clear"></div>
                </div>
                <div class="Clear"></div>
                <div id="Footer">
                	[@InnerFooter@]
                    <div id="FooterContainer">
                    	<!--[@FooterBlock1@]-->
                        <p>(c) 2014 Sugar Shop<br/>
                            Địa chỉ: Đống Đa Hà Nội<br/>
                            Email: nguyenngocphuongnb@gmail.com</p>
                    </div>
                    <div id="Powerby">
                    	<!--[@FooterBlock2@]--> Copyright
                  	</div>
                </div>
                <div class="Clear"></div>
                [@OuterFooter@]
                <div class="Clear"></div>
            </div>
        </div>
    </body>
</html>