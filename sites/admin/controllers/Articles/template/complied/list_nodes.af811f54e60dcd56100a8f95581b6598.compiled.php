<?php if(!class_exists('ntpl')){exit;}?><nav class="navbar navbar-default" role="navigation">
    <ul class="nav navbar-nav">
        <li>
        	<a href="<?php  echo ARTICLE_BASE;?>Category/Add/">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Thêm chuyên mục bài viết
            </a>
     	</li>
        <li>
            <a href="<?php  echo ARTICLE_BASE;?>Group/Add/">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Thêm nhóm bài viết
            </a>
     	</li>
        <li>
            <a href="<?php  echo ARTICLE_BASE;?>Action/Add/">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Thêm bài viết
            </a>
        </li>
 	</ul>
</nav>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-2">
        <col class="col-xs-6">
        <col class="col-xs-2">
        </colgroup>
        <thead>
            <tr>
                <th>Node ID</th>
                <th>Node title</th>
                <th>Featured</th>
            </tr>
        </thead>
        <tbody>
        	<?php $counter1=-1; if( isset($Nodes) && is_array($Nodes) && sizeof($Nodes) ) foreach( $Nodes as $key1 => $Node ){ $counter1++; ?>
            <tr>
            	<td><code><?php echo $Node[$NodeType["node_type_name"] . '_id'];?></code></td>
                <td><?php echo $Node[$NodeType["node_type_name"] . '_title'];?></td>
                <td class="Item_Featured">
                	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                    <a href="<?php  echo ARTICLE_BASE;?><?php echo $CTL_ACTION;?>/Edit/<?php echo $Node[$NodeType["node_type_name"] . '_id'];?>/">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                    <a href="<?php  echo ARTICLE_BASE;?><?php echo $CTL_ACTION;?>/Remove/<?php echo $Node[$NodeType["node_type_name"] . '_id'];?>/">Remove</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>