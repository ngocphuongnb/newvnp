// JavaScript Document

function BaseObject(BaseUrl)
{
	this.Protocol		= window.location.protocol;
	this.Domain			= window.location.host;
	this.BaseUrl		= BaseUrl;
	this.Loader			= new BaseLoader();
	this.Upload			= new Object();
	this.FileBoxUrl		= this.BaseUrl + 'ajax/text/File/list_files/';
	this.OpenFileBox	= new Object();
	this.Ajax = function(Options,DataType)
	{
		if(typeof DataType === 'undefined') DataType = 'text';
		if(DataType != 'text' && DataType != 'json' && DataType != 'state') {
			alert('Invalid Data type!')
			return false;
		}
		var _UrlPrefix = this.BaseUrl + 'ajax/' + DataType + '/';
		
		Options.url			= _UrlPrefix + Options.url;
		Options.dataType	= DataType;
		
		var _DefaultOptions = {
				beforeSend: this.Loader.show(),
				success:	function(jdata, textStatus, jqXHR){},
				error:		function(jqXHR, textStatus, errorThrown){},
				//complete:	this.Loader.hide(),
			}
		var Options = $.extend({}, _DefaultOptions, Options);		
		$.ajax(Options);
	}
	
	this.SugarBox = new SugarBox();
}

function BaseLoader(Container) {
	if( typeof Container === 'undefined') Container = 'body';
	this.Container = Container;
	this.LoaderImage = 'data:image/gif;base64,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';
	
	this.show = function() {
		var LoaderStylesheet = 'style="\
			background-image: url(' + this.LoaderImage + ');\
			background-color: #333;\
			background-repeat: no-repeat;\
			background-position: 10px 6px;\
			background-size: 26px;\
			position: fixed;\
			width: 46px;\
			height: 38px;\
			top: 0;\
			right: 0;\
			border-radius: 5px;\
			border-top-right-radius: 0;\
			border-top-left-radius: 0;\
			border-bottom-right-radius: 0;\
			color: #FFF;\
			font-weight: bold;\
			line-height: 35px;\
			text-align: right;"';
		$('<div class="Ajax_Loader" ' + LoaderStylesheet + '></div>').appendTo(this.Container);
	}
	this.hide = function() {
		$('.Ajax_Loader', this.Container).remove();
	}
	this.TextNotify = function(text, type, sleepTime)
	{
		if(typeof sleepTime === 'undefined') sleepTime = 1500;
		if(typeof type === 'undefined') type = 'success';
		if(type == 'error') text = '<span style="color: #CC0000">' + text + '</span>';
		if(type == 'success') text = '<span style="color: #00AF00">' + text + '</span>';
		$('.Ajax_Loader', this.Container).append(text)
										.animate({width: '110px', paddingRight: '10px'},200)
										.fadeOut(sleepTime, function(){
											$(this).remove();
										});
		return this
	}
}

function SugarBox()
{
	self = this;
	this.BoxData		= {};
	this.IncludeFooter	= true;
	this.EnableDrag		= true;
	this.SugarWrapper	= '.Suger_Container';
	this.SugarHead		= '.Suger_Head';
	this.BoxTitle		= '.Sugar_Box-title';
	this.CloseBox		= '.Sugar_Close-box';
	this.DragPanel		= '.Sugar_Drag-box';
	this.SugarBody		= '.Sugar_Body';
	this.BoxContent		= '.box-content';
	this.BoxFoot		= '.Sugar_Foot';
	this.BoxFunctions	= '.foot-functions';
	this.Overlay		= '.Sugar_Overlay';
	this.CloseRole		= '[role="Close_SugarBox"]';
	this.PosX			= 0;
	this.PosY			= 0;
	this.BoxWidth		= 478;
	this.BoxHeight		= 0;
	this.BackUpSugarBox = null;
	
	
	this.SugarBoxTemplate = function(title, content, footer) {
		if(typeof title === 'undefined') title = 'VNP Sugar Box';
		if(typeof content === 'undefined') content = '';
		if(typeof footer === 'undefined') footer = '';
		 var out = '\
			<div class="Suger_Head">\
				<div class="Sugar_Box-title">' + title + '</div>\
				<div class="Sugar_Close-box" role="Close_SugarBox">×</div>\
				<div class="Sugar_Drag-box">\
				</div>\
			</div>\
			<div class="Sugar_Body">\
				<div class="box-content" style="width:100%; height: 100%">' + content + '</div>\
			</div>';
		if(typeof footer === 'undefined' || footer != '') {
			out +='\
			<div class="Sugar_Foot">\
				<div class="foot-functions">\
				</div>\
			</div>';
		}
		
		out += '<style type="text/css">div.Suger_Container *{border:0;outline:0;vertical-align:top;background:transparent;text-decoration:none;color:#333;font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;font-size:14px;text-shadow:none;float:none;position:static;width:auto;height:auto;white-space:nowrap;cursor:inherit;-webkit-tap-highlight-color:transparent;line-height:normal;font-weight:400;text-align:left;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box;direction:ltr;margin:0;padding:0}div.Suger_Container{display:block;border:0 solid #9e9e9e;background-color:#f0f0f0;zoom:1;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;-webkit-box-shadow:0 3px 7px rgba(0,0,0,0.3);-moz-box-shadow:0 3px 7px rgba(0,0,0,0.3);box-shadow:0 3px 7px rgba(0,0,0,0.3);filter:progid:DXImageTransform.Microsoft.gradient(enabled=false);background:#fff;position:fixed;top:0;left:0;-webkit-transition:opacity 150ms ease-in;transition:opacity 150ms ease-in;opacity:1}div.Suger_Head{border-bottom:1px solid #c5c5c5;position:relative;padding:9px 15px}div.Suger_Head div.Sugar_Box-title{line-height:20px;font-size:20px;font-weight:700;text-rendering:optimizelegibility;padding-right:10px}div.Suger_Head div.Sugar_Close-box{position:absolute;right:15px;top:9px;font-size:20px;font-weight:700;line-height:20px;color:#858585;cursor:pointer;height:20px;overflow:hidden}div.Suger_Head div.Sugar_Drag-box{position:absolute;top:0;left:0;cursor:move;width:90%;height:100%}div.Sugar_Body{position:relative;overflow:hidden;display:block}div.Sugar_Body div.box-content{border:0 solid #9e9e9e;background-color:#f0f0f0;zoom:1;left:0;top:0;position:absolute;display:block;white-space:normal}div.Sugar_Foot{border:0 solid #9e9e9e;zoom:1;display:block;background-color:#fff;border-top:1px solid #c5c5c5;-webkit-border-radius:0 0 6px 6px;-moz-border-radius:0 0 6px 6px;border-radius:0 0 6px 6px;left:0;top:0;border-width:1px 0 0}.Sugar_Overlay{position:fixed;left:0;top:0;width:100%;height:100%;background:#000;opacity:.3;filter:alpha(opacity=30);zoom:1}</style>';		
		$('<div/>', {
			class: 'Suger_Container',
			role: 'SugarBox',
			html: out
		}).appendTo('body');
		this.Sugar = $(this.DragPanel);
	}
	
	this.FinalBox		= '';	
	this.BuildSelector = function() {
		self.BoxTitle = self.SugarHead + ' ' + self.BoxTitle;
		self.CloseBox = self.SugarHead + ' ' + self.CloseBox;
		self.DragPanel = self.SugarHead + ' ' + self.DragPanel;
		self.BoxContent = self.SugarBody + ' ' + self.BoxContent;
		self.BoxFunctions = self.BoxFoot + ' ' + self.BoxFunctions;
	}
	
	this.Drag = {Element: null,x:0,y:0,State: false};	
	this.DetectDrag = function() {
		this.Sugar.mousedown(function(e) {
			if (!self.Drag.State) {
				self.Drag.Element = self.SugarWrapper;
				self.Drag.x = e.pageX;
				self.Drag.y = e.pageY;
				self.Drag.State = true;
			}
			return false;
		});		
		$(document).mousemove(function(e) {
			if(self.Drag.State) {	
				self.PosX	= e.pageX - self.Drag.x;
				self.PosY	= e.pageY - self.Drag.y;
				var cur_offset = $(self.Drag.Element).offset();
				$(self.Drag.Element).offset({
					left: (cur_offset.left + self.PosX),
					top: (cur_offset.top + self.PosY)
				});	
				self.Drag.x = e.pageX;
				self.Drag.y = e.pageY;
			}
		});		
		$(document).mouseup(function() {
			if(self.Drag.State) self.Drag.State = false;
		});
	}
	
	this.BuildSugarBox = function() {
		self.SugarBoxTemplate(self.BoxData.title, self.BoxData.content);
		$('div[role="SugarBox"]').css('display', 'block');
		$('div[role="SugarBox"]').css({'border-width':1,'z-index':65536,'width':self.BoxWidth});
		$(self.BoxContent, $('div[role="SugarBox"]')).width(self.BoxWidth);
		
		if(self.Boxheight == 0)
			var BoxContentHeight = $(self.BoxContent, $('div[role="SugarBox"]')).height() + 20;
		else var BoxContentHeight = self.Boxheight;
		$(self.SugarBody, $('div[role="SugarBox"]')).height(BoxContentHeight);
		$(self.BoxContent, $('div[role="SugarBox"]')).height(BoxContentHeight);
		
		if(self.IncludeFooter && self.BoxData.footer != '' )
			$('div[role="SugarBox"]').height(BoxContentHeight + 38 + 46);
		else {
			$('div[role="SugarBox"]').height(BoxContentHeight + 38);
		}
		if(!self.IncludeFooter)
			$(self.BoxFoot, $('div[role="SugarBox"]')).remove();
		$('body').append('<div class="Sugar_Overlay" style="z-index: 65535;"></div>');
		
		var ToLeft = ($(window).width() - $('div[role="SugarBox"]').width())/2;
		var ToTop = ($(window).height() - $('div[role="SugarBox"]').height())/2;
		$('div[role="SugarBox"]').css({'left': ToLeft,'top': ToTop});
	}
	
	this.CloseBoxAction = function() {
		$(self.CloseRole).click(function(e) {
			self.Close();
        });
	}
	
	this.Close = function() {
		this.BoxData = {};
		$('div[role="SugarBox"]').remove();
		$(self.Overlay).remove();
	}
	
	this.Open = function(BoxObject,Parameters) {
		if( BoxObject === 'FileManager' ) {
			BoxObject = {title:'Media manager', content: '<iframe src="' + VNP.BaseUrl + 'ajax/text/File/list_files/field/' + Parameters + '/" tabindex="-1" style="width: 100% !important; height:100% !important"></iframe>', footer:''};
			self.BoxWidth = window.innerWidth*0.818;
			self.Boxheight = 533;
		}
		else if( BoxObject === 'MultiImages' ) {
			BoxObject = {title:'Media manager', content: '<iframe src="' + VNP.BaseUrl + 'ajax/text/File/list_files/multi_images/' + Parameters + '/" tabindex="-1" style="width: 100% !important; height:100% !important"></iframe>', footer:''};
			self.BoxWidth = window.innerWidth*0.818;
			self.Boxheight = 533;
		}
		self.BoxData = BoxObject;
		this.BuildSelector();
		this.BuildSugarBox();
		this.CloseBoxAction();
		if(this.EnableDrag) this.DetectDrag();
	}
}

function objToString(obj) {
    var str = '';
    for (var p in obj) {
        if (obj.hasOwnProperty(p)) {
            str += p + '::' + obj[p] + '\n';
        }
    }
    return str;
}

