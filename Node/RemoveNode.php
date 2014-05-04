
<?php
	$result = $xml_obj->RemoveNode($_GET['NodeName']);
    $xml_obj->RebuildXML('remove','NodeType', $_GET['NodeName']);
    echo 'Success Remove Node';
?>