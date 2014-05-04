<?php
    $result = $xml_obj->Rebuild($_GET['NodeName']);
	if($result) echo 'Success Add Node and Rebuid talbe : <strong>', $_GET['NodeName'],'</strong>'; else echo 'Failed Add Node';
?>