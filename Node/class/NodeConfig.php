<?php
	class NodeConfig
    { 
        public function __construct($xml_file)
        {
            $xml_connect = new DOMDocument();
            $xml_connect->load($xml_file);
            $this->xml = $xml_connect;
            $moment = $this->xml->getElementsByTagName('NodeType');
            $i = 0;
            
            $this->connect_database = @new mysqli('localhost', 'root', '123', 'nodetype');
            if($this->connect_database->connect_errno) die('Cannot connect to database :<strong> ' .$this->connect_database->connect_error. '</strong>');
            
            foreach($moment as $s_moment)
            {
                
                $this->NodeTypes[$i]['name'] = $s_moment->getAttribute('name');                
                $this->NodeTypes[$i]['label'] = $s_moment->getElementsByTagName('Label')->item(0)->nodeValue;
                $fields = $s_moment->getElementsByTagName('Field');
                $j = 0;
                foreach($fields as $s_fields)
                {
                    $this->NodeTypes[$i]['field'][$j]['name'] = $s_fields->getAttribute('name');
                    $this->NodeTypes[$i]['field'][$j]['type'] = $s_fields->getAttribute('type');
                    
                    $elements = $s_fields->getElementsByTagName('*');
                    foreach($elements as $s_element)
                    {   
                        $this->NodeTypes[$i]['field'][$j][$s_element->tagName] = $s_element->nodeValue;
                    }
                    $j++;
                }
                
                $i++;
            }
        }
        

        
        public $connect_database;
           
        public $xml; // Load xml file;
        
        
        public $NodeTypes; // Array that contain all NodeType tag and which inside it;
        
        public function Rebuild($NodeName)
        {
            $xpath = new DOMXPath($this->xml);
            $CurrentNode = $xpath->query("//*[@name='$NodeName']")->item(0);
            $TableName = $CurrentNode->getAttribute('name');
            $fields = $CurrentNode->getElementsByTagName('Field');
           
            
            $TableContent = 'id INT NOT NULL PRIMARY KEY AUTO_INCREMENT';
            foreach($fields as $field)
            {
                switch($field->getAttribute('type'))
                {
                    case 'text' : 
                    $TableContent = $TableContent.', '.$field->getAttribute('name').' VARCHAR(255)';
                    break;
                    
                    case 'html' : 
                    $TableContent = $TableContent.', '.$field->getAttribute('name').' TEXT';
                    break;
                    
                    case 'image' : 
                    $TableContent = $TableContent.', '.$field->getAttribute('name').' VARCHAR(255)';
                    break;
                    
                    case 'dynamic' : 
                    $TableContent = $TableContent.', '.$field->getAttribute('name').' VARCHAR(255)';
                    break;
                }
            }
            $moment = "CREATE TABLE IF NOT EXISTS $TableName($TableContent)";
            
            $result = $this->connect_database->query($moment);
            foreach($fields as $field)
            {
                $field_value = $field->nodeValue;
                $field_name = $field->getAttribute('name');
                $field_type = $field->getAttribute('type');
                $moment = "ALTER TABLE $TableName ADD COLUMN  $field_name VARCHAR(255)";
                $this->connect_database->query($moment);
            }
            
            
            return $result;
        }
        
        
        public function RemoveNode($NodeName)
        {
            $moment = "DROP TABLE $NodeName";
            $result = $this->connect_database->query($moment);
            
            $date = date('d-m-Y');
            $resource = $this->xml;
            $resource->load('default.xml');
             
            //Backup xml File
            for($i=0;;$i++)
            {
                if(!file_exists('default-'.$date.'-'.$i.'.xml'))
                {
                    $resource->save('default-'.$date.'-'.$i.'.xml');
                    break;
                }
            }
            
            
            //Create new xml File
            $NodeType = $this->xml->getElementsByTagName('NodeTypes')->item(0);
            $resource_NodeTypes = $this->xml->getElementsByTagName('NodeType');
           
            foreach($resource_NodeTypes as $resource_NodeType)
            {
                if($resource_NodeType->getAttribute('name')==$NodeName)
                {
                    $NodeType->removeChild($resource_NodeType);
                }
                
            }
            $this->xml->save('default.xml') or die('Error to Save File XML');
            
            return $result;
        }
        
        public function RebuildXML($type, $target, $id)
        {
            if($type=='remove')
            {
                if($target=='RemoveField')
                {
                    
                    $date = date('d-m-Y');
                	$resource = $this->xml;
                    
                    //Backup xml File
                    $resource->load('default.xml');
                    for($i=0;;$i++)
                    {
                        if(!file_exists('default-'.$date.'-'.$i.'.xml'))
                        {
                            $resource->save('default-'.$date.'-'.$i.'.xml');
                            break;
                        }
                    }
                    
                    
                    
                   
                    //Create new xml File
                    $NodeTypes = $this->xml->getElementsByTagName('NodeType');
                    foreach($NodeTypes as $s_NodeTypes)
                    {
                        if($s_NodeTypes->getAttribute('name')==$id['NodeTypeName'])
                        {
                            $fields = $s_NodeTypes->getElementsByTagName('Field');
                            foreach($fields as $s_fields)
                            {
                                if($s_fields->getAttribute('name')==$id['FieldName'])
                                {
                                    $s_NodeTypes->removeChild($s_fields);
                                }
                            }
                        }
                    }
                    
                    
                    
                    $this->xml->save('default.xml') or die('Error');
                }
            }

                if($type=='edit')
                {
                    if($target=='EditNode')
                    {
                            $date = date('d-m-Y');
                        	$resource = $this->xml;
                            
                            //Backup xml File
                            $resource->load('default.xml');
                            for($i=0;;$i++)
                            {
                                if(!file_exists('default-'.$date.'-'.$i.'.xml'))
                                {
                                    $resource->save('default-'.$date.'-'.$i.'.xml');
                                    break;
                                }
                            }
                            
                            
                            
                           
                            //Create new xml File
                            $xpath = new DOMXPath($this->xml);
                            $NodeName = $_GET['NodeName'];
                            $CurrentNode = $xpath->query("//*[@name='$NodeName']")->item(0);
                            $label = $CurrentNode->getElementsByTagName('Label')->item(0);
                            $label->nodeValue = $id['Label'];
                            
                    
                    
                            
                            $this->xml->save('default.xml') or die('Error');
                    }
                }
                
                if($type == 'AddField')
                {
                    echo 'none';
                    $date = date('d-m-Y');
                	$resource = $this->xml;
                    
                    //Backup xml File
                    $resource->load('default.xml');
                    for($i=0;;$i++)
                    {
                        if(!file_exists('default-'.$date.'-'.$i.'.xml'))
                        {
                            $resource->save('default-'.$date.'-'.$i.'.xml');
                            break;
                        }
                    }
                    
                    
                    
                   
                    //Create new xml File
                    $xpath = new DOMXPath($this->xml);
                    $NodeName = $_GET['NodeName'];
                    $CurrentNode = $xpath->query("//*[@name='$NodeName']")->item(0);
                    $add = $this->xml->createElement('Field');
                    $new_add = $CurrentNode->appendChild($add);
                    
                    $new_add->setAttribute('type', $id['FieldType']);
                    $new_add->setAttribute('name', $id['FieldName']);
                    
                    $add = $this->xml->createElement('Label');
                    $new_child_field = $new_add -> appendChild($add);
                    $new_child_field->nodeValue = $id['Label'];
                    
                    $add = $this->xml->createElement('Value');
                    $new_child_field = $new_add -> appendChild($add);
                    $new_child_field->nodeValue = $id['Value'];
                    
                    $add = $this->xml->createElement('MaxLengh');
                    $new_child_field = $new_add -> appendChild($add);
                    $new_child_field->nodeValue = $id['MaxLengh'];
                    
                    $this->xml->save('default.xml') or die('Error');
                }
            
        }
    }
    
    
    
    
    function h($variable)
    {
        ?>
        <pre>
        <?php print_r($variable) ?>
        </pre>
        <?php
    }
    