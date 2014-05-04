// JavaScript Document

function File_Manager(ManagerID, ActionsID, ListID, ItemSelector, ActionButtons)
{
	self = this;
	this.ManagerID		= ManagerID;
	this.ActionsID		= ActionsID;
	this.ListID			= ListID;
	this.ItemSelector	= ItemSelector;
	this.TotalSelected	= 0;
	this.DisableMultiSelect = false;
	this.Buttons		= ActionButtons;
	this.FileID			= 0;
	this.SelectedFiles	= [];
	this.TargetField	= '';
	
	$(this.ItemSelector).each(function(index, element) {
		$(this).dblclick(function(e) {
			e.preventDefault();
			self.SetActive($(this), false);
			self.SendFile();
            
        });
        $(this).click(function(e) {
            e.preventDefault();
			var MultiSelect = false;
			if(e.ctrlKey && !self.DisableMultiSelect) MultiSelect = true;
			self.SetActive($(this), MultiSelect);
			self.CheckButtonsStatus();
        });
    });
	
	this.SetActive = function(MediaItem, IsMultiSelect) {
		if(typeof IsMultiSelect === 'undefined') IsMultiSelect = false;
		if(MediaItem.attr('data-selected') == 1) {
			MediaItem.removeClass('selected');
			MediaItem.attr('data-selected', 0);
			//self.SelectedFiles.splice(self.SelectedFiles.indexOf(MediaItem.attr('data-file-id')), 1);
			self.TotalSelected--;
		}
		else {
			if(!IsMultiSelect) {
				self.DeactiveAll();
				self.FileID = MediaItem.attr('data-file-id');
			}
			/*self.SelectedFiles[MediaItem.attr('data-file-id')] = {
				location: MediaItem.attr('data-file-location'),
				title: MediaItem.attr('data-file-title'),
				alt: MediaItem.attr('data-file-alt')
			}*/
			MediaItem.addClass('selected');
			MediaItem.attr('data-selected', 1);
			self.TotalSelected++;
		}
	}
	
	this.DeactiveAll = function() {
		$(self.ItemSelector).removeClass('selected');
		$(self.ItemSelector).attr('data-selected', 0);
		self.TotalSelected = 0;
		self.SelectedFiles = new Array();
	}
	
	this.CheckButtonsStatus = function() {
		if(self.TotalSelected == 0) {
			self.DisableButton(self.Buttons.AddToEditor);
			self.DisableButton(self.Buttons.EditFile);
			self.DisableButton(self.Buttons.DeleteFile);
			self.DisableButton(self.Buttons.OpenImageEditor);
		}
		if(self.TotalSelected == 1) {
			self.EnableButton(self.Buttons.AddToEditor);
			self.EnableButton(self.Buttons.EditFile);
			self.EnableButton(self.Buttons.DeleteFile);
			self.EnableButton(self.Buttons.OpenImageEditor);
		}
		else if(self.TotalSelected > 1) {
			self.EnableButton(self.Buttons.AddToEditor);
			self.DisableButton(self.Buttons.EditFile);
			self.DisableButton(self.Buttons.DeleteFile);
			self.DisableButton(self.Buttons.OpenImageEditor);
		}
	}
	
	this.DisableButton = function(Btn) {
		$(Btn).addClass('disabled');
		$(Btn + ' a').attr('href', '');
	}
	
	this.EnableButton = function(Btn) {
		var ActionUrl = '';
		if(Btn == self.Buttons.EditFile) ActionUrl = VNP.BaseUrl + 'File/manage/edit/' + self.FileID + '/';
		else if(Btn == self.Buttons.DeleteFile) ActionUrl = VNP.BaseUrl + 'File/manage/remove/' + self.FileID + '/';
		else if(Btn == self.Buttons.OpenImageEditor) ActionUrl = VNP.BaseUrl + 'File/manage/ImageEditor/' + self.FileID + '/';
		$(Btn + ' a').attr('href', ActionUrl);
		$(Btn).removeClass('disabled');
	}
	
	this.SendFile = function() {
		var ImagesList = new Array();
		var File = {location: '', 'title': '', 'alt': ''};
		var ImageElement = ImageStyle = '';
		
		var SelectedItemsSelector = self.ItemSelector + '[data-selected="1"]';
		$(SelectedItemsSelector).each(function(index, element) {
			File = $(this);
			File.location = VNP.Protocol + '//' + VNP.Domain + '/Thumbnail/686_686/' + $(this).attr('data-file-location');
			File.title = $(this).attr('data-file-title');
			File.alt = $(this).attr('data-file-alt');
			if(FileManager.TargetField != '') {
				File.thumb = VNP.BaseUrl + 'Thumbnail/80_80/' + $(this).attr('data-file-location');
				File.location = $(this).attr('data-file-location');
				ImagesList = [File];
			}
			else {
				ImageStyle = 'display: block; margin-left: auto; margin-right: auto;';
				ImageElement = '<img style="' + ImageStyle + '" src="' + File.location + '" title="' + File.title + '" alt="' + File.alt + '" />';
				ImagesList.push(ImageElement);
			}
            
        });
		if(FileManager.TargetField != '') {
			parent.document.getElementById(FileManager.TargetField).value = ImagesList[0].location;
			parent.document.getElementById('Thumb_' + FileManager.TargetField).setAttribute('src',ImagesList[0].thumb);
			top.VNP.SugarBox.Close();
		}
		else {
			window.parent.tinymce.activeEditor.execCommand('mceInsertContent', false, ImagesList.join('<br />'));
			top.tinymce.activeEditor.windowManager.close();
		}
	}
	
	$(self.Buttons.AddToEditor + ' a').click(function(e) {
        e.preventDefault();
		self.SendFile();
    });
}

var ActionButtons = {	AddToEditor: 	'#AddToEditor',
						EditFile:		'#EditFile',
						DeleteFile:		'#DeleteFile',
						OpenImageEditor:'#OpenImageEditor'}

var FileManager = new File_Manager('#Files_Container', '#File_Actions', '#Main_Files', '.Media_Item', ActionButtons);
if(typeof TargetField !== 'undefined' && TargetField != '') {
	FileManager.DisableMultiSelect = true;
	FileManager.TargetField = TargetField;
}