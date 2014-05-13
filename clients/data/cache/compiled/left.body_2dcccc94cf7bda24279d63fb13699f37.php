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
            	<?php echo $Hook['before_body'] ?>
            	<div class="col-xs-6 col-md-4" id="left-sidebar" role="navigation">
                	<ul id="admin-functions">
                    	
                    </ul>
                </div>
                <div class="col-xs-12 col-md-8 box" id="main-board">
                	<?php echo $BODY ?>
                </div>
            </div>
      	</div>
        <?php echo $Hook['footer'] ?>
    </body>
</html>