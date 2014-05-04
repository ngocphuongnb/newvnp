<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
            <col class="col-xs-2" />
            <col class="col-xs-6" />
            <col class="col-xs-3" />
        </colgroup>
        <thead>
            <tr>
                <th>Node type name</th>
                <th>Node type title</th>
                <th>Featured</th>
            </tr>
        </thead>
        <tbody>
        <?php  
            $NodeTypes = $xml_obj->NodeTypes;
            //h($NodeTypes);
            $i=0;
            if(!empty($NodeTypes))
            {
                foreach($NodeTypes as $NodeType)
                {
                    ?>
                    <tr>
                    	<td><code><?php  echo $NodeType['name'] ?></code></td>
                        <td><?php echo $NodeType['label'] ?></td>
                        <td class="Item_Featured">
                        	<span class="glyphicon glyphicon-list-alt"></span>&nbsp;
                            <a href="?NodeName=<?php echo $NodeType['name'] ?>&action=Fields&id=<?php echo $i; ?>">Fields</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                            <a href="?NodeName=<?php echo $NodeType['name'] ?>&action=EditNode&id=<?php echo $i; ?>">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="glyphicon glyphicon-remove"></span>&nbsp;
                            <a href="?NodeName=<?php echo $NodeType['name'] ?>&action=RemoveNode">Remove</a>
                        </td>
                    </tr>                               
                    <?php
                    $i++;
                }
            }
            else echo '<p style="color:#ff0000">No NodeType to display</p>';
            
        ?>



        </tbody>
    </table>
</div>