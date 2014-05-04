<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-2">
        <col class="col-xs-6">
        <col class="col-xs-4">
        </colgroup>
        <thead>
            <tr>
                <th>Node type name</th>
                <th>Node type title</th>
                <th>Featured</th>
            </tr>
        </thead>
        <tbody>
        	{for $nt in $NodeType}
            <tr>
            	<td><code>{$nt.node_type_name}</code></td>
                <td>{$nt.node_type_title}</td>
                <td class="Item_Featured">
                	<span class="glyphicon glyphicon-th-list"></span>&nbsp;
                    <a href="{#NODE_BASE}Manage/{$nt.node_type_id}/list/">List</a>&nbsp;&nbsp;&nbsp;&nbsp;
                	<span class="glyphicon glyphicon-plus"></span>&nbsp;
                    <a href="{#NODE_BASE}Manage/{$nt.node_type_id}/add/">Add</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-comment"></span>&nbsp;
                    <a href="{#NODE_BASE}Manage/{$nt.node_type_id}/comment/">Comments</a>&nbsp;
                    <span class="glyphicon glyphicon-th"></span>&nbsp;
                    <a href="{#NODE_BASE}Manage/{$nt.node_type_id}/view/">View maker</a>
                </td>
            </tr>
            {/for}
        </tbody>
    </table>
</div>
