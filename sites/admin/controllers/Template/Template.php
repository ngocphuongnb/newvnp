<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');
define('TEMPLATE_BASE', Router::BasePath() . '/Template/');
require BASE_PATH . 'admin/controllers/Node/Node.php';
define('CTL_ACTION', TEMPLATE_BASE . Loader::$Working['action'] . '/');

class Template extends Node
{
	private $AllowedActions = array('Add', 'Edit', 'Remove', 'listmenu');
	private $ActionName = '';
	private $Theme = array();
	private $MenuGroup = array();
	private $AllMenuGroups = array();
	private $ArrangedMenus = array();
	public function _main() {
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
	
	private function GetMenuGroups() {
		$GetMenuGroup = DB::Query('menu_group', USER_DOMAIN)->Get('menu_group_id');
		if($GetMenuGroup->status && $GetMenuGroup->num_rows > 0) {
			$this->AllMenuGroups = $GetMenuGroup->Result;
		}
	}
	
	public function Theme($Params)
	{
		Helper::State('Danh sách giao diện', TEMPLATE_BASE . 'Theme/');
		Helper::Header('Danh sách giao diện');
		Theme::SetTitle('Danh sách giao diện');
		$ThemeActions = array('view','edit','install');
		$ActionKeys = array_keys($Params);
		if(isset($ActionKeys[0]) && in_array($ActionKeys[0], $ThemeActions))
		{
			$ThemeCode = $Params[$ActionKeys[0]];
			$GetTheme = DB::Query('themes', '', DB::Slave())->Where('theme_code', '=',$ThemeCode)->Get();
			if($GetTheme->status && $GetTheme->num_rows == 1)
			{
				$this->Theme = $GetTheme->Result[0];
				$this->$ActionKeys[0]($Params);
			}
			else Helper::Notify('error', 'Không tìm thấy giao diện này!');
		}
		else
		{
			Helper::State('Lựa chọn giao diện', TEMPLATE_BASE . 'Theme/');
			Helper::Header('Lựa chọn giao diện');
			Theme::SetTitle('Lựa chọn giao diện');
			
			Theme::AddCssComponent('Forms,InputGroups,Tables,ButtonGroups');
			Theme::CssHeader('ThemeCss', CDN_SERVER . '/' . APPLICATION_DIR . '/data/css/user_theme.css');
			$GetAllThemes = DB::Query('themes', '', DB::Slave())->Where('status', '=', 1)->Get()->Result;
			$Theme = TPL::File('theme');
			$Theme->Assign('THEME_LIBS_DIR', CDN_SERVER . '/' . APPLICATION_DIR . '/data/themes/');
			$Theme->Assign('Themes', $GetAllThemes);
			Theme::$Body = $Theme->Output();
		}
	}
	
	protected function view($Params)
	{
		Theme::AddCssComponent('Forms,InputGroups,Tables,ButtonGroups,ProgressBars');
		Helper::State('Xem giao diện ' . $this->Theme['theme_name'], TEMPLATE_BASE . 'Theme/view/' . $this->Theme['theme_code'] . '/');
		Helper::Header('Xem giao diện ' . $this->Theme['theme_name']);
		Theme::SetTitle('Xem giao diện ' . $this->Theme['theme_name']);
		$theme = TPL::File('view');
		$theme->Assign('THEME_LIBS_DIR', CDN_SERVER . '/' . APPLICATION_DIR . '/data/themes/');
		$theme->Assign('Theme', $this->Theme);
		Theme::$Body = $theme->Output();
	}
	
	protected function install($Params)
	{
		$ThemeCode = $Params['install'];
		Helper::State('Xác nhận lựa chọn giao diện ' . $this->Theme['theme_name'], TEMPLATE_BASE . 'Theme/');
		Helper::Header('Xác nhận lựa chọn giao diện ' . $this->Theme['theme_name']);
		Theme::SetTitle('Xác nhận lựa chọn giao diện ' . $this->Theme['theme_name']);
		Theme::AddCssComponent('Forms,Buttons,Panels');
		$ShowConfirmForm = true;
		if(Input::Post('ThemeCode') == $ThemeCode)
		{
			$UpdateTheme = DB::Query('customers', '', DB::Slave())
								->Where('subname', '=', USER_DOMAIN)
								->Update(array('theme' => $this->Theme['directory']));
			if($UpdateTheme->status)
			{
				if($UpdateTheme->affected_rows == 1)
					Helper::Notify('success', 'Cập nhật giao diện thành công!');
				else Helper::Notify('success', 'Bạn đang sử dụng giao diện này!');
				header('Refresh: 2.0; url=' . TEMPLATE_BASE . 'Theme/');
			}
			else
			{
				Helper::Notify('error', 'Lỗi, không thể chọn giao diện này!');
				$ShowConfirmForm = true;
			}
		}
		else $ShowConfirmForm = true;
		
		if($ShowConfirmForm)
		{
			$FormAction = TEMPLATE_BASE . 'Theme/install/' . $ThemeCode . '/';
			$ConfirmString = '
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Bạn có chắc chắn lựa chọn giao diện ' . $this->Theme['theme_name'] . '</h3>
				</div>
				<div class="panel-body">
					<form method="post" action="' . $FormAction . '">
						<input type="hidden" value="' . $ThemeCode . '" name="ThemeCode" />
						<a href="javascript:window.history.go(-1); return false;" class="btn btn-default">Hủy</a>&nbsp;&nbsp;
						<input type="submit" class="btn btn-danger" value="Xác nhận" />
					</form>
				</div>
			</div>';
			Theme::$Body = $ConfirmString;
		}
	}
	
	public function Menu($Params) {
		
		$this->GetNodeType(8);
		$this->GetMenuGroups();
		if($this->DetectSubAction($Params, TEMPLATE_BASE . 'Menu/Add/'))
			header('LOCATION: ' . TEMPLATE_BASE . 'MenuGroup/');
	}
	
	public function MenuGroup($Params) {
		
		$this->GetNodeType(7);
		$this->GetMenuGroups();
		if($this->DetectSubAction($Params, TEMPLATE_BASE . 'MenuGroup/Add/'))
		{
			Theme::AddCssComponent('Tables,Navbar');
			Theme::SetTitle($this->NodeType['node_type_title']);
			Helper::Header($this->NodeType['node_type_title']);
			Helper::State('Quản lý khối menu',TEMPLATE_BASE . 'MenuGroup/');
			$TableName = $this->NodeType['node_type_name'];
			$Nodes = $this->AllMenuGroups;
			$Node = TPL::File('list_groups');
			$Node->Assign('Nodes', $Nodes);
			$Node->Assign('NodeType', $this->NodeType);
			$Node->Assign('CTL_ACTION', Loader::$Working['action']);
			Theme::$Body = $Node->Output();
		}
	}
	
	private function Add($Params, $FormAction)
	{
		if(Loader::$Working['action'] == 'MenuGroup') {
			Helper::State('Khối menu',TEMPLATE_BASE . 'MenuGroup/');
			Helper::State('Thêm Khối menu ', TEMPLATE_BASE . 'MenuGroup/Add/');
			Theme::SetTitle('Thêm Khối menu');
			Helper::Header('Thêm Khối menu');
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
		if(Loader::$Working['action'] == 'Menu') {
			if(isset($this->AllMenuGroups[$Params['Add']]))
			{
				$NodeData['menu_group'] = $Params['Add'];
				$NodeFields['menu_group']['node_field_type'] = 'hidden';
				$this->MenuGroup = $this->AllMenuGroups[$Params['Add']];
				$FormAction .= $Params['Add'] . '/';
				
				$NodeFields['parent_menuid']['data'] = unserialize($NodeFields['parent_menuid']['data']);
				$NodeFields['parent_menuid']['data']['custom_conditions'][] = array('column' => 'menu_group', 'compare' => '=', 'value' => $this->MenuGroup['menu_group_id']);
				$NodeFields['parent_menuid']['data'] = serialize($NodeFields['parent_menuid']['data']);
				
				Helper::State('Khối menu',TEMPLATE_BASE . 'MenuGroup/');
				Helper::State($this->MenuGroup['menu_group_title'],TEMPLATE_BASE . 'MenuGroup/listmenu/' . $this->MenuGroup['menu_group_id'] . '/');
				Helper::State('Thêm menu',TEMPLATE_BASE . 'Menu/Add/' . $this->MenuGroup['menu_group_id'] . '/');
				Theme::SetTitle('Thêm menu -  ' . $this->MenuGroup['menu_group_title']);
				Helper::Header('Thêm menu', 'Khối ' . $this->MenuGroup['menu_group_title']);
			}
			else {
				Helper::Notify('error', 'Khối menu không tồn tại!');
				header('Refresh: 3.0; url=' . TEMPLATE_BASE . 'MenuGroup/');
			}
		}
		
		if(Input::Post('Add_Node') == $this->NodeTypeID)
		{
			$NodeData = Input::Post('Node');
			$FieldsValue = $this->NodeFieldNormalization($NodeData,$NodeFields);
			if($FieldsValue !== false)
			{
				$TableName = $this->NodeType['node_type_name'];
				$_I = DB::Query($TableName, USER_DOMAIN)->Insert($FieldsValue);
				if($_I->status && $_I->insert_id > 0)
					Helper::Notify('success', 'Add node ok!');
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
		
		if(Loader::$Working['action'] == 'MenuGroup') {
			Helper::State('Khối menu',TEMPLATE_BASE . 'MenuGroup/');
			Helper::State('Sửa khối menu ', TEMPLATE_BASE . 'MenuGroup/Edit/' . $this->AllMenuGroups[$Params['Edit']]['menu_group_id'] . '/');
			Theme::SetTitle('Sửa khối menu');
			Helper::Header('Sửa khối menu');
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
			
			if(Loader::$Working['action'] == 'Menu')
			{
				$GroupID = $NodeData['menu_group'];
				if(isset($this->AllMenuGroups[$GroupID]))
				{
					$NodeData['menu_group'] = $GroupID;
					$NodeFields['menu_group']['node_field_type'] = 'hidden';
					$this->MenuGroup = $this->AllMenuGroups[$GroupID];
					$FormAction .= $Params['Edit'] . '/';
					$NodeFields['parent_menuid']['data'] = unserialize($NodeFields['parent_menuid']['data']);
					$NodeFields['parent_menuid']['data']['custom_conditions'][] = array('column' => 'menu_group', 'compare' => '=', 'value' => $GroupID);
					$NodeFields['parent_menuid']['data'] = serialize($NodeFields['parent_menuid']['data']);
				}
				else {
					Helper::Notify('error', 'Khối menu không tồn tại!');
					header('Refresh: 3.0; url=' . TEMPLATE_BASE . 'MenuGroup/');
				}
				
				$MenuGroup = $this->AllMenuGroups[$GroupID];
				Helper::State('Khối menu',TEMPLATE_BASE . 'MenuGroup/');
				Helper::State($MenuGroup['menu_group_title'],TEMPLATE_BASE . 'MenuGroup/listmenu/' . $MenuGroup['menu_group_id'] . '/');
				Helper::State('Sửa menu',TEMPLATE_BASE . 'Menu/Edit/' . $NodeID . '/');
				Theme::SetTitle('Sửa menu ' . $NodeData['menu_title'] . ' -  ' . $MenuGroup['menu_group_title']);
				Helper::Header('Sửa ' . $NodeData['menu_title'], 'Khối ' . $MenuGroup['menu_group_title']);
			}
			
			unset($NodeData[$TableName . '_id']);
			$NodeData = $this->DataTrueForm($NodeData,$NodeFields);
			if(Input::Post('Add_Node') == $this->NodeTypeID)
			{
				$NodeData = Input::Post('Node');
				$FieldsValue = $this->NodeFieldNormalization($NodeData,$NodeFields);
				if($FieldsValue !== false)
				{
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
			$Node->Assign('FormAction', TEMPLATE_BASE . Loader::$Working['action'] . '/Edit/' . $NodeID . '/');
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
		if(Loader::$Working['action'] == 'MenuGroup') {
			Helper::State('Khối menu',TEMPLATE_BASE . 'MenuGroup/');
			Helper::State('Xóa khối menu ', TEMPLATE_BASE . 'MenuGroup/Remove/' . $NodeID . '/');
			Theme::SetTitle('Xóa khối menu');
			Helper::Header('Xóa khối menu');
		}
		elseif(Loader::$Working['action'] == 'Menu') {
			Helper::State('Khối menu',TEMPLATE_BASE . 'MenuGroup/');
			Helper::State('Xóa menu ', TEMPLATE_BASE . 'Menu/Remove/' . $NodeID . '/');
			Theme::SetTitle('Xóa menu');
			Helper::Header('Xóa menu');
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
					header('Refresh: 1.0; url=' . TEMPLATE_BASE . Loader::$Working['action'] . '/');
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
				$FormAction = TEMPLATE_BASE . Loader::$Working['action'] . '/Remove/' . $NodeID . '/';
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
	
	private function listmenu($Params)
	{
		if(isset($Params['listmenu']) && $Params['listmenu'] > 0) {
			if(isset($this->AllMenuGroups[$Params['listmenu']])) {
				$this->MenuGroup = $this->AllMenuGroups[$Params['listmenu']];
			}
			else {
				Helper::Notify('error', 'Khối menu không tồn tại!');
				header('Refresh: 3.0; url=' . TEMPLATE_BASE . 'MenuGroup/');
			}
		}
		else header('LOCATION: ' . TEMPLATE_BASE . 'MenuGroup/');
		
		Helper::State('Khối menu',TEMPLATE_BASE . 'MenuGroup/');
		Helper::State($this->MenuGroup['menu_group_title'],TEMPLATE_BASE . 'MenuGroup/listmenu/' . $this->MenuGroup['menu_group_id'] . '/');
		Theme::SetTitle('Khối menu -  ' . $this->MenuGroup['menu_group_title']);
		Helper::Header('Danh sách link', $this->MenuGroup['menu_group_title']);
		Theme::AddCssComponent('Tables,Navbar');
		
		$Menus = DB::Query('menu', USER_DOMAIN)
						->Where('menu_group', '=', $Params['listmenu'])
						->Columns(array('menu_id', 'menu_title','menu_group','menu_titletag', 'menu_url', 'parent_menuid'))
						->Get('menu_id')->Result;
		$this->BuildMenusLevel($Menus);
		$AllMenuGroups = $this->AllMenuGroups;

		$Node = TPL::File('list_menus');
		$Node->Assign('Nodes', $this->ArrangedMenus);
		$Node->Assign('MenuGroup', $this->MenuGroup);
		$Node->Assign('NodeType', $this->NodeType);
		$Node->Assign('CTL_ACTION', Loader::$Working['action']);
		Theme::$Body = $Node->Output();
	}
	
	protected function BuildMenusLevel($Menus) {
		foreach($Menus as $MenuID => $Menu) {
			if($Menu['parent_menuid'] == 0) {
				$Menu['level'] = '';
				$this->ArrangedMenus[] = $Menu;
				
				unset($Menus[$MenuID]);
				$this->BuildSubMenuLevel($MenuID, $Menus, '');
			}
		}
	}
	
	protected function BuildSubMenuLevel($MenuID, $Menus, $ParentLevel) {
		foreach($Menus as $_MenuID => $Menu) {
			if($Menu['parent_menuid'] == $MenuID) {
				if($ParentLevel == '' ) $Menu['level'] = $ParentLevel . '└---------';
				else $Menu['level'] = $ParentLevel . '-------';
				$this->ArrangedMenus[] = $Menu;
				unset($Menus[$_MenuID]);
				$this->BuildSubMenuLevel($_MenuID, $Menus, $Menu['level']);
			}
		}
	}
}

?>