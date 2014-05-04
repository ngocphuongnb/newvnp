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
        <link rel="stylesheet" type="text/css" href="<?php  echo APPLICATION_BASE;?>/data/themes/vnp_admin/css/style.css" />
        <?php echo $Hook["header"];?>
    </head>
    
    <body>
    	<div class="container-fluid">
        	<div class="row" id="AdminBoard">
            	<div class="col-xs-6 col-md-4" id="left-sidebar">
                	<ul id="admin-functions">
                    	<li>
                        	<a href="<?php  echo ADMIN_BASE;?>Node/">Node</a>
                            <ul class="submenu">
                            	<li><a href="<?php  echo ADMIN_BASE;?>Node/Manage/">Manage</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Node/NodeType/group/">Node type group</a></li>
                            </ul>
                      	</li>
                    	<li>
                        	<a href="<?php  echo ADMIN_BASE;?>Node/NodeType/">Node type</a>
                            <ul class="submenu">
                            	<li><a href="<?php  echo ADMIN_BASE;?>Node/NodeType/add/">Add node type</a></li>
                                <li><a href="<?php  echo ADMIN_BASE;?>Node/NodeType/group/">Node type group</a></li>
                            </ul>
                      	</li>
                        <li>
                        	<a href="<?php  echo ADMIN_BASE;?>File/">Files manager</a>
                            <ul class="submenu">
                            	<li><a href="<?php  echo ADMIN_BASE;?>File/upload/">Upload</a></li>
                            </ul>
                      	</li>
                    	<li><a href="<?php  echo ADMIN_BASE;?>logout">Logout</a></li>
                        <li><a href="<?php  echo ADMIN_BASE;?>setting">Setting</a></li>
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