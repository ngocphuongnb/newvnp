<div class="table-responsive">
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
        	<?php foreach($NodeTypes as $NodeTypeName => $NodeType) { ?>
        	<tr>
            	<td><?php echo $NodeType['NodeTypeInfo']['title'] ?></td>
                <td><?php echo $NodeType['NodeTypeInfo']['author'] ?></td>
                <td><?php echo $NodeType['NodeTypeInfo']['require']['node_type'] ?></td>
                <td>
                	<a href="#"><span class="glyphicon glyphicon-plus"></span>&nbsp;Insert</a>&nbsp;&nbsp;
                	<a href="#"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a>&nbsp;&nbsp;
                	<a href="<?php echo $StructureUrl ?>Structure/<?php echo $NodeTypeName ?>/"><span class="glyphicon glyphicon-certificate"></span>&nbsp;Structure</a>&nbsp;&nbsp;
                    <a href="#"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Browse</a>&nbsp;&nbsp;
                    <a href="#"><span class="glyphicon glyphicon-trash"></span>&nbsp;Empty</a>&nbsp;&nbsp;
                   	<a href="#"><span class="glyphicon glyphicon-minus-sign"></span>&nbsp;Drop</a>
              	</td>
          	</tr>
            <?php } ?>
     	</tbody>
	</table>
</div>