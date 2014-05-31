<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{$META.title}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{#GLOBAL_DATA_DIR}library/bootstrap/normalize.min.css" />
        <link rel="stylesheet" type="text/css" href="{#GLOBAL_DATA_DIR}library/bootstrap/bootstrap-theme.min.css" />
        {$CssComponents}
        <link rel="stylesheet" type="text/css" href="{#GLOBAL_DATA_DIR}library/bootstrap/docs.min.css" />
        <link rel="stylesheet" type="text/css" href="{#APPLICATION_DATA_DIR}theme/vnp/css/style.css" />
        {$Hook.header}
    </head>
    
    <body>
    	<div class="container-fluid">
        	<div class="row" id="AdminBoard">
            	<header>
                	<a href="{#BASE_DIR}" class="VNP_Logo"></a>
                </header>
            	{$Hook.before_body}
            	<div class="col-md-2" id="VNP_LeftBar" role="navigation">
                	<ul id="AdminMenus">
                    	<li><a href="{#BASE_DIR}">Main board</a></li>
                        <li><a href="{#BASE_DIR}NodeBuilderGUI/">Node builder</a></li>
                        <li><a href="{#BASE_DIR}User/">User</a></li>
                        <li><a href="{#BASE_DIR}logout">Logout</a></li>
                    </ul>
                </div>
                <div class="col-md-10 box" id="main-board">
                	{if(!empty($PageInfo) || !empty($FeaturedPanel))}
                	<div class="FeaturedPanel clearfix">
                        {if(!empty($PageInfo))}
                        <span class="VNP_PageInfo">{$PageInfo}</span>
                        {/if}
                        {if(!empty($FeaturedPanel))}
                        <ul class="FeaturedButtons">
                            {for $FP in $FeaturedPanel}
                            <li>
                                <a href="{$FP.url}" title="{$FP.text}">
                                    <span class="glyphicon glyphicon-{$FP.class}"></span>&nbsp;{$FP.text}
                                </a>
                            </li>
                            {/for}
                        </ul>
                        {/if}
                  	</div>
                    {/if}
                	{for $_notifyType in $Notify}
                    	{for $_notify in $_notifyType}
                    		<div class="alert alert-{$_notify.type}">{$_notify.content}</div>
                       	{/for}
                    {/for}
                	{$BODY}
                </div>
            </div>
      	</div>
        {$Hook.footer}
    </body>
</html>