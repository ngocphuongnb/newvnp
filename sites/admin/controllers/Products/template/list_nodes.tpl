<!--<nav class="navbar navbar-default" role="navigation">
    <ul class="nav navbar-nav">
        <li>
            <a href="{#NODE_BASE}Manage/{$NodeType.node_type_id}/add/">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Add node
            </a>
        </li>
 	</ul>
</nav>-->
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
        	{for $Node in $Nodes}
            <tr>
            	<td><code>{$Node[$NodeType.node_type_name . '_id']}</code></td>
                <td>{$Node[$NodeType.node_type_name . '_title']}</td>
                <td class="Item_Featured">
                	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                    <a href="{#PRODUCT_BASE}{$CTL_ACTION}/Edit/{$Node[$NodeType.node_type_name . '_id']}/">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                    <a href="{#PRODUCT_BASE}{$CTL_ACTION}/Remove/{$Node[$NodeType.node_type_name . '_id']}/">Remove</a>
                </td>
            </tr>
            {/for}
        </tbody>
    </table>
</div>