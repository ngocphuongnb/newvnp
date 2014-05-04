<?php if(!class_exists('ntpl')){exit;}?><nav class="navbar navbar-default" role="navigation">
    <ul class="nav navbar-nav">
        <li>
        	<a href="<?php  echo TEMPLATE_BASE;?>MenuGroup/Add/">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Thêm khối menu
            </a>
     	</li>
        <li>
            <a href="<?php  echo TEMPLATE_BASE;?>Menu/Add/<?php echo $MenuGroup["menu_group_id"];?>/">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Thêm menu
            </a>
     	</li>
 	</ul>
</nav>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-1">
        <col class="col-xs-4">
        <col class="col-xs-2">
        <col class="col-xs-3">
        <col class="col-xs-3">
        </colgroup>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên menu</th>
                <th>Tiêu đề link</th>
                <th>Đường dẫn</th>
                <th>Featured</th>
            </tr>
        </thead>
        <tbody>
        	<?php $counter1=-1; if( isset($Nodes) && is_array($Nodes) && sizeof($Nodes) ) foreach( $Nodes as $key1 => $Node ){ $counter1++; ?>
            <tr>
            	<td><code><?php echo $Node['menu_id'];?></code></td>
                <td><?php if( $Node['level'] != '' ){ ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?><span class="menu_level"><?php echo $Node['level'];?></span>&nbsp;<a href="<?php  echo TEMPLATE_BASE;?>Menu/Edit/<?php echo $Node['menu_id'];?>/"><?php echo $Node['menu_title'];?></a></td>
                <td><?php echo $Node['menu_titletag'];?></td>
                <td><?php echo $Node['menu_url'];?></td>
                <td class="Item_Featured">
                	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                    <a href="<?php  echo TEMPLATE_BASE;?>Menu/Edit/<?php echo $Node['menu_id'];?>/">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                    <a href="<?php  echo TEMPLATE_BASE;?>Menu/Remove/<?php echo $Node['menu_id'];?>/">Remove</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<style type="text/css">
.menu_level {
	font-family: Arial, Helvetica, sans-serif;
	font-size:12px
}
.table>tbody>tr>td {
	padding: 8px
}
</style>