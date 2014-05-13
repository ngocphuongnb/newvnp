<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-2">
        <col class="col-xs-6">
        <col class="col-xs-2">
        </colgroup>
        <thead>
            <tr>
            	<th><strong>IF</strong></th>
                <th><strong>Label</strong></th>
                <th><strong>Name</strong></th>
                <th><strong>Type</strong></th>
                <th><strong>R</strong></th>
                <th><strong>Filter</strong></th>
                <th><strong>Default value</strong></th>
                <th><strong>DB Type</strong></th>
                <th><strong>DB Length</strong></th>
                <th><strong>Collation</strong></th>
                <th><strong>Actions</strong></th>
            </tr>
        </thead>
        <tbody>
        	{for $NodeField in $NodeType.NodeFields}
            <tr>
            	<td><span class="glyphicon glyphicon-{if($NodeField.inform == -1)}remove{else}ok{/if}"></span></td>
            	<td><a href="{$EditFieldUrl}{$NodeField.name}/">{$NodeField.label}</a></td>
                <td>{$NodeField.name}</td>
                <td>{$NodeField.type}</td>
                <td><span class="glyphicon glyphicon-{if($NodeField.require == -1)}remove{else}ok{/if}"></span></td>
                <td>{$NodeField.filter}</td>
                <td>{$NodeField.value}</td>
                <td>{if(isset($NodeField.db_config.type))}{$NodeField.db_config.type}{/if}</td>
                <td>{if(isset($NodeField.db_config.length))}{$NodeField.db_config.length}{/if}</td>
                <td>{if(isset($NodeField.db_config.collation))}{$NodeField.db_config.collation}{/if}</td>
                <td>
                	<a href="{$EditFieldUrl}{$NodeField.name}/"><span class="glyphicon glyphicon-edit"></span>&nbsp;Change</a>&nbsp;&nbsp;
                   	<a href="#"><span class="glyphicon glyphicon-minus-sign"></span>&nbsp;Drop</a>
              	</td>
            </tr>
            {/for}
        </tbody>
 	</table>
</div>
