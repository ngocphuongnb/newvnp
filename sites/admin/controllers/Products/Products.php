<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');
define('PRODUCT_BASE', Router::BasePath() . '/Products/');
require BASE_PATH . 'admin/controllers/Node/Node.php';

class Products extends Node
{
	private $AllowedActions = array('Add', 'Edit', 'Remove');
	private $ActionName = '';
	public function __construct() {
		Helper::State('Sản phẩm', PRODUCT_BASE);
	}
	
	private function GetNodeType($NodeTypeID) {
		if($this->NodeTypeID == 0) {
			$this->NodeTypeID = $NodeTypeID;	
			$GetNodeProduct = DB::Query('node_type', '', DB::Slave())
								->Where('node_type_id', '=', $this->NodeTypeID)
								->Cache(APP_CACHE_PATH)
								->Get();
			if($GetNodeProduct->status && $GetNodeProduct->num_rows == 1) {
				$this->NodeType = $GetNodeProduct->Result[0];
			}
		}
	}
	
	private function DetectSubAction($Params = array(), $FormAction = '') {
		$ActionKeys = array_keys($Params);
		if(isset($ActionKeys[0]) && in_array($ActionKeys[0], $this->AllowedActions)) {
			$this->$ActionKeys[0]($Params, $FormAction);
			return false;
		}
		return true;
	}
	
	public function _main($Params) {
		$this->GetNodeType(6);
		Theme::AddCssComponent('Tables,Navbar');
		Theme::SetTitle($this->NodeType['node_type_title']);
		Helper::Header('Danh sách ' . $this->NodeType['node_type_title']);
		Helper::State('Danh sách sản phẩm',PRODUCT_BASE);
		$TableName = $this->NodeType['node_type_name'];
		$Nodes = DB::Query($TableName, USER_DOMAIN)
						->Columns(array($TableName . '_id', $TableName . '_title'))
						->Limit(10)
						->Get($TableName . '_id', Output::Paging())->Result;
		$Node = TPL::File('list_nodes');
		$Node->Assign('Nodes', $Nodes);
		$Node->Assign('NodeType', $this->NodeType);
		$Node->Assign('CTL_ACTION', 'Action');
		Theme::$Body = $Node->Output();
	}
	
	public function Action($Params) {
		$this->GetNodeType(6);
		if($this->DetectSubAction($Params, PRODUCT_BASE . 'Action/Add/'))
			$this->_main();
	}
	
	public function Category($Params) {
		
		$this->GetNodeType(4);
		if($this->DetectSubAction($Params, PRODUCT_BASE . 'Category/Add/'))
		{
			Theme::AddCssComponent('Tables,Navbar');
			Theme::SetTitle($this->NodeType['node_type_title']);
			Helper::Header($this->NodeType['node_type_title']);
			Helper::State('Danh mục sản phẩm',PRODUCT_BASE . 'Category/');
			$TableName = $this->NodeType['node_type_name'];
			$Nodes = DB::Query($TableName, USER_DOMAIN)
							->Columns(array($TableName . '_id', $TableName . '_title'))
							->Limit(10)
							->Get($TableName . '_id', Output::Paging())->Result;
			$Node = TPL::File('list_nodes');
			$Node->Assign('Nodes', $Nodes);
			$Node->Assign('NodeType', $this->NodeType);
			$Node->Assign('CTL_ACTION', Loader::$Working['action']);
			Theme::$Body = $Node->Output();
		}
	}
	
	public function Group($Params) {
		$this->GetNodeType(5);
		if($this->DetectSubAction($Params, PRODUCT_BASE . 'Group/Add/'))
		{
			Theme::AddCssComponent('Tables,Navbar');
			Theme::SetTitle($this->NodeType['node_type_title']);
			Helper::Header($this->NodeType['node_type_title']);
			Helper::State('Nhóm sản phẩm',PRODUCT_BASE . 'Group/');
			$TableName = $this->NodeType['node_type_name'];
			$Nodes = DB::Query($TableName, USER_DOMAIN)
							->Columns(array($TableName . '_id', $TableName . '_title'))
							->Limit(10)
							->Get($TableName . '_id', Output::Paging())->Result;
			$Node = TPL::File('list_nodes');
			$Node->Assign('Nodes', $Nodes);
			$Node->Assign('NodeType', $this->NodeType);
			$Node->Assign('CTL_ACTION', Loader::$Working['action']);
			Theme::$Body = $Node->Output();
		}
	}
	
	private function Add($Params, $FormAction) {
		
		if(Loader::$Working['action'] == 'Action') {
			Helper::State('Danh sách sản phẩm',PRODUCT_BASE);
			Helper::State('Thêm sản phẩm ', PRODUCT_BASE . 'Action/Add/');
			Theme::SetTitle('Thêm sản phẩm');
			Helper::Header('Thêm sản phẩm');
		}
		elseif(Loader::$Working['action'] == 'Category') {
			Helper::State('Danh mục sản phẩm',PRODUCT_BASE . 'Category/');
			Helper::State('Thêm danh mục sản phẩm ', PRODUCT_BASE . 'Category/Add/');
			Theme::SetTitle('Thêm danh mục sản phẩm');
			Helper::Header('Thêm danh mục sản phẩm');
		}
		elseif(Loader::$Working['action'] == 'Group') {
			Helper::State('Nhóm sản phẩm',PRODUCT_BASE . 'Group/');
			Helper::State('Thêm nhóm sản phẩm ', PRODUCT_BASE . 'Group/Add/');
			Theme::SetTitle('Thêm nhóm sản phẩm');
			Helper::Header('Thêm nhóm sản phẩm');
		}
		
		Theme::UseJquery();
		Boot::library('Editor,Form');
		Theme::AddCssComponent('Forms,InputGroups,Tables,ButtonGroups');
		
		/**** Prepare Node fields for output form and input data normalization ****/		
		$NodeFields = $this->GetNodeFields(APP_CACHE_PATH);
		$_NodeFields = array();
		foreach($NodeFields as $Field) {
			if($Field['node_field_type'] == 'multi_value' && !empty($Field['default']))
				$Field['default'] = unserialize($Field['default']);
			$_NodeFields[$Field['node_field_name']] = $Field;
		}		
		$NodeFields = $_NodeFields;
		
		$NodeData = array();
		if(Input::Post('Add_Node') == $this->NodeTypeID)
		{
			$NodeData = Input::Post('Node');
			$FieldsValue = $this->NodeFieldNormalization($NodeData,$NodeFields);
			if($FieldsValue !== false)
			{
				$FieldsValue['add_time'] = CURRENT_TIME;
				$TableName = $this->NodeType['node_type_name'];
				$_I = DB::Query($TableName, USER_DOMAIN)->Insert($FieldsValue);
				if($_I->status && $_I->insert_id > 0) {
					Helper::Notify('success', 'Add node ok!');
				}
				else Helper::Notify('error', 'Add node error!');
			}
		}
		
		$AddNodeForm = Form::Create('Add_Node_' . $this->NodeType['node_type_name']);
		$AddNodeForm = $this->PrepareForm($AddNodeForm, $NodeFields, $NodeData, USER_CACHE_PATH, USER_DOMAIN);
		
		$Node = TPL::File('add_node');
		$Node->Assign('FormAction', $FormAction);
		$Node->Assign('NodeType', $this->NodeType);
		$Node->Assign('Form', $AddNodeForm->Output());
		Theme::$Body = $Node->Output();
	}
	
	private function Edit($Params, $FormAction)
	{
		$NodeID = $Params['Edit'];
		
		if(Loader::$Working['action'] == 'Action') {
			Helper::State('Danh sách sản phẩm',PRODUCT_BASE);
			Helper::State('Sửa sản phẩm ', PRODUCT_BASE . 'Action/Add/');
			Theme::SetTitle('Sửa sản phẩm');
			Helper::Header('Sửa sản phẩm');
		}
		elseif(Loader::$Working['action'] == 'Category') {
			Helper::State('Danh mục sản phẩm',PRODUCT_BASE . 'Category/');
			Helper::State('Sửa danh mục sản phẩm ', PRODUCT_BASE . 'Category/Add/');
			Theme::SetTitle('Sửa danh mục sản phẩm');
			Helper::Header('Sửa danh mục sản phẩm');
		}
		elseif(Loader::$Working['action'] == 'Group') {
			Helper::State('Nhóm sản phẩm',PRODUCT_BASE . 'Group/');
			Helper::State('Sửa nhóm sản phẩm ', PRODUCT_BASE . 'Group/Add/');
			Theme::SetTitle('Sửa nhóm sản phẩm');
			Helper::Header('Sửa nhóm sản phẩm');
		}
		
		Theme::UseJquery();
		Boot::library('Editor,Form');
		Theme::AddCssComponent('Forms,InputGroups,Tables,ButtonGroups');
		
		/**** Prepare Node fields for output form and input data normalization ****/
		$NodeFields = $this->GetNodeFields(APP_CACHE_PATH);
		$_NodeFields = array();
		foreach($NodeFields as $Field)
		{
			if($Field['node_field_type'] == 'multi_value' && !empty($Field['default']))
				$Field['default'] = unserialize($Field['default']);
			$_NodeFields[$Field['node_field_name']] = $Field;
		}		
		$NodeFields = $_NodeFields;
		
		DB::BackUpPrefix();
		$TableName = $this->NodeType['node_type_name'];
		$NodeData = DB::Query($TableName, USER_DOMAIN)->Where($TableName . '_id', '=', $NodeID)->Get();
		
		if($NodeData->num_rows == 1) {
			$NodeData = $NodeData->Result[0];
			unset($NodeData[$TableName . '_id']);
			$NodeData = $this->DataTrueForm($NodeData,$NodeFields);
			if(Input::Post('Add_Node') == $this->NodeTypeID)
			{
				$NodeData = Input::Post('Node');
				$FieldsValue = $this->NodeFieldNormalization($NodeData,$NodeFields);
				if($FieldsValue !== false)
				{
					$FieldsValue['edit_time'] = CURRENT_TIME;
					$_I = DB::Query($TableName)
								->Where($TableName . '_id', '=', $NodeID)
								->Update($FieldsValue);
					if($_I->status)
						Helper::Notify('success', 'Update node ok!');
					else Helper::Notify('error', 'Update node error!');
				}
			}
			$AddNodeForm = Form::Create('Add_Node_' . $this->NodeType['node_type_name']);
			DB::RestorePrefix();
			$AddNodeForm = $this->PrepareForm($AddNodeForm, $NodeFields, $NodeData, USER_CACHE_PATH, USER_DOMAIN);
			
			$Node = TPL::File('add_node');
			$Node->Assign('FormAction', PRODUCT_BASE . Loader::$Working['action'] . '/Edit/' . $NodeID . '/');
			$Node->Assign('NodeType', $this->NodeType);
			$Node->Assign('Form', $AddNodeForm->Output());
			Theme::$Body = $Node->Output();
		}
		else Helper::Notify('error', 'Node not found!');
	}
	
	private function Remove($Params, $FormAction)
	{
		$NodeID = $Params['Remove'];
		
		$ShowConfirmForm = false;
		if(Loader::$Working['action'] == 'Action') {
			Helper::State('Danh sách sản phẩm',PRODUCT_BASE);
			Helper::State('Xóa sản phẩm ', PRODUCT_BASE . 'Action/Add/');
			Theme::SetTitle('Xóa sản phẩm');
			Helper::Header('Xóa sản phẩm');
		}
		elseif(Loader::$Working['action'] == 'Category') {
			Helper::State('Danh mục sản phẩm',PRODUCT_BASE . 'Category/');
			Helper::State('Xóa danh mục sản phẩm ', PRODUCT_BASE . 'Category/Add/');
			Theme::SetTitle('Xóa danh mục sản phẩm');
			Helper::Header('Xóa danh mục sản phẩm');
		}
		elseif(Loader::$Working['action'] == 'Group') {
			Helper::State('Nhóm sản phẩm',PRODUCT_BASE . 'Group/');
			Helper::State('Xóa nhóm sản phẩm ', PRODUCT_BASE . 'Group/Add/');
			Theme::SetTitle('Xóa nhóm sản phẩm');
			Helper::Header('Xóa nhóm sản phẩm');
		}
		Theme::AddCssComponent('Forms,Buttons,Panels');
		
		$TableName = $this->NodeType['node_type_name'];
		
		$GetNode = DB::Query($TableName, USER_DOMAIN)->Where($TableName . '_id', '=', $NodeID)->Get();
		if($GetNode->num_rows == 1)
		{
			$Node = $GetNode->Result[0];
			if(Input::Post('NodeID') == $NodeID)
			{
				$RemoveNode = DB::Query($TableName)
									->Where($TableName . '_id', '=', $NodeID)->Delete();
				if($RemoveNode->status && $RemoveNode->affected_rows == 1)
				{
					Helper::Notify('success', 'Success, Redirecting to Node list...');
					header('Refresh: 1.0; url=' . PRODUCT_BASE . Loader::$Working['action'] . '/');
				}
				else
				{
					Helper::Notify('error', 'Cannot remove this Node!');
					$ShowConfirmForm = true;
				}
			}
			else $ShowConfirmForm = true;
			
			if($ShowConfirmForm)
			{
				$FormAction = PRODUCT_BASE . Loader::$Working['action'] . '/Remove/' . $NodeID . '/';
				$ConfirmString = '
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Confirm delete this Node type?</h3>
					</div>
					<div class="panel-body">
						<form method="post" action="' . $FormAction . '">
							<input type="hidden" value="' . $NodeID . '" name="NodeID" />
							<a href="javascript:window.history.go(-1); return false;" class="btn btn-default">Cancel</a>&nbsp;&nbsp;
							<input type="submit" class="btn btn-danger" value="Confirm" />
						</form>
					</div>
				</div>';
				Theme::$Body = $ConfirmString;
			}
		}
		else Helper::Notify('error', 'Node not found!');
	}
}

?>