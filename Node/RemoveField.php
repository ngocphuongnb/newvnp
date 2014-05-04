<?php
    echo 'Removed Field : <strong>', $_GET['FieldName'],'</strong>';
    $xml_obj->RebuildXML('remove','RemoveField', array('NodeTypeName'=>$_GET['NodeTypeName'],'FieldName'=>$_GET['FieldName']));
?>