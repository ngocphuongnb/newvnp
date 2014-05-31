<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $META['title'] ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo GLOBAL_DATA_DIR ?>library/bootstrap/normalize.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo GLOBAL_DATA_DIR ?>library/bootstrap/bootstrap-theme.min.css" />
        <?php echo $CssComponents ?>
        <link rel="stylesheet" type="text/css" href="<?php echo GLOBAL_DATA_DIR ?>library/bootstrap/docs.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo APPLICATION_DATA_DIR ?>theme/vnp/css/style.css" />
        <?php echo $Hook['header'] ?>
    </head>
    
    <body>
    	<div class="container-fluid">
        	<div class="row" id="AdminBoard">
            	<header>
                	<a href="<?php echo BASE_DIR ?>" class="VNP_Logo"></a>
                </header>
            	<?php echo $Hook['before_body'] ?>
            	<div class="col-md-2" id="VNP_LeftBar" role="navigation">
                	<ul id="AdminMenus">
                    	<li><a href="<?php echo BASE_DIR ?>">Main board</a></li>
                        <li><a href="<?php echo BASE_DIR ?>NodeBuilderGUI/">Node builder</a></li>
                        <li><a href="<?php echo BASE_DIR ?>User/">User</a></li>
                        <li><a href="<?php echo BASE_DIR ?>logout">Logout</a></li>
                    </ul>
                </div>
                <div class="col-md-10 box" id="main-board">
                	<?php if(!empty($PageInfo) || !empty($FeaturedPanel)) { ?>
                	<div class="FeaturedPanel clearfix">
                        <?php if(!empty($PageInfo)) { ?>
                        <span class="VNP_PageInfo"><?php echo $PageInfo ?></span>
                        <?php } ?>
                        <?php if(!empty($FeaturedPanel)) { ?>
                        <ul class="FeaturedButtons">
                            <?php foreach($FeaturedPanel as $FP) { ?>
                            <li>
                                <a href="<?php echo $FP['url'] ?>" title="<?php echo $FP['text'] ?>">
                                    <span class="glyphicon glyphicon-<?php echo $FP['class'] ?>"></span>&nbsp;<?php echo $FP['text'] ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                  	</div>
                    <?php } ?>
                	<?php foreach($Notify as $_notifyType) { ?>
                    	<?php foreach($_notifyType as $_notify) { ?>
                    		<div class="alert alert-<?php echo $_notify['type'] ?>"><?php echo $_notify['content'] ?></div>
                       	<?php } ?>
                    <?php } ?>
                	<?php echo $BODY ?>
                </div>
            </div>
      	</div>
        <?php echo $Hook['footer'] ?>
    </body>
</html>