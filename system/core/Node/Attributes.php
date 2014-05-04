<?php

/**
 * Attributes Class
 *
 * Boot up an application, detect running environment
 *
 * @package		VNP
 * @subpackage	Ndde
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Boot.html
 */
 
namespace Node\Attributes;
if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Attributes
{
	const INT		= 'interger';
	const FLOAT		= 'float';
	const STRING	= 'string';
	const SHORTTEXT	= 'shorttext';
	const TEXT		= 'text';
	const LONGTEXT	= 'longtext';
	
	private $Attribute = array(	'name'			=> '',
								'type'			=> '',
								'length'		=> '',
								'collation'		=> '',
								'attributes'	=> '',
								'null'			=> 'NOT NULL',
								'default'		=> ''
								);
	
	public function Name($AttrName)
	{
		$this->Attribute['name'] = $AttrName;
		return $this;
	}
	
	public function Type($AttrType)
	{
		$this->Attribute['type'] = $AttrType;
		return $this;
	}
	
	public function Length($AttrLength)
	{
		$this->Attribute['length'] = $AttrLength;
		return $this;
	}
	
	public function DefaultValue($AttrDefault)
	{
		$this->Attribute['default'] = $AttrDefault;
		return $this;
	}
	
	public function Null($AttrNull)
	{
		$this->Attribute['null'] = $AttrNull;
		return $this;
	}
}

?>