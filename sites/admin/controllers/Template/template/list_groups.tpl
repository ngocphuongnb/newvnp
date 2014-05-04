<nav class="navbar navbar-default" role="navigation">
    <ul class="nav navbar-nav">
        <li>
        	<a href="{#TEMPLATE_BASE}MenuGroup/Add/">
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
        	{for $Node in $Nodes}
            <tr>
            	<td><code>{$Node[$NodeType.node_type_name . '_id']}</code></td>
                <td> <a href="{#TEMPLATE_BASE}MenuGroup/listmenu/{$Node[$NodeType.node_type_name . '_id']}/">{$Node[$NodeType.node_type_name . '_title']}</a></td>
                <td class="Item_Featured">
                	<span class="glyphicon glyphicon-plus"></span>&nbsp;
                    <a href="{#TEMPLATE_BASE}Menu/Add/{$Node[$NodeType.node_type_name . '_id']}/">Thêm</a>&nbsp;&nbsp;&nbsp;&nbsp;
                	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                    <a href="{#TEMPLATE_BASE}{$CTL_ACTION}/Edit/{$Node[$NodeType.node_type_name . '_id']}/">Sửa</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                    <a href="{#TEMPLATE_BASE}{$CTL_ACTION}/Remove/{$Node[$NodeType.node_type_name . '_id']}/">Xóa</a>
                </td>
            </tr>
            {/for}
        </tbody>
    </table>
</div>