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
        	<?php foreach($NodeType['NodeFields'] as $NodeField) { ?>
            <tr>
            	<td><span class="glyphicon glyphicon-<?php if($NodeField['inform'] == -1) { ?>remove<?php }else{ ?>ok<?php } ?>"></span></td>
            	<td><a href="<?php echo $EditFieldUrl ?><?php echo $NodeField['name'] ?>/"><?php echo $NodeField['label'] ?></a></td>
                <td><?php echo $NodeField['name'] ?></td>
                <td><?php echo $NodeField['type'] ?></td>
                <td><span class="glyphicon glyphicon-<?php if($NodeField['require'] == -1) { ?>remove<?php }else{ ?>ok<?php } ?>"></span></td>
                <td><?php echo $NodeField['filter'] ?></td>
                <td><?php echo $NodeField['value'] ?></td>
                <td><?php if(isset($NodeField['db_config']['type'])) { ?><?php echo $NodeField['db_config']['type'] ?><?php } ?></td>
                <td><?php if(isset($NodeField['db_config']['length'])) { ?><?php echo $NodeField['db_config']['length'] ?><?php } ?></td>
                <td><?php if(isset($NodeField['db_config']['collation'])) { ?><?php echo $NodeField['db_config']['collation'] ?><?php } ?></td>
                <td>
                	<a href="<?php echo $EditFieldUrl ?><?php echo $NodeField['name'] ?>/"><span class="glyphicon glyphicon-edit"></span>&nbsp;Change</a>&nbsp;&nbsp;
                   	<a href="#"><span class="glyphicon glyphicon-minus-sign"></span>&nbsp;Drop</a>
              	</td>
            </tr>
            <?php } ?>
        </tbody>
 	</table>
</div>
