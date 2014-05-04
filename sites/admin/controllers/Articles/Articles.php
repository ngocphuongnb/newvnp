<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');
define('ARTICLE_BASE', Router::BasePath() . '/Articles/');
require BASE_PATH . 'admin/controllers/Node/Node.php';
define('CTL_ACTION', ARTICLE_BASE . Loader::$Working['action'] . '/');

class Articles extends Node
{
	private $AllowedActions = array('Add', 'Edit', 'Remove');
	private $ActionName = '';
	public function __construct() {
		Helper::State('Bài viết', ARTICLE_BASE);
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
		$this->GetNodeType(3);
		Theme::AddCssComponent('Tables,Navbar');
		Theme::SetTitle($this->NodeType['node_type_title']);
		Helper::Header('Danh sách ' . $this->NodeType['node_type_title']);
		Helper::State('Danh sách bài viết',ARTICLE_BASE);
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
		$this->GetNodeType(3);
		if($this->DetectSubAction($Params, ARTICLE_BASE . 'Action/Add/'))
			$this->_main();
	}
	
	public function Category($Params) {
		
		$this->GetNodeType(1);
		if($this->DetectSubAction($Params, ARTICLE_BASE . 'Category/Add/'))
		{
			Theme::AddCssComponent('Tables,Navbar');
			Theme::SetTitle($this->NodeType['node_type_title']);
			Helper::Header($this->NodeType['node_type_title']);
			Helper::State('Chuyên mục bài viết',ARTICLE_BASE . 'Category/');
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
		$this->GetNodeType(2);
		if($this->DetectSubAction($Params, ARTICLE_BASE . 'Group/Add/'))
		{
			Theme::AddCssComponent('Tables,Navbar');
			Theme::SetTitle($this->NodeType['node_type_title']);
			Helper::Header($this->NodeType['node_type_title']);
			Helper::State('Nhóm bài viết',ARTICLE_BASE . 'Group/');
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
			Helper::State('Danh sách bài viết',ARTICLE_BASE);
			Helper::State('Thêm bài viết ', ARTICLE_BASE . 'Action/Add/');
			Theme::SetTitle('Thêm bài viết');
			Helper::Header('Thêm bài viết');
		}
		elseif(Loader::$Working['action'] == 'Category') {
			Helper::State('Chuyên mục bài viết',ARTICLE_BASE . 'Category/');
			Helper::State('Thêm chuyên mục bài viết ', ARTICLE_BASE . 'Category/Add/');
			Theme::SetTitle('Thêm chuyên mục bài viết');
			Helper::Header('Thêm chuyên mục bài viết');
		}
		elseif(Loader::$Working['action'] == 'Group') {
			Helper::State('Nhóm bài viết',ARTICLE_BASE . 'Group/');
			Helper::State('Thêm nhóm bài viết ', ARTICLE_BASE . 'Group/Add/');
			Theme::SetTitle('Thêm nhóm bài viết');
			Helper::Header('Thêm nhóm bài viết');
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
			Helper::State('Danh sách bài viết',ARTICLE_BASE);
			Helper::State('Sửa bài viết ', ARTICLE_BASE . 'Action/Edit/' . $this->NodeTypeID . '/');
			Theme::SetTitle('Sửa bài viết');
			Helper::Header('Sửa bài viết');
		}
		elseif(Loader::$Working['action'] == 'Category') {
			Helper::State('Danh mục bài viết',ARTICLE_BASE . 'Category/');
			Helper::State('Sửa danh mục bài viết ', ARTICLE_BASE . 'Category/Edit/' . $this->NodeTypeID . '/');
			Theme::SetTitle('Sửa danh mục bài viết');
			Helper::Header('Sửa danh mục bài viết');
		}
		elseif(Loader::$Working['action'] == 'Group') {
			Helper::State('Nhóm bài viết',ARTICLE_BASE . 'Group/');
			Helper::State('Sửa nhóm bài viết ', ARTICLE_BASE . 'Group/Edit/' . $this->NodeTypeID . '/');
			Theme::SetTitle('Sửa nhóm bài viết');
			Helper::Header('Sửa nhóm bài viết');
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
			$Node->Assign('FormAction', ARTICLE_BASE . Loader::$Working['action'] . '/Edit/' . $NodeID . '/');
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
			Helper::State('Danh sách bài viết',ARTICLE_BASE);
			Helper::State('Xóa bài viết ', ARTICLE_BASE . 'Action/Add/');
			Theme::SetTitle('Xóa bài viết');
			Helper::Header('Xóa bài viết');
		}
		elseif(Loader::$Working['action'] == 'Category') {
			Helper::State('Danh mục bài viết',ARTICLE_BASE . 'Category/');
			Helper::State('Xóa danh mục bài viết ', ARTICLE_BASE . 'Category/Add/');
			Theme::SetTitle('Xóa danh mục bài viết');
			Helper::Header('Xóa danh mục bài viết');
		}
		elseif(Loader::$Working['action'] == 'Group') {
			Helper::State('Nhóm bài viết',ARTICLE_BASE . 'Group/');
			Helper::State('Xóa nhóm bài viết ', ARTICLE_BASE . 'Group/Add/');
			Theme::SetTitle('Xóa nhóm bài viết');
			Helper::Header('Xóa nhóm bài viết');
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
					header('Refresh: 1.0; url=' . ARTICLE_BASE . Loader::$Working['action'] . '/');
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
				$FormAction = ARTICLE_BASE . Loader::$Working['action'] . '/Remove/' . $NodeID . '/';
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