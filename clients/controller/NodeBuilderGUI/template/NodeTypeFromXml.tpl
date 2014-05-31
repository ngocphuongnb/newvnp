<div class="table-responsive">
	<form action="" method="post">
    	<input type="hidden" name="RescanNodeTypes" value="1" />
        <p>
            <button type="submit" class="btn btn-success">
                <span class="glyphicon glyphicon-refresh"></span>&nbsp;Rescan NodeTypes
            </button>
      	</p>
    </form>
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-2">
        <col class="col-xs-2">
        <col class="col-xs-3">
        <col class="col-xs-5">
        </colgroup>
        <thead>
            <tr>
                <th><strong>Node type name</strong></th>
                <th><strong>Author</strong></th>
                <th><strong>Note require</strong></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	{for $NodeType in $NodeTypes as $NodeTypeName}
        	<tr>
            	<td>{$NodeType.NodeTypeInfo.title}</td>
                <td>{$NodeType.NodeTypeInfo.author}</td>
                <td>{$NodeType.NodeTypeInfo.require.node_type}</td>
                <td>
                	<a href="{#NODE_UTILITY_BASE_URL}InsertRow/{$NodeTypeName}/"><span class="glyphicon glyphicon-plus"></span>&nbsp;Insert</a>&nbsp;&nbsp;
                	<a href="#"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a>&nbsp;&nbsp;
                	<a href="{$StructureUrl}Structure/{$NodeTypeName}/"><span class="glyphicon glyphicon-certificate"></span>&nbsp;Structure</a>&nbsp;&nbsp;
                    <a href="#"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Browse</a>&nbsp;&nbsp;
                    <a href="#"><span class="glyphicon glyphicon-trash"></span>&nbsp;Empty</a>&nbsp;&nbsp;
                   	<a href="#"><span class="glyphicon glyphicon-minus-sign"></span>&nbsp;Drop</a>
              	</td>
          	</tr>
            {/for}
     	</tbody>
	</table>
</div>