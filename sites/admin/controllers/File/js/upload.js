function UploadBase(UploaderSelector, InputSelector, UploadProgress, HolderSelector, FeaturedButtons)
{
	var self = this;
	if(typeof InputSelector === 'undefined') InputSelector = 'input[type="file"]';
	if(typeof HolderSelector === 'undefined') HolderSelector = null;
	if(typeof UploadProgress === 'undefined') UploadProgress = '#Upload_Progress';
	if(typeof FeaturedButtons === 'undefined') FeaturedButtons =  {	'Upload': 	'#Start_Upload',
																	'Pause':	'#Pause_Resume',
																	'Reset':	'#Clear_Form',
																	'Cancel':	'#Cancel_Upload'}
	
	this.Uploader = UploaderSelector;
	this.InputFiles = InputSelector;
	this.FilesHolder = HolderSelector;
	this.UploadProgress = UploadProgress;
	this.Buttons = FeaturedButtons;
	this.UploadFiles = {files: new Array()};
	this.TotalFiles = 0;
	this.IsPause = false;
	this.IsStop = false;
	this.CurrentFileID = 0;
	this.UploadedFileIDs = new Array();
	this.TotalUploaded = 0;
	this.SupportDragDrop = function() {
		if (isEventSupported('dragstart') && isEventSupported('drop'))
			return true;
		else return false;
	}
	
	this.Prepare = function() {
		if(this.SupportDragDrop())
		{
			$('#' + this.InputFiles).css('display','none');
			$('#' + this.FilesHolder).css({
					'width': '100%',
					'height': '50px',
					'border': '2px dashed #CCCCCC',
					'margin-bottom': '20px',
					'margin-top': '15px',
					'color': '#CCC',
					'padding': '25px 0',
					'text-align': 'center',
					'font-size': '25px',
					'box-sizing': 'content-box',
					'-moz-box-sizing': 'content-box',
					'cursor': 'pointer'
				}).html('Click or Drop files here to upload');
			this.DragAndDropListener();
			$('#' + this.FilesHolder).click(function(e) {
                var node = document.getElementById(self.InputFiles);
				var evt = document.createEvent('MouseEvents');
				evt.initEvent('click', true, false);
				node.dispatchEvent(evt);
            });
		}
		this.DetectInputFilesChanged();
		$('#' + self.InputFiles, self.Uploader).attr('multiple', 'multiple');
		$('form', self.Uploader).submit(function(e) { e.preventDefault();});
		$(self.Buttons.Upload).attr('disabled', 'disabled');
		$(self.Buttons.Pause).attr('disabled', 'disabled');
		$(self.Buttons.Cancel).attr('disabled', 'disabled');
		$(document).on('click', '.Single_Upload', function() {
			self.UploadFile($(this).attr('data-file-id'), true);
		})
	}
	
	this.DetectInputFilesChanged = function() {
		$('#' + this.InputFiles, this.Uploader).change(function(e) {	
			self.Clear();
			e.preventDefault();	
			self.UploadFiles = $(this)[0];
			self.TotalFiles = self.UploadFiles.files.length;
			if(self.TotalFiles > 0) $(self.Buttons.Upload).removeAttr('disabled');
			self.ShowUploadFiles();
			self.SubmitHandler();
        });
	}
	
	this.GetThumbnail = function(i) {
		if( i < self.TotalFiles )
		{
			var File = self.UploadFiles.files[i];
			var Target = 'Thumbnail_' + i;
			
			var canvas = document.getElementById(Target);
			canvas.height = 0;
			var ctx = canvas.getContext('2d');
			
			var reader = new FileReader();
			reader.onload = function(event){
				var img = new Image();
				img.onload = function(){
					canvas.width = 80;
					canvas.height = 80/(img.width/img.height);
					ctx.drawImage(img,0,0,80,80/(img.width/img.height));
					i++;
					self.GetThumbnail(i)
				}
				img.src = event.target.result;
			}
			reader.readAsDataURL(File);  
		}
	}
	
	this.ShowUploadFiles = function() {
		var Table = '\
		<div class="table-responsive">\
			<table class="table table-striped table-hover" id="Files_Container">\
				<colgroup>\
				<col class="col-xs-2">\
				<col class="col-xs-2">\
				<col class="col-xs-6">\
				<col class="col-xs-2">\
				</colgroup>\
				<thead>\
					<tr>\
						<th>Thumbnail</th>\
						<th>File name</th>\
						<th>Progress</th>\
						<th>Status</th>\
					</tr>\
				</thead>\
				<tbody id="Main_Files">';
			for( var i = 0; i < self.TotalFiles; i++ )
			{			
				Table +='\
					<tr id="File_' + i + '" style="width:100%; height: auto; float: none" data-selected="0" data-file-id="' + i + '" data-file-location="" data-file-alt="" data-file-title="" class="no-border">\
						<td><canvas id="Thumbnail_' + i + '" width="80" height="0"></canvas></td>\
						<td>' + self.UploadFiles.files[i].name + '</td>\
						<td>\
							<div class="progress progress-striped active" id="Progress_File_' + i + '">\
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">\
								<span class="sr-only">0% Complete</span>\
								</div>\
							</div>\
						</td>\
						<td id="Status_File_' + i + '">\
							<span class="glyphicon glyphicon-upload Single_Upload" data-file-id="' + i + '"></span>\
						</td>\
					</tr>';
			}
			Table +='</tbody>\
			</table>\
		</div>';
		$(self.UploadProgress).html(Table);
		self.GetThumbnail(0);
		if(typeof IsEditorUpload !== 'undefined' && IsEditorUpload) {
			$('#Files_Container').removeClass('table-striped');
		}
	}
	
	this.UploadFile = function(FileID, UploadSingleFile)
	{
		if(typeof UploadSingleFile === 'undefined') UploadSingleFile = false;
		if(self.IsPause || self.IsStop) return;
		if( FileID < parseInt(self.TotalFiles) )
		{
			if(jQuery.inArray(parseInt(FileID), self.UploadedFileIDs ) === -1)
			{
				var FData = new FormData();
					FData.append('Upload_Form', 1);
					FData.append('VNP_Files', self.UploadFiles.files[FileID]);
				VNP.Ajax({
					type: 'POST',
					url	: 'Media/upload/',
					data: FData,
					processData: false,
					contentType: false,
					dataType: 'json',
					xhr: function() {
						if(window.XMLHttpRequest) xhr = new XMLHttpRequest();
						else xhr = new ActiveXObject('Microsoft.XMLHTTP');		
						xhr.upload.addEventListener('progress', function(evt) {
							if (evt.lengthComputable) {  
								var Complete = (evt.loaded / evt.total)*100;
								$('#Progress_File_' + FileID + ' .progress-bar').attr('aria-valuenow', Complete);
								$('#Progress_File_' + FileID + ' .progress-bar').css({width: Complete + '%'});
							}
						}, false); 
						return xhr;
					},
					success: function(Result) {
						VNP.Loader.hide();
						if(Result.status == 'ok') {
							self.UploadedFileIDs.push(parseInt(FileID));
							$('#Progress_File_' + FileID).removeClass('active');
							$('#Status_File_' + FileID).html('<font color="green">Success</font>');
							self.TotalUploaded++;
							if(typeof IsEditorUpload !== 'undefined' && IsEditorUpload) {
								$('#File_' + FileID).addClass('Media_Item');
								$('#File_' + FileID).attr('data-file-id', Result.data.media_id);
								$('#File_' + FileID).attr('data-file-location', Result.data.media_location);
							}
						}
						else $('#Status_File_' + FileID).html('<font color="red">' + Result.data + '</font>');
						if(!UploadSingleFile) {
							self.CurrentFileID++;
							self.UploadFile(self.CurrentFileID);
						}
					},
					error: function(requestObject, error, errorThrown) {
						VNP.Loader.hide();
						$('#Status_File_' + FileID).html('<font color="red">' + errorThrown + '</font>');
						if(!UploadSingleFile) {
							self.CurrentFileID++;
							self.UploadFile(self.CurrentFileID);
						}
					}
				},'json');
			}
			else
			{
				self.CurrentFileID++;
				FileID++;
				self.UploadFile(FileID);
			}
		}
		else
		{
			self.CurrentFileID = 0;
			self.Clear();
			VNP.Loader.hide();
			$(self.Buttons.Cancel).attr('disabled', 'disabled');
			$(self.Buttons.Clear).removeAttr('disabled');
			$(self.Buttons.Pause).attr('disabled', 'disabled');
			if(typeof IsEditorUpload !== 'undefined' && IsEditorUpload)
			{
				var FileManager = new File_Manager('#Files_Container', '#File_Actions', '#Main_Files', '.Media_Item', ActionButtons);
				FileManager.DisableMultiSelect = false;
			}
		}
	}
	
	this.Clear = function(ClearPrepareFiles) 
	{
		if(typeof ClearPrepareFiles === 'undefined') ClearPrepareFiles = false;
		var control = $('#' + self.InputFiles);
		control.replaceWith(control.clone(true));
		self.UploadFiles = {files: new Array()};
		self.TotalFiles = 0;
		self.IsPause = false;
		self.IsStop = false;
		self.CurrentFileID = 0;
		self.UploadedFileIDs = new Array();
		self.TotalUploaded = 0;	
		if(ClearPrepareFiles) $(self.UploadProgress).html('');
	}
	
	this.StopUpload = function() 
	{
		VNP.Loader.hide();
		$(self.Buttons.Pause).attr('disabled', 'disabled');
		$(self.Buttons.Cancel).attr('disabled', 'disabled');
		$(self.Buttons.Clear).removeAttr('disabled');
		self.IsStop = true;
	}
	
	this.PauseUpload = function() 
	{
		if(!self.IsPause)
		{
			self.IsPause = true;
			$(self.Buttons.Pause).removeClass('btn-warning');
			$(self.Buttons.Pause).addClass('btn-success');
			$(self.Buttons.Pause).html('<span class="glyphicon glyphicon-play"></span>&nbsp;&nbsp;Resume');
		}
		else
		{
			self.IsPause = false;
			$(self.Buttons.Pause).removeClass('btn-success');
			$(self.Buttons.Pause).addClass('btn-warning');
			$(self.Buttons.Pause).html('<span class="glyphicon glyphicon-pause"></span>&nbsp;&nbsp;Pause');
			self.UploadFile(self.CurrentFileID);
		}
	}
	
	this.Debug = function() {
		var DebugObject = {	'Total': self.TotalFiles + ' - ' + self.UploadFiles.files.length,
							'CurrentFileID': self.CurrentFileID,
							'Uploaded':	self.UploadedFileIDs,
							'TotalUploaded': self.TotalUploaded,
							'files': objToString(self.UploadFiles.files)}
		alert(objToString(DebugObject));
	}
	
	this.SubmitHandler = function() {
		$('form', self.Uploader).submit(function(e) {
			e.preventDefault();
			return true;
		});
		$(self.Buttons.Upload).unbind('click');
		$(self.Buttons.Upload).click(function(e) {
            e.preventDefault();
			$(self.Buttons.Upload).attr('disabled', 'disabled');
			$(self.Buttons.Cancel).removeAttr('disabled');
			$(self.Buttons.Pause).removeAttr('disabled');
			$(self.Buttons.Clear).attr('disabled', 'disabled');
			self.UploadFile(self.CurrentFileID);
        });
	}
	$(self.Buttons.Clear).click(function(e) {
		e.preventDefault();
        self.Clear(true);
    });
	
	$(self.Buttons.Pause).click(function(e) {
		e.preventDefault();
        self.PauseUpload();
    });
	
	$(self.Buttons.Cancel).click(function(e) {
		e.preventDefault();
		if(confirm('Stop upload?')) self.StopUpload();
    });
	$('#Debug').click(function(e) {
        e.preventDefault();
		self.Debug();
    });
	
	this.DragAndDropListener = function() {
		//============== DRAG & DROP =============
		var dropbox = document.getElementById(self.FilesHolder)
		function dragEnterLeave(evt) {
			evt.stopPropagation()
			evt.preventDefault()
		}
		
		function dragEnter(evt) {
			evt.stopPropagation()
			evt.preventDefault()
			dropbox.style.color = '#444';
			dropbox.style.borderColor = '#444';
		}
		
		function dragLeave(evt) {
			evt.stopPropagation()
			evt.preventDefault()
			dropbox.style.color = '#CCC';
			dropbox.style.borderColor = '#CCC';
		}
		dropbox.addEventListener("dragenter", dragEnter, false)
		dropbox.addEventListener("dragleave", dragLeave, false)
		dropbox.addEventListener("dragover", function(evt) {
			evt.stopPropagation()
			evt.preventDefault()
			//var ok = evt.dataTransfer && evt.dataTransfer.types && evt.dataTransfer.types.indexOf('Files') >= 0
		}, false)
		dropbox.addEventListener("drop", function(evt) {
			evt.stopPropagation()
			evt.preventDefault()
			dropbox.style.color = '#CCC';
			dropbox.style.borderColor = '#CCC';
			var files = evt.dataTransfer.files
			if (files.length > 0)
			{
				for (var i = 0; i < files.length; i++) {
                    self.UploadFiles.files.push(files[i])
                }
				self.TotalFiles = self.UploadFiles.files.length;
				if(self.TotalFiles > 0) $(self.Buttons.Upload).removeAttr('disabled');
				self.ShowUploadFiles();
				self.SubmitHandler();
			}
		}, false)
	}
}

var FeaturedButtons = {
		'Upload': 	'#Start_Upload',
		'Pause':	'#Pause_Resume',
		'Clear':	'#Clear_Form',
		'Cancel':	'#Cancel_Upload'
}

VNP.Upload = new UploadBase('#File_Uploader','Files_Input','#Upload_Progress','Files_Holder', FeaturedButtons);
VNP.Upload.Prepare();

function isEventSupported( eventName, element ) {
	var TAGNAMES = {
		'select': 'input', 'change': 'input',
		'submit': 'form', 'reset': 'form',
		'error': 'img', 'load': 'img', 'abort': 'img'
	};
	element = element || document.createElement(TAGNAMES[eventName] || 'div');
	eventName = 'on' + eventName;
	// When using `setAttribute`, IE skips "unload", WebKit skips "unload" and "resize", whereas `in` "catches" those
	var isSupported = eventName in element;
	if ( !isSupported ) {
		// If it has no `setAttribute` (i.e. doesn't implement Node interface), try generic element
		if ( !element.setAttribute )  element = document.createElement('div');
		if ( element.setAttribute && element.removeAttribute ) {
			element.setAttribute(eventName, '');
			isSupported = typeof element[eventName] == 'function';
			// If property was created, "remove it" (by setting value to `undefined`)
			if ( typeof element[eventName] != 'undefined' )  element[eventName] = undefined;
			element.removeAttribute(eventName);
		}
	}
	element = null;
	return isSupported;
}