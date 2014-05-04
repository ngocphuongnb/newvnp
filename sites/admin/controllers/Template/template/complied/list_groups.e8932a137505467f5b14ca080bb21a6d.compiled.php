<?php if(!class_exists('ntpl')){exit;}?><nav class="navbar navbar-default" role="navigation">
    <ul class="nav navbar-nav">
        <li>
        	<a href="<?php  echo TEMPLATE_BASE;?>MenuGroup/Add/">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Thêm khối menu
            </a>
     	</li>
 	</ul>
</nav>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-2">
        <col class="col-xs-6">
        <col class="col-xs-3">
        </colgroup>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên khối</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
        	<?php $counter1=-1; if( isset($Nodes) && is_array($Nodes) && sizeof($Nodes) ) foreach( $Nodes as $key1 => $Node ){ $counter1++; ?>
            <tr>
            	<td><code><?php echo $Node[$NodeType["node_type_name"] . '_id'];?></code></td>
                <td> <a href="<?php  echo TEMPLATE_BASE;?>MenuGroup/listmenu/<?php echo $Node[$NodeType["node_type_name"] . '_id'];?>/"><?php echo $Node[$NodeType["node_type_name"] . '_title'];?></a></td>
                <td class="Item_Featured">
                	<span class="glyphicon glyphicon-plus"></span>&nbsp;
                    <a href="<?php  echo TEMPLATE_BASE;?>Menu/Add/<?php echo $Node[$NodeType["node_type_name"] . '_id'];?>/">Thêm</a>&nbsp;&nbsp;&nbsp;&nbsp;
                	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                    <a href="<?php  echo TEMPLATE_BASE;?><?php echo $CTL_ACTION;?>/Edit/<?php echo $Node[$NodeType["node_type_name"] . '_id'];?>/">Sửa</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                    <a href="<?php  echo TEMPLATE_BASE;?><?php echo $CTL_ACTION;?>/Remove/<?php echo $Node[$NodeType["node_type_name"] . '_id'];?>/">Xóa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>