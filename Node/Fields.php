<?php 
    if(isset($_POST['submit']))
    {
        echo '<p style="font-weight:bold;color:green">Success</p>';
        $xml_obj->RebuildXML('AddField','', array('FieldName'=>$_POST['FieldName'],'Label'=>$_POST['Label'],'FieldType'=>$_POST['FieldType'],'Value'=>$_POST['Value'],'MaxLengh'=>$_POST['MaxLengh']));
    }
?> 



<div class="col-xs-12 col-md-8 box" id="main-board">     
	<div class="page-header">
        <?php 
            $NodeType = $xml_obj->NodeTypes[$_GET['id']]; 
            $NodeTypes = $xml_obj->NodeTypes;    
        ?>
		<h1>Node type: <?php echo $NodeType['label'] ?></h1>
	</div>  <br />
                                      	
    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group">
             <a href="?action=Rebuild&NodeName=<?php echo $_GET['NodeName']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-refresh"></i> Rebuild table</a>
        </div>
    </div><br />
<div class="clearfix"></div>
<form method="POST" action="">
	<input type="hidden" value="1" name="NodeField[node_type_id]" />
    <div class="input-group">
        
        <input type="text" name="FieldName" class="form-control" placeholder="Field name" />
        <input type="text" name="Value" class="form-control" placeholder="Value" />
        <input type="text" name="MaxLengh" class="form-control" placeholder="Maxlengh" />
        <input type="text" name="Label" class="form-control" placeholder="Title" />
        
        <select class="form-control" name="FieldType">
            <option value="text">text</option>
            <option value="title">title</option>
            <option value="number">number</option>
            <option value="textarea">textarea</option>
            <option value="image">image</option>
            <option value="multi_image">multi_image</option>
            <option value="html">html</option>
            <option value="single_value">single_value</option>
            <option value="multi_value">multi_value</option>
            <option value="file">file</option>
            <option value="hidden">hidden</option>
            <option value="referer">referer</option>
            <option value="meta_title">meta_title</option>
            <option value="meta_description">meta_description</option>
            <option value="attribute">attribute</option>
        </select>
        
            <input value="Add field" name="submit" class="btn btn-primary" type="submit" />
        
    </div>
</form>
<br />
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        	<col class="col-xs" />
            <col class="col-xs" />
            <col class="col-xs-1" />
            <col class="col-xs-1" />
            <col class="col-xs-2" />
            <col class="col-xs" />
            <col class="col-xs" />
            <col class="col-xs" />
            <col class="col-xs-2" />
        </colgroup>
        <thead>
            <tr>
            	
                <th>Field name</th>
                <th>Field type</th>
                <th>Field title</th>
                <th>Length</th>
                <th>Require</th>
                <th>Stt</th>
                <th>Featured</th>
            </tr>
        </thead>
        <tbody id="NodeField_List" class="ui-sortable">
            <?php 
                $i = 1;
            ?>
            <tr class="NodeField_Item" data-field-id="<?php echo $i; ?>">
        
            <?php 
                
                
                $fields = $NodeType['field'];
                foreach($fields as $field) 
                {
                    ?>
                <td><?php echo $field['name'] ?></td>
                <td><?php echo $field['type'] ?></td>
                <td>
                    <?php 
                        echo $field['Label']
                    ?>
                </td>
                <td>
                    <?php 
                        echo $field['MaxLengh']
                    ?>
                </td>
                
                <td>
                    
                </td>
                
                <td>
                    
                </td>
                
                <td class="Item_Featured">
                	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                    <a href="?NodeTypeName=<?php echo $_GET['NodeName']; ?>&action=EditField&FieldName=<?php echo $field['name'] ?>">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                    <a href="?NodeTypeName=<?php echo $_GET['NodeName']; ?>&action=RemoveField&FieldName=<?php echo $field['name'] ?>">Remove</a>
                </td>
            </tr>                  
                    <?php
                    $i++;
                }
            ?>


        </tbody>
    </table>
</div>                                    </div>
        