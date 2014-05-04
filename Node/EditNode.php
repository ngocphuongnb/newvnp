<?php 
    if(isset($_POST['SaveNodeTypeSubmit']))
    {
        echo '<p style="font-weight:bold;color:green">Success</p>';
        $xml_obj->RebuildXML('edit','EditNode', array('Label'=>$_POST['Label']));
    }
?> 

<?php
    ///$xml_obj->xml = $xml_obj->load('default.xml');
	$xpath = new DOMXPath($xml_obj->xml);
    $NodeName = $_GET['NodeName'];
    $CurrentNode = $xpath->query("//*[@name='$NodeName']")->item(0);
    $label = $CurrentNode->getElementsByTagName('Label')->item(0);
    
?>

<div class="col-xs-12 col-md-8 box" id="main-board">

                    
	<div class="page-header">
		<h1>Edit Node type: <?php echo $NodeName; ?>&nbsp;<small></small></h1>
	</div><br />
                                       	
    <form class="form-horizontal" role="form" method="post" action="">
	
        <input name="AddNodeType" value="1" type="hidden" />
        
        <div class="form-group">
            <label for="NodeType_name" class="col-sm-2 control-label">Node type name : </label>
            
                <input type="text" readonly="readonly" class="form-control" name="NodeType[node_type_name]" id="NodeType_name" value="<?php echo $CurrentNode->getAttribute('name') ?>" placeholder="Node type name">
            
        </div><br />
        <div class="form-group">
            <label for="NodeType_title" class="col-sm-2 control-label">Node type title :</label>
            
                <input type="text" class="form-control" name="Label" id="NodeType_title" placeholder="Node type title" value="<?php echo $label->nodeValue; ?>" />
            
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input  type="submit" name="SaveNodeTypeSubmit" class="btn btn-primary" value="Save" />
            </div>
        </div>
    </form>
</div>