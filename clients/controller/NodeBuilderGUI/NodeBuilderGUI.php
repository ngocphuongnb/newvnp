<?php

Boot::Library('NodeBuilder');

class NodeBuilderGUI extends Controller {
	public $NodeBuilder;
	public function __construct() {
		NodeBuilder::$NodeBuilderCachePath = CACHE_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR;
		$this->NodeBuilder = new NodeBuilder();
	}
	public function Main() {
		$XmlPath = DATA_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR . 'default_article.xml';
		$this->NodeBuilder->LoadXmlNodeFile($XmlPath);
		//n($this->NodeBuilder->NodeTypes);
		$v = $this->View('NodeTypeFromXml');
		echo $v->Output();
		File::CreateFile('E:\vnp\source\newvnp\clients\data\NodeBuilder\default_article.xml');
	}
	public function XmlFiles() {
		$NodeTypeXmlFiles = glob(DATA_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR . 'default_*.xml');
		$x = $this->View('XmlFiles');
		$x->Assign('XmlFiles', $NodeTypeXmlFiles);
		$x->Output();
	}
	public function ListNodeTypes() {
		$NodeTypeXmlFiles = glob(DATA_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR . 'default_*.xml');
		$NodeTypes = array();
		foreach($NodeTypeXmlFiles as $XmlFile) {
			n($XmlFile);
		}
	}
	private function ListAllNodeTypeFiles() {
		
	}
}

?>