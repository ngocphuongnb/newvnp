<link rel="stylesheet" type="text/css" href="node.css" />
<meta charset="utf-8" />
<a href="http://localhost/test/Node/index.php">Home</a><br /><br />
<?php
    include 'class/NodeConfig.php';
    $xml_obj = new NodeConfig('default.xml');
    //$xml_obj->xml();
    //$xml_boj->connect('default.xml');
    
    $NodeTypes = $xml_obj->xml->getElementsByTagName('NodeType');
    
    if(!isset($_GET['action']))
    {
        include 'NodeTypeHome.php';
    }
    else
    {
        
        include $_GET['action'].'.php';
    }
    	
