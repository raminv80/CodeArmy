/*
* Kaiten jQuery plugin
* Copyright (c) 2011 Nectil SA. François Dispaux, Boris Verdeyen, Marc Mignonsin, Jonathan Sanchez, Julien Gonzalez
* 
* E-Mail : support@officity.com
* Web site : http://www.officity.com/kaiten/
* Licence: GPL, http://www.gnu.org/licenses/gpl.html
* 
* Kaiten is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
* Kaiten is distributed in the hope that they will be useful, but WITHOUT ANY WARRANTY; 
* without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
* See the GNU General Public License for more details.
* You should have received a copy of the GNU General Public License along with Sushee. If not, see <http://www.gnu.org/licenses/>.
*/

jKaiten = {
	version : '1.0.2 (2011-06-17)',
	
	/* DEFAULT PROPERTIES/METHODS */
		
	// default widget property : options (a mix of defaults with settings provided by the user)
	options : {		
		animsFiringRate		: 13,
		columnWidth			: '320px',
		optionsSelector		: '',
		startup				: null,
		connectors			: {},
		panelOptionsHTML	: ''
	},
	
	// default widget method : creation
	_create : function() {
		//console.log('jKaiten._create', arguments);
		
		/* 0. check for requirements */
		
		if (this._check4Requirements() === false)
		{
			var $failure = $('<p style="text-align:center;margin-top:20%;">'+
								'Unfortunately, your browser is not supported by Kaiten.<br/>'+
								'Please use '+
								'<a href="http://www.firefox.com/" target="_blank"><strong>Firefox</strong></a>, '+
								'<a href="http://www.apple.com/safari/" target="_blank"><strong>Safari</strong></a>, '+
								'<a href="http://www.google.com/chrome" target="_blank"><strong>Chrome</strong></a>, or '+
								'<a href="http://www.opera.com/" target="_blank"><strong>Opera</strong></a>.'+
							'</p>');
			$failure.appendTo(this.element);
			return;
		}

		/* 1. define state */
		
		this._state = {
			hasTouchScreen		: ('ontouchstart' in window),
			tabID				: Math.floor(Math.random()*99999999999).toString(),
			panelsCreated		: 0,
			anims				: {
				count			: 0,
				delayedLayout	: false
			},
			focus	: {
				panelIndex		: 0,
				navItemIndex	: null,
				typing			: ''
			},
			connectors 		: jKaiten._state.connectors || { }, // allows connectors registration before Kaiten is initialized
			css				: { }
		};
		
		// touchscreen device
		if (this._state.hasTouchScreen)
		{
			var fullPath = $('script[src*="jkaiten.js"]').prop('src');
			var basePath = fullPath.substring(0, fullPath.lastIndexOf('jkaiten.js'));
			$.getScript(basePath+'/scrollability/scrollability-min.js');
			
			this._setOption('animsFiringRate', 50);
		}
		
		var intWidth = parseInt(this.options.columnWidth, 10);
		if (!intWidth)
		{
			this.options.columnWidth = intWidth = 320;
		}
		if (/[0-9]%$/.test(this.options.columnWidth)) // allows width to be specified in %
		{
			this._state.columnsCount = (intWidth > 100) ? 1 : Math.floor(100/intWidth);
		}
		else // treat as px
		{
			intWidth = (intWidth > $(window).width()) ? $(window).width() : intWidth;
			this._state.columnsCount = Math.floor($(window).width() / intWidth);
		}
		if (this._state.columnWidth < this._constants.minColumnWidth) // limitation
		{
			this._state.columnsCount = Math.floor($(window).width() / this._constants.minColumnWidth);
		}
		this._state.columnWidth = Math.floor($(window).width()/this._state.columnsCount);
	
		this.options.columnWidth = this._state.columnWidth;
		this._state.prevColumnsCount = this._state.columnsCount;
		
		/* 2. HTML markup */
		
		var html = '<div id="k-window">'+
			'<div id="k-topbar">'+
				'<div id="mask" class="'+jKaiten.selectors.maskClass+'-20" />'+
				'<div id="k-breadcrumb"></div>'+
			'</div>'+
			'<div id="k-slider"></div>'+
		'</div>';
		$(html).appendTo(this.element);
		
		this.$slider = this.element.find(this.selectors.slider);
		
		this._createAppMenu();
		
		this.$breadcrumb = this.element.find(this.selectors.breadcrumb).kbreadcrumb({});
		
		/* 3. bind events */
		
		var self = this;
		
		// viewport size change
		$(window).bind('resize orientationchange', function(e){
			self._doLayout();
		});
		
		// panel toolbar
		var allTools = this._constants.panelLeftTools.concat(this._constants.panelRightTools);
		this.element.delegate(this.selectors.panelItems.titleBar, 'click', function(e){				
			var $target = $(e.target), $panel = $(this).closest(self.selectors.panel);
			if (!$target.hasClass(self.selectors.panelItems.tools.prevClass) && !$target.hasClass(self.selectors.panelItems.tools.nextClass))
			{
				self.setPanelFocus($panel);
			}
			if ($target.hasClass(self.selectors.disabledClass) || !$target.hasClass(self.selectors.panelItems.toolClass))
			{
				return;
			}
			var t, callback = null, i;					
			for (i=allTools.length-1; i>=0; i--)
			{
				t = allTools[i];
				if ($target.hasClass(t.className))
				{
					if ($.isFunction(t.callback))
					{
						t.callback.call($target[0], e, $panel, self.element);	
					}
					return;
				}
			}				
		});
		
		// panel options
		this.element.delegate(this.selectors.panelItems.title, 'click', function(e){
			var $panel = $(this).closest(self.selectors.panel);
			if ($panel.hasClass(self.selectors.focusClass))
			{
				$panel.kpanel('toggleOptions');
			}
		});
		
		// panel animation start/complete
		this.element.bind('animstart.kpanel', function(e){
			self._state.anims.count += 1;
		});
		this.element.bind('animcomplete.kpanel', function(e){
			self._state.anims.count -= 1;
			if (self._state.anims.count <= 0)
			{
				if (self._state.anims.delayedLayout === true)
				{
					console.info('Kaiten layout retry...');
					self._state.anims.delayedLayout = false;
					self._doLayout();
				}
			}
		});
		
		// next panels placement
		this.element.bind('nextplacement.kaiten', function(e, $panel, posInc, callback){
			self._nextPlacement($panel, posInc, callback);
		});
		
		// prev panels placement
		this.element.bind('prevplacement.kaiten', function(e, $panel, posInc, callback){
			self._prevPlacement($panel, posInc, callback);
		});
		
		//panel destruction
		this.element.bind('afterdestroy.kpanel', function(e){
			self._state.panelsCreated -= 1;
		});
		
		// keyboard navigation
		this._initKeyboardNavigation();
		
		/* 4. Layout */
		
		this._doLayout();
		
		/* 5. Connectors and click delegation */
		
		var n, connectors = $.extend({}, this._constants.connectors, this.options.connectors);
		for (n in connectors)
		{
			if (connectors.hasOwnProperty(n))
			{
				this.registerConnector(n, connectors[n]); 
			}
		}		
		//console.log('registered connectors', this._state.connectors);
		
        // non-navigable elements
		this.element.delegate(this.selectors.items.nonavigable, 'click', function(e){
			e.stopPropagation();
		});
		
		// click : "navigable" class and "connectable" <a> elements inside a panel
		var clickSelectors = [  
			this.selectors.items.navigable,
			this.selectors.panel+' '+this.selectors.connectable
		];
		this.element.delegate(clickSelectors.join(', '), 'click', function(e){
			var $this = $(this);
			if ($this.is('a') && !$this.data('load'))
			{
				//console.log('link click', arguments, this);
				self._onClickLink(e, $this);
			}
			else
			{
				//console.log('navitem click', arguments, this);
				self._onClickNavItem(e, $this);
			}
		});
		
		/* 6. Startup loading */

		if ($.isFunction(this.options.startup))
		{
			var dataFromURL = null;
			if (window.location.search !== '')
			{	
				dataFromURL = {};
				var dataParts = window.location.search.split('?').pop().split('&');
				var i, l, p;			
				for (i=0, l=dataParts.length; i<l; i++)
				{
					p = dataParts[i].split('=');
					dataFromURL[p[0]] = decodeURIComponent(p[1]).replace(/\+/g, ' ');
				}	
				if (dataFromURL.kURL)
				{
					dataFromURL = this.findLoaderData(dataFromURL.kURL);
				}
			}
			this.options.startup.call(this.element, dataFromURL);
		}
		
		//console.log('options/state', this.options, this._state);
	},
	
	// default widget method : option settings
	_setOption : function(key, value) {
		console.log('jKaiten._setOption', arguments);
		
		switch (key)
		{
			case 'columnWidth':
				this.setColumnWidth(value);
				break;
				
			case 'animsFiringRate':
				jQuery.fx.interval = value;
				break;
				
			case 'connectors':
				if ($.isPlainObject(value))
				{
					for (n in value)
					{
						if (value.hasOwnProperty(n))
						{
							this.registerConnector(n, value[n]); 
						}
					}
				}
				break;
				
			case 'optionsSelector':
				if (value !== '')
				{
					var $custom = $(value);
					if ($custom.length === 0)
					{
						break;
					}
					var customHTML = '<div id="options-custom" class="line">'+$custom.html()+'</div>';
					$custom.remove();
					this.element.find(this.selectors.optionsCustom).html(customHTML);
				}
				break;
			
			default:
				break;
		}
		
		$.Widget.prototype._setOption.apply(this, arguments);
	},
	
	// default widget method : destruction (removes the instance from the encapsulated DOM element, which was stored on instance creation)
	destroy : function() {
		console.log('jKaiten.destroy', arguments);
		this.element.find(this.selectors.panel).kpanel('destroy');
		this.element.unbind().undelegate().empty();
		$.Widget.prototype.destroy.apply(this, arguments);
	},
	
	/* PROPERTIES, CONSTANTS, ... */
	
	selectors : {
		window				: '#k-window',
		slider				: '#k-slider',
		topbar				: '#k-topbar',
		topbarMask			: '#k-topbar #mask',
		appMenuBorder		: '#k-topbar #menu-border',
		appMenuContainer	: '#k-topbar #menu-container',
		optionsButton		: '#k-topbar #options-button',
		optionsDialog		: '#k-topbar #options-dlg',
		optionsCustom		: '#k-topbar #options-custom',
		columnsCount		: '#k-topbar #columns-count',
		columnsInc			: '#k-topbar #columns-inc',
		columnsDec			: '#k-topbar #columns-dec',
		breadcrumb			: '#k-breadcrumb',
		breadcrumbItems		: {
			homeClass		: 'home',
			lastClass		: 'last',
			anchorIDPrefix	: 'crumb'
		},
		loaderClass			: 'loader',
		maskClass			: 'mask',
		panel				: '.k-panel',
		panelClass			: 'k-panel',
		panelIDPrefix		: 'kp',
		panelItems			: {
			mask				: '.mask',
			loader				: '.loader',
			titleBarClass		: 'titlebar',
			titleBar			: '.titlebar',
			title				: '.titlebar .title',
			titleClass			: 'title',
			titleContainerClass	: 'center',
			leftToolbarClass	: 'left',
			rightToolbarClass	: 'right',
			toolClass			: 'tool',
			tools				: {
				all			: '.titlebar .tool',
				prev		: '.titlebar .nav-prev',
				prevClass	: 'nav-prev',
				next		: '.titlebar .nav-next',
				nextClass	: 'nav-next',
				reload		: '.titlebar .reload',
				newtab		: '.titlebar .newtab',
				maximize	: '.titlebar .maximize'
			},
			optionsClass		: 'panel-options',
			options				: '.panel-options',
			headerClass			: 'panel-header',
			header				: '.panel-header',
			bodyClass			: 'panel-body',
			body				: '.panel-body',
			blockClass			: 'block',
			blockNavClass		: 'block-nav',
			blockIFrameClass	: 'block-iframe',
			blockExitClass		: 'block-exit'
		},
		items				: {
			itemsClass			: 'items',			
			label				: '.label',
			labelClass			: 'label',
			infoClass			: 'info',
			info				: '.info',
			head				: '.head',
			headClass			: 'head',
			tailClass			: 'tail',
			summaryClass		: 'summary',
			separatorClass		: 'separator',
			navigable			: '.navigable:visible',
			navigableClass		: 'navigable',
			nonavigable			: '.no-nav',
			nonavigableClass	: 'no-nav',
			clickable			: '.clickable',
			clickableClass		: 'clickable'
		},		
		connectable			: 'a[href]:visible:not(.no-nav)',
		activeClass			: 'k-active',
		focusClass			: 'k-focus',
		externalClass		: 'k-external',
		exitClass			: 'k-exit',
		disabledClass		: 'disabled',
		visibleClass		: 'visible',
		invisibleClass		: 'invisible'
	},
	
	_state : {
		anims		: { },
		focus		: { },
		connectors	: { },
		css			: { }
	},
	
	_constants : {
		minColumnWidth	: 200,
		clearTypeDelay	: 1000,
		panelLeftTools : [
         {
        	 className	: 'nav-prev',
        	 title		: 'Previous panel',
        	 callback	: function(e, $panel, $kaiten){
 				e.preventDefault();
				$kaiten.kaiten('prev');
			}
         },
         {
        	 className	: 'newtab',
        	 title		: 'Open this panel in a new tab',
        	 callback	: function(e, $panel, $kaiten){
 				e.preventDefault();
 				$panel.kpanel('newTab');
			}
         }/*,
         {
        	 className	: 'reload',
        	 title		: 'Reload',
        	 callback	: function(e, $panel, $kaiten){
 				e.preventDefault();
 				$panel.kpanel('reload');
			}
         }*/],
         panelRightTools : [
         {
			className	: 'maximize',
			title		: 'Resize',
			callback	: function(e, $panel, $kaiten){
				e.preventDefault();
				if (!$(this).hasClass(jKaiten.selectors.activeClass))
				{
					$panel.kpanel('maximize', self.element);
				}
				else
				{
					$panel.kpanel('originalSize', self.element);
				}
				$(this).toggleClass(jKaiten.selectors.activeClass);
			}
		},
		{
			className	: 'nav-next',
			title		: 'Next panel',
			callback	: function(e, $panel, $kaiten){
				e.preventDefault();
				$kaiten.kaiten('next');
			}
		}],
		connectors		: {
			"html.page" : {
				loader : function(data, $panel, $kaiten) {
					//console.log('html.page loader', arguments);
					return $.get(data.url);
				}
			},
			"html.string" : {
				loader : function(data, $panel, $kaiten) {
					//console.log('html.string loader', arguments);
					var html = data.html;
					var $html = $('<div />', {
						"class" : jKaiten.selectors.panelItems.bodyClass
					}).append(html);
					// avoid loss of events/data when panel content removed from DOM
					if (html instanceof jQuery)
					{
						return $html.clone(true, true);
					}
					return $html;
				}
			},
			// content in an iframe
			"iframe" : {
				loader : function(data, $panel, $kaiten) {
					if (!data.url)
					{
						throw new Error('Missing URL! Cannot load content in an iframe.');
					}
					var title = data.kTitle || data.url;
					$panel.kpanel('setTitle', title);
					var panelSelectors = jKaiten.selectors.panelItems;
					var html = '<div class="'+panelSelectors.headerClass+'">'+
									'<div class="'+panelSelectors.blockExitClass+'">'+
										'The content you are viewing is external.<br/>'+
										'<span style="font-size:80%;">'+
											'Click <a href="'+data.url+'" class="'+jKaiten.selectors.exitClass+'">here</a> to leave Kaiten and open it in a separate window.'+
										'</span>'+
									'</div>'+
								'</div>'+
								'<div class="'+panelSelectors.bodyClass+'" optimal-width="980px">'+
									'<div class="'+panelSelectors.blockIFrameClass+'">'+
										'<iframe src="'+data.url+'" width="100%" height="100%" class="loader" onload="$(this).removeClass(\'loader\');" />'+
									'</div>'+
								'</div>';
					return html;
				},
				connectable : function(href, $link) {
					return $(this).hasClass(jKaiten.selectors.externalClass);
				},
				getData	: function(href, $link) {
					return { url : href };
				}
			}
		}
	},
	
	/* INTERNAL FUNCTIONS */
	
	_check4Requirements : function() {
		//return true; 
		return (($.browser.mozilla === true) || ($.browser.webkit === true) || ($.browser.opera === true));
	},
	
	_onClickLink : function(e, $link) {
		//console.log('jKaiten._onClickLink', arguments);
		var $panel = $link.closest(this.selectors.panel);
		
		// anchor?
        var href = $link.attr('href');
        if (!href || (href === '#'))
        {
        	return true;
        }
		if (href[0] === '#')
		{				
			var $body = $link.closest(this.selectors.panelItems.body);
			var $target = $body.find(href.replace(/\./g, '\\.')); // some IDs may contain dots (yes...)		
			if ($target.length > 0)
			{
				e.preventDefault();
				$body.scrollTop($target.position().top + $body.scrollTop() - 8);
				return false;
			}
			$target = $body.find('a[name='+href.substr(1)+']');
			if ($target.length > 0)
			{
				e.preventDefault();
				$body.scrollTop($target.position().top + $body.scrollTop() - 8);
				return false;
			}
		    return true;
		}
		
		// mailto?
		if (/mailto:.+/.test(href) === true)
		{
			return true;
		}
		
		// we'll take it from here
		e.preventDefault();
		
		// exit Kaiten?
		if ($link.hasClass(this.selectors.exitClass))
		{
			window.open(href, $link.text());
			return false;
		}
		
        // already active?
        if ($link.hasClass(this.selectors.activeClass) 
        		&& (e.shiftKey === false)
        		&& (e.metaKey === false))
        {
        	var $nextPanel = $panel.next(this.selectors.panel);
        	if ($nextPanel.is(':hidden'))
        	{
        		this.next();
        	}
        	else
        	{
        		this.setPanelFocus($nextPanel);
        	}
        	return false;
        }

		var defaultData = {
			kTitle : $link.text()
		};
		
        // loop through all connectors to determine which one this link will use to load content
        var loadData = this.findLoaderData(href, $link, $(e.target));
		loadData = $.extend({}, defaultData, loadData);
								
		// new tab?
		if (e.metaKey === true)
		{
			this.newTab(loadData, $link.text());
			return false;
		}
		
    	// load
    	this.load(loadData, $link);
	},
	
	_onClickNavItem : function(e, $navItem) {
		//console.log('jKaiten._onClickNavItem', arguments);		
		var $target = $(e.target), navItemData = $navItem.data('load');	
		// no data
		if (!navItemData)
		{
			return false;
		}
        // already active?
        if ($navItem.hasClass(this.selectors.activeClass) 
        		&& (e.shiftKey === false)
        		&& (e.metaKey === false))
        {
        	var $nextPanel = $navItem.closest(this.selectors.panel).next(this.selectors.panel);
        	if ($nextPanel.is(':hidden'))
        	{
        		this.next();
        	}
        	else
        	{
        		this.setPanelFocus($nextPanel);
        	}
        	return false;
        }
        
		var label = $navItem.find(this.selectors.items.label).text();
		var defaultData = {
			kTitle : label
		};
		var loadData = $.extend({}, defaultData, navItemData);
					
		// new tab?
		if (e.metaKey === true)
		{
			this.newTab(loadData, label);
			return false;
		}
    	
    	this.load(loadData, $navItem);
	},
	
	_initKeyboardNavigation : function(){
		//console.log('jKaiten._initKeyboardNavigation', arguments);
		var self = this, focusState = this._state.focus;
		
		// keydown
		$(document).keydown(function(e) {
			//console.log('keydown', e);
			if (self._state.anims.count > 0)
			{
				return;
			}
			if ((document.activeElement.tagName === 'INPUT') || (document.activeElement.tagName === 'TEXTAREA'))
			{
				return;
			}

			var keyCode = (e === null) ? event.keyCode : e.which; // mozilla
			var keyChar = String.fromCharCode(keyCode);
			//console.log(keyCode,keyChar);

			var lowIndex, highIndex;

			switch (keyCode)
			{
				case 37: // left					
					lowIndex = self._getFirstPanel().kpanel('getState').index;
					highIndex = self._getLastPanel().kpanel('getState').index;
					if ((focusState.panelIndex < lowIndex) || (focusState.panelIndex > highIndex))
					{	
						self._setPanelFocus(highIndex);
					}
					else if (focusState.panelIndex > 0)
					{	
						if (focusState.panelIndex <= self._getFirstPanel().kpanel('getState').index)
						{
							self.prev();
				  		}
						else
						{
							self._setPanelFocus(focusState.panelIndex-1);
						}
					}					
			  		break;
			  		
				case 39: // right
					if (focusState.navItemIndex !== null)
					{	
						var $focusedPanel = self._getFocusedPanel();
						var $navItems = $focusedPanel.kpanel('getState').$navItems || $focusedPanel.kpanel('buildNavItemsCollection');
						$navItems.eq(focusState.navItemIndex).trigger('click');
						break;
					}
					lowIndex = self._getFirstPanel().kpanel('getState').index;
					highIndex = self._getLastPanel().kpanel('getState').index;
					if ((focusState.panelIndex < lowIndex) || (focusState.panelIndex > highIndex))
					{
						self._setPanelFocus(lowIndex);
					}
					else if (focusState.panelIndex < (self._state.panelsCreated-1))
					{
						if (focusState.panelIndex >= self._getLastPanel().kpanel('getState').index)
						{
							self.next();
						}
						else
						{
							self._setPanelFocus(focusState.panelIndex+1);
						}
					}					
					break;
					
				case 38: // up
					if (focusState.navItemIndex === null) // first focus
					{
						self._setNavItemFocus('firstup');
					}
					else
					{
						
						self._setNavItemFocus(focusState.navItemIndex-1);
					}					
					e.preventDefault();	
					break;
					
				case 40: // down
					if (focusState.navItemIndex === null) // first focus
					{
						self._setNavItemFocus('firstdown');
					}
					else
					{						
						self._setNavItemFocus(focusState.navItemIndex+1);
					}
					e.preventDefault();
					break;
					
				case 97: // 1-9 > columns
				case 98:
				case 99:
				case 100:
				case 101:
				case 102:
				case 103:
				case 104:
				case 105:
					self.setColumnsCount(keyCode-96);
					break;
					
				case 107: // + mozilla
				case 187: // + webkit
					self.setColumnsCount(self._state.columnsCount+1);
					break;
					
				case 109: // - mozilla
				case 189: // - webkit
					self.setColumnsCount(self._state.columnsCount-1);
					break;
					
				default:
					if ((keyCode > 47) && (keyCode < 91))
					{
						self._onType(keyChar);
					}
			}
		});
	},
	
	_createAppMenu : function(){
		//console.log('jKaiten._createAppMenu', arguments);
		
		/* 1. HTML markup */
		
		var customHTML = '';
		if (this.options.optionsSelector !== '')
		{
			var $custom = $(this.options.optionsSelector);
			customHTML = '<div id="options-custom" class="line">'+$custom.html()+'</div>';
			$custom.remove();
		}
		
		var html = '<div id="menu-border" />'+
					'<div id="menu-container">'+
						'<button id="newtab-button" title="Open the application in a new tab" accesskey="t" onclick="window.open(document.location.href, \'\');" />'+
						'<button id="options-button" title="Options" accesskey="o" />'+
					'</div>'+
					'<div id="options-dlg" class="box-shadow">'+
						'<div id="columns-controls" class="line">'+
							'<strong id="columns-count"></strong>'+
							'<button id="columns-inc" accesskey="p" title="+"/></button><button id="columns-dec" accesskey="m" title="-"/>'+
						'</div>'+
						customHTML+
						'<div class="line footer">'+
							'<p>Kaiten v'+this.version+'</p>'+
							'<p>© 2004-2011 Nectil S.A. all rights reserved.</p>'+
						'</div>'+
					'</div>';
		this.element.find(this.selectors.topbar).append(html);
				
		// update columns count and column width
		this._updateSliderDetails();
		
		/* 2. Events */
		
		var self = this;

		// columns count +/-
		this.element.find(this.selectors.columnsInc).click(function(){
			if (self._state.anims.count > 0) // disable during animations
			{
				return;
			}
			self.setColumnsCount(self._state.columnsCount+1);
			self._updateSliderDetails();
		});
		this.element.find(this.selectors.columnsDec).click(function(){
			if (self._state.anims.count > 0) // disable during animations
			{
				return;
			}
			self.setColumnsCount(self._state.columnsCount-1);
			self._updateSliderDetails();
		});
		
		// options dialog : toggle on click
		this.element.find(this.selectors.optionsButton).click(function(e){
			var $this = $(this), $optionsDialog = self.element.find(self.selectors.optionsDialog);
			if ($optionsDialog.is(':hidden'))
			{
				e.stopPropagation();
				$optionsDialog.fadeIn(125);				
				$(document).bind('click', function(e){						
					var $target = $(e.target);
					if ($target.closest(self.selectors.optionsDialog).length === 0)
					{
						$(document).unbind('click');
						$optionsDialog.hide();
						$this.toggleClass(self.selectors.activeClass);
					}
				});
			}
			else
			{
				$(document).unbind('click');
				$optionsDialog.hide();
			}
			$this.toggleClass(self.selectors.activeClass);
		});
	},
	
	_updateSliderDetails : function() {
		if ((Math.floor($(window).width() / (this._state.columnsCount+1)) < this._constants.minColumnWidth) || 
			(this._state.columnWidth < this._constants.minColumnWidth)) // limitation
		{
			this.element.find(this.selectors.columnsInc).attr('disabled', 'disabled').addClass(this.selectors.disabledClass);
		}
		else
		{
			this.element.find(this.selectors.columnsInc).removeAttr('disabled').removeClass(this.selectors.disabledClass);
		}
		if (this._state.columnsCount <= 1) // limitation
		{
			this.element.find(this.selectors.columnsDec).attr('disabled', 'disabled').addClass(this.selectors.disabledClass);
		}
		else
		{
			this.element.find(this.selectors.columnsDec).removeAttr('disabled').removeClass(this.selectors.disabledClass);
		}
		this.element.find(this.selectors.columnsCount).html(this._state.columnsCount+' column(s)');
	},
	
	_computeDimensions : function() {
		//console.log('jKaiten._computeDimensions', arguments);
		this._state.prevWidth = this._state.width; // for breadcrumb layout
		this._state.width = $(window).width();
		this._state.height = $(window).height() - $(this.selectors.topbar).outerHeight(true);
		
		/* 1. save columns count for later (expand / reduce strategies - see _doLayout) */
		
		this._state.prevColumnsCount = this._state.columnsCount;		
				
		/* 2. compute new columns count */
		
		if (this.options.columnWidth <= 0)
		{
			console.error('Error computing dimensions!', this.options.columnWidth);
			throw new Error('Column width must be a positive number!');
		}
		
		this._state.columnsCount = Math.floor(this._state.width / this.options.columnWidth);		
		if (this._state.columnsCount === 0)
		{
			this._state.columnsCount = 1; // lower limitation
		}
		
		/* 3. compute new column width */
		
		this._state.columnWidth = Math.floor(this._state.width / this._state.columnsCount);
		
		//console.log(this._state.width+'x'+this._state.height+' / '+this._state.columnWidth, this._state.columnsCount, this._state.prevColumnsCount);
		
		/* 4. update options slider */
		
		if (this._state.columnsCount !== this._state.prevColumnsCount)
		{
			this._updateSliderDetails();
		}
	},
	
	_doLayout : function() {
		//console.log('jKaiten._doLayout', arguments);
		if (this._state.anims.count > 0)
		{
			console.warn('Kaiten layout delayed!');
			this._state.anims.delayedLayout = true; // try again when animations are finished
			return;
		}
		if (this.$slider.is(':hidden'))
		{
			console.info('Kaiten layout discarded!');
			return;
		}
		
		this._computeDimensions();
		
		this.$slider.css({ 
			height : this._state.height+'px'
		});
		
		// breadcrumb
		if (this._state.width !== this._state.prevWidth)
		{
			this.$breadcrumb.trigger('layout.kbreadcrumb');
		}
		
		// display more/less panels?
		var columnsDiff = this._state.columnsCount - this._state.prevColumnsCount, $anchor;
		if (columnsDiff > 0)
		{
			$anchor = this._getFirstPanel();
			this._expand($anchor, columnsDiff);
		}
		else if (columnsDiff < 0)
		{
			$anchor = this._getLastPanel();
			// do we have to reduce?				
			if ($anchor.kpanel('getEdgePosition') > this._state.columnsCount)
			{
				this._reduce($anchor, $anchor.kpanel('getEdgePosition')-this._state.columnsCount);
			}
		}
		
		// trigger visible panels layout
		this._getVisiblePanels().trigger('layout.kpanel');
	},
	
	_expand : function($anchor, colsDiff) {
		//console.log('jKaiten._expand', arguments);
		var i;
		
		// can we expand the anchor panel..?
		var remainingCols = this._expandPanel($anchor, colsDiff);
		if (remainingCols <= 0) // done
		{
			return;
		}
		
		// let's try to expand the panels@right...
		var $visibleSiblings = this._getNextPanels(':visible', $anchor);
		for (i=0; i<$visibleSiblings.length; i++)
		{
			remainingCols = this._expandPanel($visibleSiblings.eq(i), remainingCols);
			if (remainingCols <= 0) // done
			{
				return;
			}
		}
			
		// ...or the hidden panels@right come back on stage
		var lastPos = this._getLastPanel().kpanel('getEdgePosition');	
		var $nextHiddenSiblings = this._getNextPanels(':hidden', $anchor);
		
		var $targetPanel, newWidth, optimalWidth;
		for (i=0; i<$nextHiddenSiblings.length; i++)
		{
			$targetPanel = $nextHiddenSiblings.eq(i);
			newWidth = remainingCols;
			optimalWidth = $targetPanel.kpanel('getState').optimalWidth;
			if (newWidth > optimalWidth) 
			{
				newWidth = optimalWidth; // upper limitation
			}
			
			$targetPanel.kpanel('setPosition', lastPos, this._state);
			$targetPanel.kpanel('setWidth', newWidth, this._state);				
							
			remainingCols -= newWidth;
			if (remainingCols <= 0)
			{
				return; 
			}
	
			lastPos += newWidth;
		}
		
		// ...or strategy goes backwards : panels@left come back on stage
		var expandWidth = 0, croppedWidth;
		var $prevHiddenSiblings = this._getPrevPanels(':hidden', $anchor); // jQuery returns them from right to left
		
		for (i=0; i<$prevHiddenSiblings.length; i++)
		{
			$targetPanel = $prevHiddenSiblings.eq(i);
			optimalWidth = $targetPanel.kpanel('getState').optimalWidth;
			
			if ((expandWidth + optimalWidth) < remainingCols)
			{
				// include this panel
				$targetPanel.kpanel('setWidth', optimalWidth, this._state);					
				expandWidth += optimalWidth;
				$targetPanel.kpanel('setPosition', -expandWidth, this._state);
			}
			else					
			{
				// include this panel and crop it
				croppedWidth = remainingCols - expandWidth;
				$targetPanel.kpanel('setWidth', croppedWidth, this._state);
				expandWidth = remainingCols;
				$targetPanel.kpanel('setPosition', -expandWidth, this._state);
				break;
			}
		}
		
		if (expandWidth > 0)
		{
			// move visible panels to the right, add anchor becuz a previous setPosition may have hidden it
			this._getVisiblePanels().add($anchor).each(function(){
				$(this).kpanel('incPosition', expandWidth, this._state);
			});
			
			// move hidden panels to the right
			if (i === $prevHiddenSiblings.length) 
			{
				i--;
			}			
			for (i; i>=0; i--)
			{
				$targetPanel = $prevHiddenSiblings.eq(i);
				$targetPanel.kpanel('incPosition', expandWidth,  this._state);
				$targetPanel.kpanel('show');
			}
		}
	},
	
	_expandPanel: function($panel, colsDiff) {
		//console.log('jKaiten._expandPanel', arguments);
		var ps = $panel.kpanel('getState');
		var originalWidth = ps.width, optimalWidth = ps.optimalWidth;
		if (originalWidth < optimalWidth) // can we expand this panel?
		{				
			var newWidth = originalWidth + colsDiff;
			if (newWidth > optimalWidth) 
			{
				newWidth = optimalWidth; // upper limitation
			}
			$panel.kpanel('setWidth', newWidth, this._state);
			
			var self = this, widthInc = newWidth - originalWidth;
			this._getNextPanels(':visible', $panel).each(function() {
				$(this).kpanel('incPosition', widthInc, self._state);
			});
			
			return (colsDiff - widthInc); // return the remaining number of columns to expand
		}		
		return colsDiff;
	},
	
	_reduce : function($anchor, colsDiff) {
		//console.log('jKaiten._reduce', arguments);
		var i, remainingCols = colsDiff;
		
		// let's try to reduce the panels@left...
		var $visibleSiblings = this._getPrevPanels(':visible', $anchor); // jQuery returns them from right to left
		for (i=0; i<$visibleSiblings.length; i++)
		{
			remainingCols = this._reducePanel($visibleSiblings.eq(i), remainingCols);
			if (remainingCols <= 0) // done
			{
				return;
			}
		}
		
		// ...or hide them
		var totalPos = 0;
		for (i=0; i<$visibleSiblings.length; i++)
		{
			totalPos += $visibleSiblings.eq(i).kpanel('getState').width;
			//console.log(panelWidth, totalPos);
			if (totalPos >= remainingCols)
			{
				break;
			}
		}			
		remainingCols -= totalPos;
		
		// move visible panels to the left, add anchor becuz a previous setPosition may have hidden it
		this._getVisiblePanels().add($anchor).each(function() {
			$(this).kpanel('incPosition', -totalPos, this._state);
		});
		
		if (remainingCols <= 0)
		{
			return;
		}
		
		// ...or finally we can reduce the anchor panel
		remainingCols = this._reducePanel($anchor, remainingCols);
	},
	
	_reducePanel: function($panel, colsDiff) {
		//console.log('jKaiten._reducePanel', arguments);
		var ps = $panel.kpanel('getState');
		var originalWidth = ps.width;
		if (originalWidth > 1) // can we reduce this panel?
		{				
			var newWidth = originalWidth - colsDiff;
			if (newWidth < 1) 
			{
				newWidth = 1; // lower limitation
			}
			$panel.kpanel('setWidth', newWidth, this._state);
			
			var self = this, widthInc = originalWidth - newWidth;
			this._getNextPanels(':visible', $panel).each(function() {
				$(this).kpanel('incPosition', -widthInc, self._state);
			});

			return (colsDiff - widthInc); // return the remaining number of columns to reduce
		}
		return colsDiff;
	},
	
	_createNewPanel : function(connector, data, $src, $childPanel) {
		//console.log('jKaiten._createNewPanel', arguments);
		var $newPanel, optimalWidth = data.kWidth || 1;
		var options;
		
		// reuse child panel, if any
		if ($childPanel.length > 0)
		{
			this.removeChildren($childPanel);
			
			$newPanel = $childPanel;
			
			options = {
				$src			: $src,
				optimalWidth	: optimalWidth,
				title			: 'Loading...',
				connector		: connector,				
				cssClass		: connector.cssClass||'',
				optionsHTML		: this.options.panelOptionsHTML
			};
			
			var fs = $newPanel.kpanel('getState', true);
			if ((fs.position < 0) || (fs.position >= this._state.columnsCount))
			{
				options.position = this._state.columnsCount; // previous slideTo calls may have changed its position
				options.width = 1; // must be for the placement strategy				
			}
			
			// update options
			$newPanel.kpanel(options);
			
			var visible = (fs.position >= 0) && (fs.position < this._state.columnsCount);
			this.$breadcrumb.kbreadcrumb('toggleVisibility', fs.index, visible);
		}
		else // create a brand new one
		{
			var newIndex = this._state.panelsCreated;
			this._state.panelsCreated += 1;
			var newID = this.selectors.panelIDPrefix + this._state.panelsCreated;
			var newPosition = this._getLastAvailablePos();
			
			$newPanel = $('<div/>').appendTo(this.$slider);
			
			options = {
				$src			: $src,
				index			: newIndex,
				id				: newID,
				position		: newPosition,
				width			: 1,
				optimalWidth	: optimalWidth,
				title			: 'Loading...',
				connector		: connector,				
				cssClass		: connector.cssClass||'',
				optionsHTML		: this.options.panelOptionsHTML
			};
			
			$newPanel.kpanel(options);
			
			// add to breadcrumb
			this.$breadcrumb.kbreadcrumb('add', options);
		}
		
		this.setPanelFocus($newPanel);
				
		return $newPanel;
	},
	
	_nextPlacement : function($panel, widthDiff, callback){
		//console.log('jKaiten._nextPlacement', arguments);		
		// resize
		$panel.kpanel('animate', null, widthDiff, this._state, callback);	
		// place panels @right
		var self = this;
		this._getNextPanels(':visible', $panel).each(function(){
			self._nextPanelPlacement($(this), widthDiff);
		});
	},
	
	_nextPanelPlacement : function($panel, posInc){
		//console.log('jKaiten._nextPanelPlacement', arguments);
		var futureState = $panel.kpanel('getState', true);		
		var targetPos = futureState.position + posInc, targetRightEdge = targetPos + futureState.width;					
		if (targetRightEdge > this._state.columnsCount)
		{
			// check if panel overlaps on the right edge of the visible area
			if (targetPos < this._state.columnsCount)
			{
				// go to right edge or already @ right edge?
				var resizeInc = ((futureState.position + futureState.width) < this._state.columnsCount) ? -(targetRightEdge - this._state.columnsCount) : -posInc;
				$panel.kpanel('animate', posInc, resizeInc, this._state);
				return; // done
			}
			else if (targetPos >= this._state.columnsCount) // animation cosmetics
			{
				// exit position : go hide just outside of the visible area		
				posInc = this._state.columnsCount - futureState.position; 
			}
		}
		
		// slide
		$panel.kpanel('animate', posInc, null, this._state);
	},
	
	_prevPlacement : function($panel, posInc, callback) {
		//console.log('jKaiten._prevPlacement', arguments);
		// resize
		$panel.kpanel('animate', posInc, null, this._state, callback);			
		// place panels @left
		var self = this;
		this._getPrevPanels(':visible', $panel).each(function(){
			self._prevPanelPlacement($(this), posInc);
		});
	},
	
	_prevPanelPlacement: function($panel, posInc) {	
		//console.log('jKaiten._prevPanelPlacement', arguments);
		// we use future state when dealing with animations
		var futureState = $panel.kpanel('getState', true);			
		var targetPos = futureState.position + posInc;
		if (targetPos < 0)
		{
			var targetRightEdge = targetPos + futureState.width;		
			// check if panel overlaps on the left edge of the visible area
			if (targetRightEdge > 0)
			{
				if (futureState.position > 0) // go to left edge?
				{
					// go to left edge and resize
					$panel.kpanel('animate', -futureState.position, targetPos, this._state); 
				}
				else // already @ left edge (position=0)
				{
					$panel.kpanel('animate', null, posInc, this._state); // stay there and resize
				}					
				return; // done
			}
			else if (targetRightEdge < 0) // animation cosmetics
			{
				// exit position : go hide just outside of the visible area		
				posInc = -(futureState.position + futureState.width); 
			}
		}

		// slide
		$panel.kpanel('animate', posInc, null, this._state);
	},	
	
	// TODO: DOMless?
	_getVisiblePanels : function(index) {
		//console.log('jKaiten._getVisiblePanels', arguments);
		var $collection = this.$slider.children(this.selectors.panel+':visible');
		if (index)
		{
			$collection = $collection.eq(index);
		}
		return $collection;
	},
	
	// TODO: DOMless?
	_getFirstPanel : function() {
		//console.log('jKaiten._getFirstPanel', arguments);
		return this._getVisiblePanels().first();
	},
	
	// TODO: DOMless?
	_getLastPanel : function() {
		//console.log('jKaiten._getLastPanel', arguments);
		return this._getVisiblePanels().last();
	},
	
	// TODO: DOMless?
	_getNextPanels : function(visibilitySelector, baseSelector, andSelf) {
		//console.log('jKaiten._getNextPanels', arguments);
		if (andSelf === true)
		{
			return $(baseSelector).nextAll(this.selectors.panel+visibilitySelector).andSelf();
		}
		return $(baseSelector).nextAll(this.selectors.panel+visibilitySelector);
	},

	// TODO: DOMless?
	_getPrevPanels : function(visibilitySelector, baseSelector) {
		//console.log('jKaiten._getPrevPanels', arguments);
		return $(baseSelector).prevAll(this.selectors.panel+visibilitySelector);
	},	
	
	_getLastAvailablePos : function() {
		//console.log('jKaiten._getLastAvailablePos', arguments);
		var pos = 0; // default
		var $p = this._getLastPanel();
		if ($p.length > 0)
		{
			pos = $p.kpanel('getEdgePosition');
			if (pos > this._state.columnsCount) // just in case
			{
				pos = this._state.columnsCount;
			}
		}
		//console.log('available', pos);
		return pos;
	},
	
	// TODO: DOMless?
	_sortHiddenPanels: function($panels, startPos)
	{
		//console.log('jKaiten._sortHiddenPanels', arguments);
		var optimalWidth;
		
		var currentPos = startPos;
		if (currentPos > 0)
		{
			$panels.each(function(){
				optimalWidth = $(this).kpanel('getState').optimalWidth;
				$(this).kpanel('setPosition', currentPos);
				$(this).kpanel('setWidth', optimalWidth);
				currentPos += optimalWidth;
			});
		}
		else
		{
			$panels.each(function(){
				optimalWidth = $(this).kpanel('getState').optimalWidth;
				currentPos -= optimalWidth;
				$(this).kpanel('setPosition', currentPos);					
				$(this).kpanel('setWidth', optimalWidth);
			});
		}
	},

	_setPanelFocus : function(panelIndex) {
		this._setNavItemFocus(null);
		document.activeElement.blur();
		
		var selPrefix = '#'+this.selectors.panelIDPrefix;
		this.element.find(selPrefix+(this._state.focus.panelIndex+1)).removeClass(this.selectors.focusClass);
		this._state.focus.panelIndex = panelIndex;
		this.element.find(selPrefix+(panelIndex+1)).addClass(this.selectors.focusClass).children(this.selectors.panelItems.body).focus();
	},

	_getFocusedPanel : function() {
		var selPrefix = '#'+this.selectors.panelIDPrefix;
		return this.element.find(selPrefix+(this._state.focus.panelIndex+1));
	},

	_setNavItemFocus : function(newIndex, noScroll) {
		//console.log('jKaiten._setNavItemFocus', arguments);
		var $focusedPanel = this._getFocusedPanel();
		var panelState = $focusedPanel.kpanel('getState');
		var $navItems = panelState.$navItems || $focusedPanel.kpanel('buildNavItemsCollection');
		var l = $navItems.length;
		if (l === 0)
		{
			this._state.focus.navItemIndex = null;
			return;
		}
		
		if (this._state.focus.navItemIndex !== null)
		{
			$navItems.eq(this._state.focus.navItemIndex).removeClass(this.selectors.focusClass).removeAttr('tabindex');
		}

		if (newIndex === null)
		{
			this._state.focus.navItemIndex = null; // null case ok
			return;
		}
				
		if (newIndex === 'firstdown')
		{
			newIndex = (panelState.$activeItem.length > 0) ? $navItems.index(panelState.$activeItem) + 1 : 0;
		}
		else if (newIndex ===  'firstup')
		{
			newIndex = (panelState.$activeItem.length > 0) ? $navItems.index(panelState.$activeItem) - 1 : l - 1;
		}
		
		if (newIndex >= l)
		{
			this._state.focus.navItemIndex = 0;
		}
		else if (newIndex < 0)
		{
			this._state.focus.navItemIndex = l - 1;
		}
		else
		{
			this._state.focus.navItemIndex = newIndex;
		}
		
		var $focusedItem = $navItems.eq(this._state.focus.navItemIndex);
		$focusedItem.addClass(this.selectors.focusClass).attr('tabindex', -1).focus();
		
		if (noScroll === true)
		{
			return;
		}

		var $body = $focusedItem.closest(this.selectors.panelItems.body);
		var top = $focusedItem.offset().top - $body.offset().top;
		var height = $focusedItem.height(), bottom = top + height;
		var bodyHeight = $body.height(), bodyScroll = $body.scrollTop();

		if (bottom > bodyHeight)
		{
			$body.scrollTop(bottom + 8 + bodyScroll - bodyHeight);
		}
		else if (top < 0)
		{
			$body.scrollTop(top + bodyScroll - 8);
		}	
	},
	
	_onType : function(keychar) {
		//console.log('jKaiten._onType', arguments);
		var $focusedPanel = this._getFocusedPanel();
		var $navItems = $focusedPanel.kpanel('getState').$navItems || $focusedPanel.kpanel('buildNavItemsCollection');
		if ($navItems.length === 0)
		{
			this._state.focus.typing = '';
			return;
		}
		var self = this;
		
		this._state.focus.typing += keychar.toLowerCase();
		
		clearTimeout(this._state.focus.timeoutID);
		this._state.focus.timeoutID = setTimeout(function() {
			self._state.focus.typing = '';
		}, this._constants.clearTypeDelay);

		//console.log('typing', this._state.focus.typing);
		
		// here we find the link starting with this._state.focus.typing...		
		$navItems.each(function(i){
			if ($(this).text().toLowerCase().indexOf(self._state.focus.typing) === 0)
			{
				self._setNavItemFocus(i);
				return false;
			}
		});
	},

	/* PUBLIC API */

	findLoaderData : function(url, $link, $target) {
		//console.log('jKaiten.findLoaderData', arguments);
		var i, connector, fallback = true;
		var linkData = {}, loadData = {};
		// prevent connectables functions to test null objects
		$link = $link || $('');
		$target = $target || $('');
					
		for (i in this._state.connectors)
		{
			if (this._state.connectors.hasOwnProperty(i))
			{
				connector = this._state.connectors[i];
				if ($.isFunction(connector.connectable) && connector.connectable.call(connector, url, $link, $target) === true)
				{
					loadData = { kConnector : i };
					if ($.isFunction(connector.getData))
					{
						linkData = connector.getData.call(connector, url, $link, $target);
						$.extend(loadData, linkData);
					}						
					fallback = false;
					break;
				}
			}
		}
		
		if (fallback === true)
		{
			loadData = { kConnector : 'iframe' };
			loadData.url = url;
		}
		
		//console.log('Resolved on '+loadData.kConnector, 'data=', loadData);
		
		return loadData;
	},
	
	registerConnector : function(name, connector) {
		//console.log('jKaiten.registerConnector', arguments);
		if (this._state.connectors[name])
		{
			throw new Error('Error registering connector : connector "'+name+'": already exists!');			
		}		
		if (connector.init && !$.isFunction(connector.init))
		{
			throw new Error('Error registering connector "'+name+'": "init" is not a function!');
		}
		if (connector.destroy && !$.isFunction(connector.destroy))
		{
			throw new Error('Error registering connector "'+name+'": "destroy" is not a function!');
		}
		if (connector.loader && !$.isFunction(connector.loader))
		{
			throw new Error('Error registering connector "'+name+'": "loader" is not a function!');
		}
		if (connector.connectable && !$.isFunction(connector.connectable))
		{
			throw new Error('Error registering connector "'+name+'": "connectable" is not a function!');
		}
		if (connector.getData && !$.isFunction(connector.getData))
		{
			throw new Error('Error registering connector "'+name+'": "getData" is not a function!');
		}
		
		var classes = '', nameParts = name.split('.');
		if (nameParts.length === 2)
		{
			classes += ' '+nameParts[0].replace(/[^a-zA-Z0-9]/g, '-');
		}
		classes += ' '+name.replace(/[^a-zA-Z0-9]/g, '-');
		
		this._state.connectors[name] = $.extend(connector, { name : name, initialized : false, cssClass : classes });
		//console.log(this._state.connectors);
		
		if (connector.cssFile && !this._state.css[connector.cssFile])
		{
			this._state.css[connector.cssFile] = true;
			var l = document.createElement('link');
			l.setAttribute("type","text/css");
			l.setAttribute("rel","stylesheet");
			l.setAttribute("href", connector.cssFile);
			document.getElementsByTagName("head")[0].appendChild(l);
		}
	},
	
	unRegisterConnector : function(name) {
		//console.log('jKaiten.unRegisterConnector', arguments);
		if (this._state.connectors[name])
		{
			if (this._state.connectors[name].destroy)
			{
				this._state.connectors[name].destroy.call(this._state.connectors[name], this.element);
			}
			delete this._state.connectors[name];
		}
	},
	
	getConnector : function(name) {
		//console.log('jKaiten.getConnector', arguments);
		//console.log(this._state.connectors);
		if (!this._state.connectors[name])
		{
			throw new Error('Cannot retrieve connector "'+name+'"!');
		}
		return this._state.connectors[name];
	},

	// #1 : load(function, [{data}], [$src])
	// #2 : load({data}, [$src])
	// #3 : load('html', [$src])
	load : function() {
		//console.log('jKaiten.load', arguments);
		/* 0. a little preparation */
		var connector, data, $src, $panel, args = arguments;
		if ($.isFunction(args[0]))
		{
			connector = {
				loader		: args[0] ,
				name		: '',
				initialized	: false
			};
			data = args[1] || {};
			data.kConnector = '';
			$src = args[2] || $('');
		}
		else if ($.isPlainObject(args[0]))
		{
			data = args[0];
			if (data.kConnector)
			{
				connector = ($.type(data.kConnector) === 'string') ? this.getConnector(data.kConnector) : data.kConnector;
			}
			else if ($.isFunction(data.kLoader))
			{
				connector = {
					loader		: data.kLoader,
					name		: '',
					initialized	: false
				};
				data.kConnector = '';
			}
			$src = args[1] || $('');
		}
		else if ($.type(args[0]) === 'string')
		{
			connector = {
				loader		: function(){ return args[0]; },
				name		: '',
				initialized	: false
			};
			data = {};
			data.kConnector = '';
			$src = args[1] || $('');
		}
		if (!connector)
		{
			throw new Error('Cannot load. No connector!');
		}
		
		// initialize connector at first use only		
		if ((connector.initialized === false) && $.isFunction(connector.init))
		{
			connector.init.call(connector, this.element);
			connector.initialized = true;
		}
		
		// update active item		
		if ($src.length > 0)
		{			
			$panel = $src.closest(this.selectors.panel);
			$panel.kpanel('setActiveItem', $src);
		}
    	
    	// add this Kaiten's data
		data.kTabID = this._state.tabID;
		
		/* 1. panel creation */
		
		// retrieve child panel in order to reuse it, if any (TODO: DOMless?)
		var $childPanel = ($src.length > 0) ? $panel.next(this.selectors.panel) : $('');
		var $newPanel = this._createNewPanel(connector, data, $src, $childPanel);
		
		//console.log('panel loaded', $newPanel);
		
		/* 2. placement strategy, if necessary */
		
		var dfdAnim = null;
		
		// NB: use panel's future state when dealing with animations
		if ($newPanel.kpanel('getState', true).position >= this._state.columnsCount)
		{	
			if (($childPanel.length === 0) || !$childPanel.kpanel('isAnimated'))
			{
				$newPanel.show();
				
				// create a deferred animation to sync with content loading			
				dfdAnim = $.Deferred();
				$newPanel.kpanel('animate', -1, null, this._state, function(){
					dfdAnim.resolve();
				});
				
				var $prevPanels = this._getPrevPanels(':visible', $newPanel);
				var $leftMostPanel = $prevPanels.last();
				if ($leftMostPanel.kpanel('getState', true).width > 1) // check if leftmost panel can be resized
				{
					var i;
					$leftMostPanel.kpanel('animate', null, -1, this._state);
					for (i=0, l=$prevPanels.length; i<l-1; i++)
					{
						$prevPanels.eq(i).kpanel('animate', -1, null, this._state);		
					}
				}
				else // eject leftMost panel
				{
					$prevPanels.kpanel('animate', -1, null, this._state);
				}
			}
		}

		/* 3. ask panel to load its content */
		
		try
		{
			$newPanel.kpanel('load', data, dfdAnim);
			return $newPanel;
		}
		catch (e)
		{
			console.error('Error loading panel!');
			throw e;
		}
		
		return $newPanel;
	},
	
	reload : function($panel, data, keepChildren) {
		//console.log('jKaiten.reload', arguments);
		$panel.kpanel('reload', data, keepChildren);
	},
	
	remove : function($panel) {
		//console.log('jKaiten.remove', arguments);
		this.removeChildren($panel, true);
	},
	
	 // TODO: DOMless?
	removeChildren : function($panel, andSelf) {
		//console.log('jKaiten.removeChildren', arguments);
		var $set, $children = $panel.nextAll(this.selectors.panel);
		if (andSelf === true)
		{
			index = $panel.kpanel('getState').index;
			$set = $children.andSelf();
		}
		else
		{
			index = $children.first().kpanel('getState').index;
			$set = $children;
			if ($set.length === 0)
			{
				return;
			}
		}
		this.$breadcrumb.kbreadcrumb('cut', index);
		$set.kpanel('destroy');

		if ((this._getVisiblePanels().length == 0) && (this._state.panelsCreated > 0))
		{
			this.slideTo(this.getPanel(this._state.panelsCreated-1));
		}
	},
	
	newTab : function(data, title) {
		//console.log('jKaiten.newTab', arguments);
		var newTabData = $.extend({}, data);
		if (newTabData.kTabID)
		{
			delete newTabData.kTabID;
		}
		
		// prevent bug
		var i;
		for (i in newTabData)
		{
			if ($.isFunction(newTabData[i]))
			{
				delete newTabData[i];
				continue;
			}
			if (newTabData.hasOwnProperty(i) && (newTabData[i] instanceof jQuery))
			{
				console.warn('Parameter "'+i+'" is an instance of jQuery. You may encounter navigation issues.');
				newTabData[i] = $('<div />').append(newTabData[i].clone()).html(); // "outerHTML"
				continue;
			}
		}
		
		var newURL = document.location.protocol + '//' +  document.location.host + document.location.pathname;
		var params = $.param(newTabData);
		newURL += '?' + params;
		window.open(newURL, params);
	},
	
	next : function() {
		//console.log('jKaiten.next', arguments);
		// discard if animation is in progress
		if (this._state.anims.count > 0)
		{
			return;
		}
		
		var $p = this._getLastPanel().next(this.selectors.panel); // TODO: DOMless?
		if ($p.length > 0)
		{	
			this.setPanelFocus($p);
			
			// place just outside and expand to optimal width
			$p.kpanel('setPosition', this._state.columnsCount);
			var newWidth = $p.kpanel('setWidthToOptimal', this._state);
			$p.kpanel('toggle', true);
			
			// slide and place panels @left
			var self = this;
			
			$p.kpanel('animate', -newWidth, null, this._state, function(){
				this.children(self.selectors.panelItems.body).focus(); // autofocus
			});			
			
			this._getPrevPanels(':visible', $p).each(function(){
				self._prevPanelPlacement($(this), -newWidth);
			});
		}
	},
	
	prev : function() {
		//console.log('jKaiten.prev', arguments);
		// discard if animation is in progress
		if (this._state.anims.count > 0)
		{
			return;
		}
		
		var $p = this._getFirstPanel().prev(this.selectors.panel); // TODO: DOMless?
		if ($p.length > 0)
		{
			this.setPanelFocus($p);
			
			// expand to optimal width
			var newWidth = $p.kpanel('setWidthToOptimal', this._state);
			$p.kpanel('setPosition', -newWidth);
			$p.kpanel('toggle', true);
			
			// slide and place panels @right
			var self = this;
			
			$p.kpanel('animate', newWidth, null, this._state, function(){
				this.children(self.selectors.panelItems.body).focus(); // autofocus
			});
						
			this._getNextPanels(':visible', $p).each(function(){
				self._nextPanelPlacement($(this), newWidth);
			});
		}
	},
	
	maximize : function($panel) {
		//console.log('jKaiten.maximize', arguments);
		// discard if animation is in progress
		if (this._state.anims.count > 0)
		{
			return;
		}
		
		var self = this, $this, ps;
		
		this._getPrevPanels(':visible', $panel).each(function(){
			$this = $(this);
			$this.kpanel('animate', -$this.kpanel('getEdgePosition', true), null, self._state);
		});
		
		this._getNextPanels(':visible', $panel).each(function(){
			$this = $(this);
			ps = $this.kpanel('getState', true);
			$this.kpanel('animate', self._state.columnsCount-ps.position, null, self._state);
		});
		
		ps = $panel.kpanel('getState', true);
		$panel.kpanel('animate', -ps.position, this._state.columnsCount-ps.width, this._state);
	},
	
	originalSize : function($panel) {
		//console.log('jKaiten.originalSize', arguments);
		if (this._state.anims.count > 0)
		{
			return;
		}
		this.slideTo($panel);
	},
	
	slideTo : function($targetPanel) {
		//console.log('jKaiten.slideTo', arguments);
		// discard if animation is in progress
		if (this._state.anims.count > 0)
		{
			return;
		}
		
		this.setPanelFocus($targetPanel);
		
		var $visiblePanels = this._getVisiblePanels(); // TODO: DOMless?
		var $firstPanel = $visiblePanels.first();

		/* 1st : update hidden positions and widths : panels outside of the visible area */
		
		this._sortHiddenPanels(this._getPrevPanels(':hidden', $firstPanel), 0);
		this._sortHiddenPanels(this._getNextPanels(':hidden', $firstPanel), this._state.columnsCount);		
		
		/* 2nd : fit a max. number of panels in the visible area, the target being leftmost */
		
		var $currentPanel = $targetPanel;
		var totalWidth = this._state.columnsCount, optimalWidth;
		var animsParams = [];
		var panelsIDs = [];
		
		// from the anchor, to the right...
		
		do
		{
			panelsIDs.push($currentPanel.attr('id')); // for later...
			optimalWidth = $currentPanel.kpanel('getState').optimalWidth;
			animsParams.push({
				$panel : $currentPanel,
				futureWidth : optimalWidth
			});
			totalWidth -= optimalWidth;
			$currentPanel = $currentPanel.next(this.selectors.panel); // TODO: DOMless?
		}
		while ((totalWidth > 0) && ($currentPanel.length > 0));
		
		// crop last panel?
		if (totalWidth < 0)
		{
			animsParams[animsParams.length-1].futureWidth += totalWidth;			
		}
		else if (totalWidth > 0) 
		{
			// from the anchor, to the left...
			$currentPanel = $targetPanel.prev(this.selectors.panel); // TODO: DOMless?
			while ((totalWidth > 0) && ($currentPanel.length > 0))
			{
				panelsIDs.push($currentPanel.attr('id')); // for later...
				optimalWidth = $currentPanel.kpanel('getState').optimalWidth;
				animsParams.unshift({
					$panel : $currentPanel,
					futureWidth : optimalWidth
				});
				totalWidth -= optimalWidth;
				$currentPanel = $currentPanel.prev(this.selectors.panel); // TODO: DOMless?
			}
			// crop first panel?
			if (totalWidth < 0)
			{
				animsParams[0].futureWidth += totalWidth;
			}
		}
			
		//console.log(animsParams);
		
		/* 3rd : animate */
		
		// a) visible panels not concerned by the previous computation : eject them
		var $visibleSubset = [];
		$visiblePanels.each(function(){
			if ($.inArray($(this).attr('id'), panelsIDs) === -1)
			{
				$visibleSubset.push($(this));
			}
		});
		//console.log($visibleSubset);
				
		var i, l = $visibleSubset.length;
		if (l > 0)
		{
			var ejectPosInc;
			if ($visibleSubset[0].nextAll('#'+$targetPanel.attr('id')).length > 0) // target @right? (TODO: DOMless?)
			{
				ejectPosInc = -$visibleSubset[l-1].kpanel('getEdgePosition', true);
				for (i=0; i<l; i++)
				{
					$currentPanel = $visibleSubset[i];
					$currentPanel.kpanel('animate', ejectPosInc, null, this._state);
				}
			}
			else // target @left? 
			{
				ejectPosInc = this._state.columnsCount - $visibleSubset[0].kpanel('getState', true).position;
				for (i=0; i<l; i++)
				{
					$currentPanel = $visibleSubset[i];
					$currentPanel.kpanel('animate', ejectPosInc, null, this._state);
				}
			}
		}
		
		// b) panels concerned
		var futurePos = 0;
		for (i=0, l=animsParams.length; i<l; i++)
		{				
			var ap = animsParams[i];
			var fs = ap.$panel.kpanel('getState', true);
			//console.log(ap.$panel);
			//console.log('p='+fs.position, futurePos, 'w='+fs.width, ap.futureWidth);
			ap.$panel.show().kpanel('animate', futurePos-fs.position, ap.futureWidth-fs.width, this._state);
			futurePos += ap.futureWidth;
		}
	},
	
	setPanelFocus : function($panel){
		//console.log('jKaiten.setPanelFocus', arguments);
		this._setPanelFocus($panel.kpanel('getState').index);
	},
	
	setPanelAutoFocus : function(){
		//console.log('jKaiten.setPanelAutoFocus', arguments);
		this._setNavItemFocus('firstdown', true); // no scroll
	},
	
	toggleTopbar : function(enableOrDisable){
		//console.log('jKaiten.toggleTopbar', arguments);
		this.element.find(this.selectors.topbarMask).toggle(!enableOrDisable);
	},
	
	setColumnsCount : function(count) {
		//console.log('jKaiten.setColumnsCount', arguments);
		if (this._state.anims.count > 0)
		{
			return;
		}
		// update the column width option and let _computeDimensions calculate the new columns count
		if (!count || (count <= 0))
		{
			console.error('Error setting columns count!', count);
			throw new Error('New columns count must be a positive number!');
		}
		//this.options.columnWidth = Math.ceil((((2 * count) - 1) / (2 * count * count)) * $(window).width() * 0.1) * 10;
		this.options.columnWidth = Math.floor($(window).width()/count);
		this._doLayout();
	},
	
	setColumnWidth : function(width) {
		//console.log('jKaiten.setColumnWidth', arguments);
		if (this._state.anims.count > 0)
		{
			return;
		}
		// update the column width option and let _computeDimensions calculate the new columns count
		if (!width || (width <= 0))
		{
			console.error('Error setting column width!', width);
			throw new Error('New column width must be a positive number!');
		}
		this.options.columnWidth = width;
		this._doLayout();
	},
	
	getState : function() {
		//console.log('jKaiten.getState', arguments);
		return this._state;
	},
	
	getPanel : function(index){
		//console.log('jKaiten.getPanel', arguments);
		return this.$slider.children(this.selectors.panel).eq(index);
	}
};

(function($, window) {
	if (!window.console)
	{
		window.console = 
		{
			log				: function() {},
			debug			: function() {},
			info			: function() {},
			warn			: function() {},
			exception		: function() {},
			assert			: function() {},
			dir				: function() {},
			dirxml			: function() {},
			trace			: function() {},
			group			: function() {},
			groupEnd		: function() {},
			groupCollapsed	: function() {},
			time			: function() {},
			timeEnd			: function() {},
			profile			: function() {},
			profileEnd		: function() {},
			count			: function() {},
			clear			: function() {},
			table			: function() {},
			error			: function() {},
			notifyFirebug	: function() {}
		};
	}
	
	// helper
    $.fn.getPanel = function (){
        var $p;
        if (!this.length)
        {
            console.warn('Panel Not Found: jQuery object is empty!');
            return;
        }
        if (this.hasClass(jKaiten.selectors.panel))
        {
            return this;
        }
        $p = this.closest(jKaiten.selectors.panelClass);
        if (!$p.length)
        {
        	console.log(this);
            $.error('Panel Not Found!');
        }
        return $p;
    };

	if (!window.kConnectors)
	{
		window.kConnectors = {};
	}
	
	$.widget("ui.kaiten", jKaiten);
}(jQuery, window));

/**
 * Kaiten panel
 *
 * @version 2011-06-16
 *
 */

(function($) {
	$.widget("ui.kpanel", {
		/* DEFAULT PROPERTIES/METHODS */
		
		// default widget property : options (a mix of defaults with settings provided by the user)
		options : {
			$src			: $(''),
			index			: -1,
			id				: '',
			position		: -1,
			width			: 1,
			optimalWidth	: 1,
			connector		: null,
			title			: 'New panel',
			cssClass		: '',
			afterload		: null,
			afterlayout		: null,
			beforedestroy	: null,
			optionsHTML		: ''
		},
		
		// default widget method : creation
		_create : function() {
			//console.log('kPanel._create', arguments, this.options);
			
			/* 1. define useful variables */
			
			this.$K = $(jKaiten.selectors.window).parent();
			var ks = this.$K.kaiten('getState');
			this.$breadcrumb = this.$K.find(jKaiten.selectors.breadcrumb);
			
			this._state = {
				index				: this.options.index,
				position			: this.options.position,
				width				: (this.options.width > ks.columnsCount) ? ks.columnsCount : this.options.width,
				isVisible			: (this.options.position >= 0) && (this.options.position < ks.columnsCount),
				load 				: {	},
				$activeItem			: $(''),
				$navItems			: null
			};
			
			this.setOptimalWidth(this.options.optimalWidth, ks); // crop if needed
			
			// keep track of the future state for calculations during animation
			this._futureState = {				
				position	: this._state.position,
				width		: this._state.width,
				index		: this._state.index // set here just to limit function calls
			};
						
			/* 2. HTML markup and DOM insertion */
			
			// class, id, position attributes
			this.element.addClass(jKaiten.selectors.panelClass).attr({
				'id' 	: this.options.id
			});
			
			this._constants.padding	= parseInt(this.element.css('paddingLeft'), 10) + parseInt(this.element.css('paddingRight'), 10);
			
			// mask and loader animation
			$('<div />', {
				"class" : jKaiten.selectors.maskClass
			}).append($('<div />', { 
				"class" : jKaiten.selectors.loaderClass
			})).appendTo(this.element).show();
			
			// title bar
			this._createTitleBar();
			
			// panel options
			var $options = $('<div />', {
				"class" : jKaiten.selectors.panelItems.optionsClass
			});
			$options.append($(this.options.optionsHTML).clone(true));
			$options.appendTo(this.element);
			
			// header
			$('<div />', { 
				"class" : jKaiten.selectors.panelItems.headerClass 
			}).appendTo(this.element);
						
			// body
			this.$body = $('<div />', { 
				"class" : jKaiten.selectors.panelItems.bodyClass 
			}).appendTo(this.element);

			// we'll need this value to set panel width later
			this._constants.padding	= parseInt(this.element.css('paddingLeft'), 10) + parseInt(this.element.css('paddingRight'), 10);
			
			/* 3. bind events */
			
			this._bindEvents();
			
			//this._log();
		},
		
		// default widget method : option settings
		_setOption : function(key, value) {
			//console.log('kPanel._setOption', arguments);
			switch (key)
			{
				case 'position':
					this.setPosition(value);
					break;
				
				case 'width':
					this.setWidth(value);
					break;
					
				case 'optimalWidth':
					this.setOptimalWidth(value);
					break;
					
				case 'cssClass':
					// do nothing, wait for _insertHTML so that existing content remains correctly displayed
					//this._setCSSClass(value);
					break;
				
				case 'title':
					this.setTitle(value);
					break;
					
				case 'optionsHTML':
					this.element.find(jKaiten.selectors.panelItems.options).empty().append($(value).clone(true));
					break;
				
				default:
					break;
			}
			
			$.Widget.prototype._setOption.apply(this, arguments);
			
			//console.log(this.options);
		},
		
		// default widget method : destruction (removes the instance from the encapsulated DOM element, which was stored on instance creation)
		destroy : function() {
			//console.log('kPanel.destroy', this.element);
			this._trigger('beforedestroy', 0, [this.element, this.$K]);
			
			// request in progress
			if (this._state.load.dfd && $.isFunction(this._state.load.dfd.abort))
			{
				this._state.load.dfd.abort(); // abort the current request
			}
						
			// handlers, empty, remove
			this.element.unbind().undelegate();
			this.element.empty().remove();
			
			this.$K.trigger('afterdestroy.kpanel'); // notify Kaiten
			
			// src element has to be deactivated
			this.options.$src.removeClass(jKaiten.selectors.activeClass);
			
			// execute default method
			$.Widget.prototype.destroy.apply(this, arguments);
		},
		
		/* PROPERTIES, CONSTANTS, ... */
		
		_state : {
		},
		
		_constants : {
		},
		
		/* INTERNAL FUNCTIONS */
		
		_log : function() {
			var state = this._state;
			console.group('Panel ID='+this.options.id);
			console.log(this.element);
			console.log('options', this.options);
			console.log('states', this._state, this._futureState);
			console.log('constants', this._constants);
			console.groupEnd();
		},
		
		_bindEvents: function() 
		{
			//console.log('kPanel._bindEvents', arguments);
			var self = this;
			
			// layout
			this.switchLayoutMode('default');
			
			// change of content
			this.element.bind('DOMNodeInserted DOMNodeRemoved', function(e){
				//console.log('DOMNode* event', self.element, e.type, e.target, e);
				self._state.$navItems = null; // force rebuild when needed
			});
		},
		
		_createTitleBar: function(){
			//console.log('kPanel._createTitleBar', arguments);
			var panelItemsSelectors = jKaiten.selectors.panelItems;
			
			// create title bar
			var html = '<table>'+
							'<tr>'+
								'<td class="'+panelItemsSelectors.leftToolbarClass+'">'+
								'</td>'+
								'<td class="'+panelItemsSelectors.titleContainerClass+'">'+
									'<div class="'+panelItemsSelectors.titleClass+'">'+
										this.options.title+
									'</div>'+
								'</td>'+
								'<td class="'+panelItemsSelectors.rightToolbarClass+'">'+
								'</td>'+
							'</tr>'+
						'</table>';
			var $table = $(html);
			
			var i, l, t, $a;
			
			// add left toolbar
			for (i=0, l=jKaiten._constants.panelLeftTools.length; i<l; i++)
			{
				t = jKaiten._constants.panelLeftTools[i];
				$tool = $('<button />', {
					"class"		: panelItemsSelectors.toolClass+' '+t.className,
					"title"		: t.title
				});
				$table.find('.left').append($tool);
			}
			
			// add right toolbar
			for (i=0, l=jKaiten._constants.panelRightTools.length; i<l; i++)
			{
				t = jKaiten._constants.panelRightTools[i];
				$tool = $('<button />', {
					"class"		: panelItemsSelectors.toolClass+' '+t.className,
					"title"		: t.title
				});
				$table.find('.right').append($tool);
			}
			
			// append to DOM
			this.$titleBar = $('<div />', {
				"class" : panelItemsSelectors.titleBarClass
			}).append($table).appendTo(this.element);
		},
		
		_setCSSClass : function(className) {
			//console.log('kPanel._setCSSClass', arguments);
			var classes = jKaiten.selectors.panelClass;
			if (this.element.hasClass(jKaiten.selectors.focusClass))
			{
				classes += ' '+jKaiten.selectors.focusClass;
			}
			classes += ' '+className;
			this.element.attr('class', classes);
		},
		
		_insertHTML : function(html) {
			//console.log('kPanel._insertHTML', arguments);
			var self = this, $html = $(html);

			this.element.find(jKaiten.selectors.panelItems.options).hide();

			this.element.find(jKaiten.selectors.panelItems.header).remove();
			this.$body.remove();
			this.element.unbind().undelegate();
			
			// this will also handle server-side errors 
			if (($html.filter('.'+jKaiten.selectors.panelItems.bodyClass).length === 0) && 
					($html.filter('.'+jKaiten.selectors.panelItems.headerClass).length === 0)) 
			{
				$html = $('<div />', {
					"class": jKaiten.selectors.panelItems.blockClass,
					"html" : html
				});
				$html = $('<div />', {
					"class" : jKaiten.selectors.panelItems.bodyClass
				}).append($html);
			}
			
			this.element.append($html.not('script'));
			this._setCSSClass(this.options.cssClass);
			this._bindEvents();
						
			this.$body = this.element.find(jKaiten.selectors.panelItems.body);
			this.$body.scrollTop(0);
			
			// scrollability
			if ((this._state.layoutMode === 'default') && (this.$K.kaiten('getState').hasTouchScreen === true))
			{
				this.$body.addClass('scrollable vertical');
			}
			
			// execute scripts in the panel DOM element context
			$html.filter('script').each(function() {
				if ((this.language === 'javascript') || (!this.language && !this.src))
				{
					var $this = $(this);
					$.globalEval('(function(){'+
						'try {'+
							$this.text()+
						'} catch(e){'+
							'console.group("Exception caught executing panel Javascript!");'+
							'console.warn(e);'+
							'console.trace();'+
							'console.groupEnd();'+
						'}'+
					'}).apply($("#'+self.options.id+'.'+jKaiten.selectors.panelClass+'")[0]);');
				}
			});

			this.toggleLoader(false);
			this.element.trigger('layout.kpanel');
			this.$K.kaiten('setPanelAutoFocus');
			this._trigger('afterload', 0, [this.element, this.$K]);
		},
		
		_doLayout : function() {
			//console.log('kPanel._doLayout', this.element, this._state);			
			if (this.isAnimated())
			{
				console.info('Panel layout discarded! (animation in progress)', this.element);
				return;
			}
			
			var ks = this.$K.kaiten('getState');
			this.setPositionAndWidth(this._state.position, this._state.width, ks);
			
			// toolbar
			this._doToolbarLayout(ks);
			
			// body, according to the layout mode
			this.element.trigger('bodylayout.kpanel', [ks]);
	    	
			// navitems
			this._doNavItemsLayout();
			
			this._trigger('afterlayout', 0, [this.element, this.$K]);
		},
		
		_doBodyLayout : function(kaitenState) {
			//console.log('kPanel._doBodyLayout', this.element);
			var ks = kaitenState || this.$K.kaiten('getState');
			
			var bodyHeight = ks.height;
			bodyHeight -= this.element.find(jKaiten.selectors.panelItems.titleBar).outerHeight(true);
			bodyHeight -= this.element.find(jKaiten.selectors.panelItems.header).outerHeight(true);
			
			var $options = this.element.find(jKaiten.selectors.panelItems.options);
			if ($options.is(':visible'))
			{
				bodyHeight -= $options.outerHeight(true);
			}
	    	
	    	this.$body.css({
	    		"height"		: bodyHeight+'px',
	    		"overflow-y"	: "auto"
    		});
		},
		
		// TODO : only on visible navitems (check scroll) + check .kpanel('buildNavItemsCollection') calls in Kaiten
		_doNavItemsLayout : function() {
			//console.log('jKaiten._doNavItemsLayout', arguments);
			var $navItems = this._state.$navItems || this.$body.find(jKaiten.selectors.items.navigable+', '+jKaiten.selectors.connectable);
			$navItems.each(function(){
				var $this = $(this), $children = $this.children();
				var $label = $children.filter(jKaiten.selectors.items.label);
				var $info = $children.filter(jKaiten.selectors.items.info);
				var maxLabelWidth = $this.width() - 60; // 30 (head icon) + 30 (tail nav arrow)
				if ($info.length === 0)
				{
					$label.css({
						"max-width": Math.floor(maxLabelWidth)+'px'
					});
					return;
				}
				$label.css({
					"max-width": ''
				});
				var maxInfoWidth = maxLabelWidth - $label.width();
				if (maxInfoWidth <= 20) // threshold
				{
					$label.css({
						"max-width": Math.floor(maxLabelWidth)+'px'
					});
					$info.hide();
					return;
				}
				$info.css({
					"max-width": Math.floor(maxInfoWidth)+'px',
					"display" : "block"
				});
			});
		},
		
		_doToolbarLayout : function(kaitenState){
			//console.log('kPanel._doToolbarLayout', this.element);
			if (this.isAnimated())
			{
				console.info('Panel toolbar layout discarded! (animation in progress)', this.element);
				return;
			}
			
			var ks = kaitenState || this.$K.kaiten('getState');
			var toolsSelectors = jKaiten.selectors.panelItems.tools;
			
			// prev
			if (this._state.index === 0) // always shown, but disabled
			{
				this.element.find(toolsSelectors.prev).addClass(jKaiten.selectors.disabledClass).show();
			}
			else
			{
				this.element.find(toolsSelectors.prev).removeClass(jKaiten.selectors.disabledClass);
				var $prevPanel = this.element.prev(jKaiten.selectors.panel);
				this.element.find(toolsSelectors.prev).toggle(!$prevPanel.kpanel('isVisible', true, ks));
			}
			// next
			if (this._state.index === (ks.panelsCreated - 1)) // always shown, but disabled
			{
				this.element.find(toolsSelectors.next).addClass(jKaiten.selectors.disabledClass).show();
			}
			else
			{
				this.element.find(toolsSelectors.next).removeClass(jKaiten.selectors.disabledClass);
				var $nextPanel = this.element.next(jKaiten.selectors.panel);
				this.element.find(toolsSelectors.next).toggle(!$nextPanel.kpanel('isVisible', true, ks));				
			}			
			// maximize/originalSize
			if (ks.columnsCount === 1)
			{
				this.element.find(toolsSelectors.maximize).hide();
			}
			else
			{
				this.element.find(toolsSelectors.maximize).show();
				if (this._state.width < ks.columnsCount)
				{
					this.element.find(toolsSelectors.maximize).removeClass(jKaiten.selectors.activeClass);
				}
			}
		},
		
		_hideNavTools : function(){
			//console.log('kPanel_hideNavTools', this.element);
			var ks = this.$K.kaiten('getState');
			var toolsSelectors = jKaiten.selectors.panelItems.tools;
			
			// prev
			if ((this._state.index === 0) || 
					((this._state.position < 0) && (this._futureState.position === 0)))
			{
				this.element.find(toolsSelectors.prev).addClass(jKaiten.selectors.disabledClass).show();
			}
			else
			{
				this.element.find(toolsSelectors.prev).hide();
			}
			// next
			if (this._state.index === (ks.panelsCreated - 1) || 
				((this._state.position >= ks.columnsCount) && 
					(this.getEdgePosition(true) === ks.columnsCount)))
			{
				this.element.find(toolsSelectors.next).addClass(jKaiten.selectors.disabledClass).show();
			}
			else
			{
				this.element.find(toolsSelectors.next).hide();
			}
			// maximize/originalSize
			if (ks.columnsCount === 1)
			{
				this.element.find(toolsSelectors.maximize).hide();
			}
		},
		
		/* PUBLIC API */
		
		maximize : function(){
			//console.log('kPanel.maximize', arguments);
			this.$K.kaiten('maximize', this.element);
		},
		
		originalSize : function(){
			//console.log('kPanel.originalSize', arguments);
			this.$K.kaiten('originalSize', this.element);
		},
		
		toggleLoader : function(showOrHide, where) {
			//console.log('kPanel.toggleLoader', arguments);
			var $mask = this.element.find(jKaiten.selectors.panelItems.mask);
			switch (where)
			{
				case 'body':
					$mask.css({
						top : this.element.find(jKaiten.selectors.panelItems.body).position().top,
						height : '100%'
					});
					break;
			
				case 'header':
					$mask.css({
						top : this.element.find(jKaiten.selectors.panelItems.header).position().top,
						height : this.element.find(jKaiten.selectors.panelItems.header).outerHeight(true)
					});
					break;
			
				default:
					$mask.css({ top:0, height:'100%' });
					break;
			}
			$mask.toggle(showOrHide); // the mask contains the animated gif
		},
		
		load : function(data, dfdAnim) {
			//console.log('kPanel.load', arguments);
			if (!$.isFunction(this.options.connector.loader))
			{
				throw new Error('No panel loader function!');
			}
			
			/* 0. abort any previous load */
			
			if (this._state.load.dfd)
			{
				if ($.isFunction(this._state.load.dfd.abort))
				{
					this._state.load.dfd.abort();
				}
				else
				{
					this._state.load.dfd.reject(this._state.load.dfd, 'abort');
				}
			}
			if (this._state.load.dfdAnim)
			{
				this._state.load.dfdAnim.reject(this._state.load.dfdAnim, 'abort'); 
			}
			this._state.load.dfdAnim = dfdAnim; 
			
			/* 1. prepare loading */
			
			this.toggleLoader(true); // display loader animation
			
			var self = this, deferreds = [], loaderResult;
			
			this._state.load.data = data; // save data for reload
						
			try
			{
				// just in case we have to abort the request (e.g.: two quick successive loadings)...
				loaderResult = this.options.connector.loader.call(this.options.connector, data, this.element, this.$K);
				if (($.type(loaderResult) === 'string') || (loaderResult instanceof jQuery))
				{
					// create a Deferred and resolve it immediately
					this._state.load.dfd = $.Deferred();
					this._state.load.dfd.resolve([loaderResult]);
				}
				else if ($.isPlainObject(loaderResult))
				{
					if (!$.isFunction(loaderResult.isResolved)) // a quick identity check
					{
						throw new Error('Loader function has not returned a proper deferred object!');
					}					
					this._state.load.dfd = loaderResult;
				}
				else
				{
					throw new Error('Loader function has returned a value that cannot be handled! ('+$.type(loaderResult)+')');
				}				
			}
			catch(e)
			{
				this._state.load.dfd = $.Deferred();
				this._state.load.dfd.reject(e.toString(), 'exception');
			}
			
			deferreds.push(this._state.load.dfd);
			
			/* 2. animation */
									
			deferreds.push(this._state.load.dfdAnim || {});
						
			/* 3. launch loading and panel animation */
			
			$.when.apply(this, deferreds).done(function(a1, a2){
				//console.log('done', arguments);
				if (!a1 || !a1[0])
				{
					self.setTitle('No content?');
					self._insertHTML('');
					return;
				}

				// set the panel title, if any
				if (data.kTitle !== undefined)
				{
					self.setTitle(data.kTitle);
				}
				
				// retrieve optimal width, if any
				var html = a1[0], ks = self.$K.kaiten('getState');
								
				$(html).each(function() {
					var $this = $(this);
					if ($this.attr('optimal-width'))
					{			
						self.setOptimalWidth($this.attr('optimal-width'), ks);
						return;
					}
				});
				
				// no resize needed? or will it be an hidden panel?
				var futureState = self.getState(true); // we use future state when dealing with animations
				var widthDiff = self._state.optimalWidth - futureState.width;
				if ((widthDiff === 0) || (!self.isVisible(true, ks)))
				{
					self._insertHTML(html);
					return;
				}
				
				if (widthDiff > 0) // expand
				{					
					// overlaps the right edge?
					if ((futureState.position + self._state.optimalWidth) > ks.columnsCount) 
					{				
						// resize...
						self.setWidthToOptimal(); // no cosmetics
						
						// slide and trigger the placement strategy for all the visible panels @left...
						self.$K.trigger('prevplacement.kaiten', [self.element, ks.columnsCount-self._state.optimalWidth-futureState.position, function(){
							self._insertHTML(html);
						}]);		
						return;
					}
					else
					{
						// resize and trigger the placement strategy for all the visible panels @right...
						self.$K.trigger('nextplacement.kaiten', [self.element, widthDiff, function(){
							self._insertHTML(html);
						}]);
						return;
					}
				}
				else if (widthDiff < 0) // reduce, after a maximize
				{
					// resize and trigger the placement strategy for all the visible panels @right...
					self.$K.trigger('nextplacement.kaiten', [self.element, widthDiff, function(){
						self._insertHTML(html);
					}]);									
					return;
				}
			}).fail(function(jqXHR, textStatus, errorThrown){
				//console.log('fail', arguments);
				// request was not aborted by a new request, carry on
				if (textStatus !== 'abort')
				{
					var errorMsg='', statusMsg='', i;

					if ($.isPlainObject(jqXHR)) // assume it's an AJAX error
					{
						if (jqXHR.status !== 0)
						{
							statusMsg = errorThrown+' ('+textStatus+' - '+jqXHR.status+')';
						}
						else
						{
							statusMsg = 'An unexpected '+textStatus+' has occured!';
						}
						statusMsg += '<br /><br />Load parameters: ';
						for (i in self._state.load.data)
						{
							if (self._state.load.data.hasOwnProperty(i))
							{
								statusMsg += '<br/>&nbsp;&nbsp;&nbsp;'+i+' : '+self._state.load.data[i];
							}
						}
					}
					else
					{
						statusMsg = jqXHR;
					}
					errorMsg = '<div class="'+jKaiten.selectors.panelItems.bodyClass+'">'+
									'<div class="'+jKaiten.selectors.panelItems.blockClass+'">'+
										'<h2>Load error!</h2>'+
										'<p>'+statusMsg+'</p>'+
									'</div>'+
								'</div>';
					
					self.setTitle('Error!');
					self._insertHTML(errorMsg);
					
					throw new Error(statusMsg);
				}
			});
		},
		
		reload : function(data, keepChildren) {
			//console.log('kPanel.reload', arguments);
			if (keepChildren !== true)
			{
				this.$K.kaiten('removeChildren', this.element);
			}
			data = data || {};
			$.extend(this._state.load.data, data);
			this.load(this._state.load.data);
		},
						
		newTab : function() {
			//console.log('kPanel.newTab', arguments);
			var newTabData = $.extend({}, this._state.load.data);
			if (newTabData.kTabID)
			{
				delete newTabData.kTabID;
			}
			
			// prevent bug
			var i;
			for (i in newTabData)
			{
				if ($.isFunction(newTabData[i]))
				{
					delete newTabData[i];
					continue;
				}
				if (newTabData.hasOwnProperty(i) && (newTabData[i] instanceof jQuery))
				{
					console.warn('Parameter "'+i+'" is an instance of jQuery. You may encounter navigation issues.');
					newTabData[i] = $('<div />').append(newTabData[i].clone()).html(); // "outerHTML"
					continue;
				}
			}
			
			var newURL = document.location.protocol + '//' +  document.location.host + document.location.pathname;
			var params = $.param(newTabData);
			newURL += '?' + params;
			window.open(newURL, params);
		},
		
		setTitle : function(newTitle) {
			//console.log('kPanel.setTitle', arguments);
			newTitle = newTitle.replace(/<\/?[^>]+>/gi, '');
			this.element.find(jKaiten.selectors.panelItems.title).html(newTitle);
			this.$breadcrumb.kbreadcrumb('updateTitle', this.options.index, newTitle);
		},
		
		setPosition : function(newPosition, kaitenState) {
			//console.log('kPanel.setPosition', arguments);			
			var ks = kaitenState || this.$K.kaiten('getState');
			
			// update state and future state
			this._futureState.position = this._state.position = newPosition;
			this._state.isVisible = this.isVisible(false, ks);
			
			var left = this._state.position * ks.columnWidth;
			this.element.css({
				"left"		: left+'px',
				"display"	: (this._state.isVisible === true) ? 'block' : 'none'
			});
						
			this.$breadcrumb.kbreadcrumb('toggleVisibility', this._state.index, this._state.isVisible);
		},
		
		incPosition : function(inc, kaitenState) {
			//console.log('kPanel.incPosition', arguments);
			this.setPosition(this._state.position+inc, kaitenState);
		},
		
		setWidth : function(newWidth, kaitenState) {
			//console.log('kPanel.setWidth', arguments);
			var ks = kaitenState || this.$K.kaiten('getState');			
			if (newWidth > ks.columnsCount)
			{
				newWidth = ks.columnsCount;
			}
			
			// update state and future state
			this._futureState.width = this._state.width = newWidth;
			
			var width = (this._state.width * ks.columnWidth) - this._constants.padding;
			this.element.css('width', width+'px');
		},
		
		setWidthToOptimal : function(kaitenState) {
			//console.log('kPanel.setWidthToOptimal', arguments);
			this.setWidth(this._state.optimalWidth, kaitenState);
			return this._state.width;
		},
		
		setOptimalWidth : function(newWidth, kaitenState) {
			//console.log('kPanel.setOptimalWidth', arguments);
			var ks = kaitenState || this.$K.kaiten('getState');			
			if (newWidth === 'fullscreen')
			{
				this._state.optimalWidth = ks.columnsCount;
				return;
			}
			
			var intWidth = parseInt(newWidth, 10);
			if (!intWidth)
			{
				this._state.optimalWidth = 1;
				return;
			}

			if (/[0-9]px$/.test(newWidth)) // allows width to be specified in px
			{
				intWidth = Math.ceil(intWidth/ks.columnWidth);
			}
			if (intWidth < 1)
			{
				intWidth = 1;
			}
			else if (intWidth > ks.columnsCount)
			{
				intWidth = ks.columnsCount;
			}
			this._state.optimalWidth = intWidth;
		},
		
		// all-in-one version for _doLayout
		setPositionAndWidth : function(newPosition, newWidth, kaitenState) {
			//console.log('kPanel.setPositionAndWidth', this.element, arguments);
			var ks = kaitenState || this.$K.kaiten('getState');
			if (newWidth > ks.columnsCount)
			{
				newWidth = ks.columnsCount;
			}
			
			// update state and future state
			this._futureState.position = this._state.position = newPosition;
			this._futureState.width = this._state.width = newWidth;
			this._state.isVisible = this.isVisible(false, ks);
			
			var left = this._state.position * ks.columnWidth;
			var width = (this._state.width * ks.columnWidth) - this._constants.padding;
			this.element.css({
				"left"		: left+'px',
				"width"		: width+'px',
				"display"	: (this._state.isVisible === true) ? 'block' : 'none'
			});
			
			this.$breadcrumb.kbreadcrumb('toggleVisibility', this._state.index, this._state.isVisible);
		},
				
		animate : function(posInc, widthInc, kaitenState, callback) {
			//console.log('kPanel.animate', arguments, this.element);
			var ks = kaitenState || this.$K.kaiten('getState');
			// prepare animation
			var animParms = { };

			if (posInc)
			{
				var leftInc = posInc * ks.columnWidth;
				animParms.left = '+='+leftInc; // > 0 moves to the right				
				this._futureState.position = this._futureState.position + posInc;
			}
			if (widthInc)
			{
				var resizeInc = widthInc * ks.columnWidth;
				animParms.width = '+='+resizeInc;				
				this._futureState.width = this._futureState.width + widthInc;
			}
			
			// animate
			if (posInc || widthInc)
			{
				this.$K.trigger('animstart.kpanel'); // notify Kaiten
				
				this._hideNavTools();
								
				var self = this;
				this.element.animate(animParms, {
					duration	: 500,
					easing		: 'easeOutExpo',
					queue 		: false,
					complete 	: function() {
						self.$K.trigger('animcomplete.kpanel'); // notify Kaiten
						
						// update state
						if (posInc)
						{				
							self.setPosition(self._futureState.position);
						}
						if (widthInc)
						{
							self.setWidth(self._futureState.width);
						}
							
						// layout, if visible		
						if (self.isVisible(false))
						{							
							self.element.trigger('layout.kpanel');
						}
						
						if ($.isFunction(callback))
						{
							callback.call(self.element);
						}
					}
				});
			}
		},
		
		toggle : function(showOrHide) {
			//console.log('kPanel.toggle', arguments);
			this.element.toggle(showOrHide);
		},
		
		setActiveItem : function($item) {
			//console.log('kPanel.setActiveItem', arguments);
        	this._state.$activeItem.removeClass(jKaiten.selectors.activeClass);
        	this._state.$activeItem = $item;
        	this._state.$activeItem.addClass(jKaiten.selectors.activeClass);
		},
		
		isVisible : function(future, kaitenState) {
			//console.log('kPanel.isVisible', this.element, future);
			var ks = kaitenState || this.$K.kaiten('getState');
			var p = (future === true) ? this._futureState.position : this._state.position;
			return (p >= 0) && (p < ks.columnsCount);
		},
		
		isAnimated : function() {
			//console.log('kPanel.isAnimated', this.element, this._state.position, this._futureState.position, this._state.position !== this._futureState.position);
			return (this._state.position !== this._futureState.position);
		},
		
		getState : function(future) {
			//console.log('kPanel.getState', this.element, future, (future === true)?this._futureState:this._state);
			return (future === true) ? this._futureState : this._state;
		},
		
		getEdgePosition : function(future) {
			//console.log('kPanel.getEdgePosition', this.element, future, (future === true)?this._futureState:this._state);
			return (future === true) ? this._futureState.position+this._futureState.width : this._state.position+this._state.width;
		},
		
		buildNavItemsCollection : function() {
			//console.log('kPanel.buildNavItemsCollection', this.element);
			this._state.$navItems = this.$body.find(jKaiten.selectors.items.navigable+', '+jKaiten.selectors.connectable);
			this._state.$activeItem = this._state.$navItems.filter('.'+jKaiten.selectors.activeClass);
			return this._state.$navItems;
		},
		
		toggleOptions : function() {
			//console.log('kPanel.toggleOptions', this.element);
			var self = this;
			this.element.children(jKaiten.selectors.panelItems.options).slideToggle('fast', function(){
				self.element.trigger('bodylayout.kpanel');
			});
		},
		
		switchLayoutMode: function(mode)
		{
			//console.log('kPanel.switchLayoutMode', arguments, this.element);
			var self = this;
			
			this.element.unbind('bodylayout.kpanel');
			this.element.bind('layout.kpanel', function(e){
				self._doLayout();
			});
			
			switch (mode)
			{
				case 'panelscroll':
			    	this.element.css({
			    		"overflow-y" : "auto"
			    	});
					this.element.bind('bodylayout.kpanel', function(e){
				    	self.$body.css({
				    		"height"	: '',
				    		"overflow"	: 'hidden'
			    		});
					});
					
					// scrollability
					if (this.$K.kaiten('getState').hasTouchScreen === true)
					{
						this.$body.removeClass('scrollable vertical');
						this.element.addClass('scrollable vertical');
					}
					break;
				
				default:
					mode = 'default';
				
			    	this.element.css({
			    		"overflow" : "hidden"
			    	});
			    	
					// scrollability
			    	if (this.$K.kaiten('getState').hasTouchScreen === true)
					{
						this.element.bind('bodylayout.kpanel', function(e, kaitenState){
					    	self.$body.css({
					    		"height"	: '',
					    		"overflow"	: 'hidden'
				    		});
						});
						this.element.removeClass('scrollable vertical');
						this.$body.addClass('scrollable vertical');
					}
					else
					{	
						this.element.bind('bodylayout.kpanel', function(e, kaitenState){
							self._doBodyLayout(kaitenState);
						});
						this.element.removeClass('scrollable vertical');
						this.$body.removeClass('scrollable vertical');
					}
					break;
			}
			
			this._state.layoutMode = mode;
			this.element.trigger('layout.kpanel');
		}
	});
}(jQuery));

/**
 * Kaiten breadcrumb
 *
 * @version 2011-06-03
 *
 */

(function( $ ) {
	$.widget("ui.kbreadcrumb", {
		/* DEFAULT PROPERTIES/METHODS */
		
		// default widget property : options (a mix of defaults with settings provided by the user)
		options : {
			minItemWidth : 32
		},
		
		// default widget method : creation
		_create: function() {
			/* 1. define useful variables and constants */
			
			this.$K = $(jKaiten.selectors.window).parent();
			this.$topBar = this.$K.find(jKaiten.selectors.topbar);
			this._constants.appMenuWidth = this.$K.find(jKaiten.selectors.appMenuContainer).outerWidth() + this.$K.find(jKaiten.selectors.appMenuBorder).outerWidth();
			
			/* 2. HTML markup */
			
			this.$list = $('<ul />').appendTo(this.element);
			
			/* 3. bind events */
			
			var self = this;

			// width change - see Kaiten's layout
			this.element.bind('layout.kbreadcrumb', function(e){
				self._doLayout();
			});
			
			// links
			this.element.delegate('a', 'click', function(){
				var parts = $(this).attr('id').split('-');
				self.$K.kaiten('slideTo', self.$K.find('#'+parts[1]));
			});
			
			//console.log('options/state', this.options, this._state);
		},
		
		// default widget method : option settings
		_setOption : function(key, value) {
			// option must be updated before layout
			$.Widget.prototype._setOption.apply(this, arguments);
			
			switch (key)
			{
				case 'minItemWidth':
					this.element.find('li').css('min-width', value+'px');
					this._doLayout();
					break;
				
				default:
					break;
			}
		},
		
		// default widget method : destruction (removes the instance from the encapsulated DOM element, which was stored on instance creation)
		destroy : function() {
			this.element.undelegate().unbind().empty().remove();			
			$.Widget.prototype.destroy.apply(this, arguments);
		},
		
		/* PROPERTIES, CONSTANTS, ... */
		
		_state : {
			itemsData : []
		},
		
		_constants : {
			appMenuWidth			: 0,
			visibilityArrowWidth	: 11
		},
		
		/* INTERNAL FUNCTIONS */
		
		_doLayout : function() {
			//console.log('kBreadcrumb._doLayout', arguments, this.element);
			var maxWidth = this.$topBar.width() - this._constants.appMenuWidth;
			var $listItems = this.element.find('li'), listWidth = 0;
			$listItems.each(function(){
				listWidth += $(this).outerWidth();
			});
			var widthDiff = listWidth - maxWidth;			
			var self = this, items = [], $item, w, wInc, weightedInc, i, l, newWidth;
			//console.log('topBar='+this.$topBar.width(), 'appmenu='+this._constants.appMenuWidth, 'listWidth='+listWidth, 'widthDiff='+widthDiff);
			if (widthDiff > 0) // reduce
			{	
				var min = Infinity;
				$listItems.not(':first').each(function(){
					$item = $(this);
					w = $item.width();
					if (w > self.options.minItemWidth)
					{
						items.push({ $elem : $item, width : w });
						min = Math.min(min, w);
					}
				});			
				l = items.length;
				if (l === 0)
				{
					return;
				}
				wInc = widthDiff / l;
				//console.log('l='+l, 'wInc='+wInc, 'min='+min);
				for (i=l-1; i>=0; i--)
				{
					item = items[i];
					weightedInc = Math.round(wInc * (item.width / min));
					newWidth = item.width - weightedInc;
					//console.log('i='+i, item.$elem, 'item.width='+item.width, 'weightedInc='+weightedInc, 'newWidth='+newWidth);
					if (newWidth < this.options.minItemWidth)
					{
						widthDiff -= (item.width - this.options.minItemWidth); // crop
						//console.log('crop, new widthDiff='+widthDiff);
						if ((l === 1) && (widthDiff <= 0))
						{
							newWidth = -widthDiff;
							//console.log('single, newWidth='+newWidth);
						}
						else if (i > 0)
						{
							wInc = widthDiff / i; // we should update min, no?
							//console.log('new wInc='+wInc);
						}
					}
					else
					{
						widthDiff -= weightedInc;
						//console.log('normal, new widthDiff='+widthDiff);
					}				
					this._doItemLayout(item.$elem, newWidth);
					if (widthDiff <= 0)
					{
						break;
					}
				}
			}
			else if (widthDiff < 0) // expand
			{
				var max = 0, origWidth;
				$listItems.not(':first').each(function(){
					$item = $(this);
					w = $item.width();
					origWidth = $item.data('orig-width');
					if (w < origWidth)
					{
						items.push({ $elem : $item, width : w, origWidth : origWidth });
						max = Math.max(max, origWidth);
					}
				});			
				l = items.length;
				if (l === 0)
				{
					return;
				}
				widthDiff = -widthDiff;
				wInc = Math.floor(widthDiff / l);
				//console.log('l='+l, 'wInc='+wInc, 'max='+max);
				for (i=0; i<l; i++)
				{
					item = items[i];
					weightedInc = Math.round(wInc * (max/item.origWidth));
					newWidth = item.width + weightedInc;
					//console.log('i='+i, item.$elem, 'item.width='+item.width, 'item.origWidth='+item.origWidth, 'weightedInc='+weightedInc, 'newWidth='+newWidth);
					if (newWidth > item.origWidth)
					{
						widthDiff -= (item.origWidth - item.width); // crop
						//console.log('crop to '+item.origWidth+', new widthDiff='+widthDiff);
						if (i < (l - 1))
						{
							wInc = widthDiff / (l-1-i); // we should update max, no?
							//console.log('new wInc='+wInc);
						}
					}
					else
					{
						widthDiff -= weightedInc;
						//console.log('normal, new widthDiff='+widthDiff);
					}		
					this._doItemLayout(item.$elem, newWidth);
					if (widthDiff <= 0)
					{
						break;
					}
				}
			}
		},
		
		_doItemLayout : function($item, newWidth) {
			if (newWidth)
			{
				if (newWidth < this.options.minItemWidth)
				{
					newWidth = this.options.minItemWidth;
				}
				else if (newWidth >= $item.data('orig-width'))
				{
					newWidth = $item.data('orig-width') + 1; // on certain small items, 1px is missing...
				}
				$item.css('width', newWidth+'px');
			}
			var $anchor = $item.children('a');
			var middle = Math.round(($anchor.width() - this._constants.visibilityArrowWidth) / 2); 
			$anchor.css('background-position', middle+'px bottom');
		},
		
		_genDocTitle : function() {
		    var docTitle = '', title, i;
		    for (i=this._state.itemsData.length-1; i>0; i--)
		    {
		    	title = this._state.itemsData[i].title;
		        docTitle += title + ' > ';
		    }
		    if (this._state.itemsData.length > 0)
		    {
		    	title = this._state.itemsData[0].title;
		    	docTitle += title;
		    }
		    document.title = docTitle;
		},
		
		/* PUBLIC API */
		
		add : function(options) {
			this._state.itemsData[options.index] = options;
			this._genDocTitle();
			
			// create new list item and anchor 
			var $listItem = $('<li />', {
				"class"	: jKaiten.selectors.breadcrumbItems.lastClass 
			});
			var $anchor = $('<a />', {
				"id"	: jKaiten.selectors.breadcrumbItems.anchorIDPrefix+'-'+options.id,
				"class" : jKaiten.selectors.visibleClass,
				"title" : options.title
			});
			
			if (this._state.itemsData.length === 1)
			{
				$listItem.addClass(jKaiten.selectors.breadcrumbItems.homeClass);
				$anchor.attr('accesskey', 'h').append('<div class="icon" />');
				$listItem = $listItem.append($anchor).appendTo(this.$list);
			}
			else
			{
				$anchor.append(options.title);
				$listItem = $listItem.append($anchor).appendTo(this.$list);
				$listItem.css('min-width', this.options.minItemWidth+'px').data('orig-width', $listItem.width());
				$listItem.prev().removeClass(jKaiten.selectors.breadcrumbItems.lastClass);
				this._doLayout();
			}
		},
		
		updateTitle : function(index, newTitle) {
			this._state.itemsData[index].title = newTitle;
			
			var selector = '#'+jKaiten.selectors.breadcrumbItems.anchorIDPrefix+'-'+this._state.itemsData[index].id;
			var $anchor = this.element.find(selector);
			$anchor.attr('title', this._state.itemsData[index].title);
			
			var $listItem = $anchor.parent('li');
			if (!$listItem.hasClass(jKaiten.selectors.breadcrumbItems.homeClass))
			{
				$listItem.css('width', '');
				$anchor.html(this._state.itemsData[index].title);
				$listItem.data('orig-width', $listItem.width());
				this._doLayout();
			}
			
			this._genDocTitle();											
		},
		
		cut : function(index) {
			var breadcrumbSelectors = jKaiten.selectors.breadcrumbItems;
			var selectorPrefix = '#'+breadcrumbSelectors.anchorIDPrefix+'-';
			var itemData, i;
			for (i=this._state.itemsData.length-1; i>=index; i--)
			{			
				itemData = this._state.itemsData.pop();
				this.element.find(selectorPrefix+itemData.id).parent('li').remove();
			}
			if (index > 0)
			{
				this.element.find(selectorPrefix+this._state.itemsData[index-1].id).parent('li').addClass(breadcrumbSelectors.lastClass);
				this._doLayout();
			}

			this._genDocTitle();
		},
		
		toggleVisibility : function(index, visible){
			if (!this._state.itemsData[index])
			{
				return;
			}
			var selector = '#'+jKaiten.selectors.breadcrumbItems.anchorIDPrefix+'-'+this._state.itemsData[index].id;
			var $anchor = this.element.find(selector).toggleClass(jKaiten.selectors.visibleClass, visible);
			if (visible === true)
			{
				this._doItemLayout($anchor.parent('li'));
			}
		}
	});
}(jQuery));

/**
 * Kaiten templater, a basic templating system
 *
 * @version 2011-06-16
 *
 */

kTemplater = (function($, kSelectors){
	// low-level
	function _elem(className, config) {
		if (config['class'])
		{
			className += ' '+config['class'];
		}
		var idAttr = (config.id) ? 'id="'+config.id+'"' : '';
		config.content = config.content || '';
		var html = '<div class="'+className+'" '+idAttr+'>'+config.content+'</div>';
		return html;
	}
	function _$elem(className, config) {
		if (config['class'])
		{
			className += ' '+config['class'];
		}
		config.content = config.content || '';
		var $elem = $('<div />', {
			"class" : className
		});
		if (config.id)
		{
			$elem.attr('id', config.id);
		}
		return $elem.append(config.content);
	}
	// panel header
	function _header(config) {
		return _elem(kSelectors.panelItems.headerClass, config);
	}	
	function _$header(config) {
		return _$elem(kSelectors.panelItems.headerClass, config);
	}
	// panel body
	function _body(config) {
		return _elem(kSelectors.panelItems.bodyClass, config);
	}	
	function _$body(config) {
		return _$elem(kSelectors.panelItems.bodyClass, config);
	}
	// blocks
	function _block(className, config) {
		return _elem(className, config);
	}	
	function _$block(className, config) {
		return _$elem(className, config);
	}
	// navigable (in block-nav)
	function _navigation(config) {
		var idAttr = (config.id) ? 'id="'+config.id+'"' : '';
		var className = kSelectors.items.itemsClass+' '+kSelectors.items.navigableClass;
		if (config['class'])
		{
			className += ' '+config['class'];
		}
		var title = config.title || config.label;
		if (config.info)
		{
			title += ' /// '+config.info;
		}
		title = title.replace(/<\/?[^>]+>/gi, '');
		title = title.replace(/\"/g,'&quot;');
		var html = '<div '+idAttr+' class="'+className+'" title="'+title+'">';
		if (config.iconURL)
		{
			html += '<div class="'+kSelectors.items.headClass+'"><img src="'+config.iconURL+'" /></div>';
		}
		html += '<div class="'+kSelectors.items.labelClass+'">'+config.label+'</div>';
		if (config.info)
		{
			html += '<div class="'+kSelectors.items.infoClass+'">'+config.info+'</div>';
		}
		html += '<div class="'+kSelectors.items.tailClass+'" />';
		html += '</div>';
		return html;
	}
	// clickable (in block-nav)
	function _clickable(config) {
		var idAttr = (config.id) ? 'id="'+config.id+'"' : '';
		var className = kSelectors.items.itemsClass+' '+kSelectors.items.clickableClass;
		if (config['class'])
		{
			className += ' '+config['class'];
		}
		var html = '<div '+idAttr+' class="'+className+'" title="'+config.label.replace(/<\/?[^>]+>/gi, '')+'">';
		if (config.iconURL)
		{
			html += '<div class="'+kSelectors.items.headClass+'"><img src="'+config.iconURL+'" /></div>';
		}
		html += '<div class="'+kSelectors.items.labelClass+'">'+config.label+'</div>';
		if (config.info)
		{
			html += '<div class="'+kSelectors.items.infoClass+'">'+config.info+'</div>';
		}
		html += '</div>';
		return html;
	}
	// separator (in block-nav)
	function _separator(config) {
		var idAttr = (config.id) ? 'id="'+config.id+'"' : '';
		var className = kSelectors.items.itemsClass+' '+kSelectors.items.separatorClass;
		if (config['class'])
		{
			className += ' '+config['class'];
		}
	   var html = '<div '+idAttr+' class="'+className+'">';
	   if (config.iconURL)
	   {
	       html += '<div class="head"><img src="'+config.iconURL+'" /></div>';
	   }
	   html += '<div class="'+kSelectors.items.labelClass+'">'+config.label+'</div>';
	   if (config.info)
	   {
	       html += '<div class="'+kSelectors.items.infoClass+'">'+config.info+'</div>';
	   }
	   html += '</div>';
	   return html;
	}
	// summary (in block-nav)
	function _summary(config) {
		var idAttr = (config.id) ? 'id="'+config.id+'"' : '';
		var className = kSelectors.items.summaryClass;
		if (config['class'])
		{
			className += ' '+config['class'];
		}
		var html = '<div '+idAttr+' class="'+className+'">';
		html += '<div class="'+kSelectors.items.labelClass+'" style="background-image:url('+config.iconURL+');">'+config.label+'</div>';
		if (config.info)
		{
			html += '<div class="'+kSelectors.items.infoClass+'">'+config.info+'</div>';
		}
		html += '</div>';
		return html;
	}
	// search form
	function _search(config) {
		var idAttr = (config.id) ? 'id="'+config.id+'"' : '';
		var html = '<form '+idAttr+' class="quicksearch" onsubmit="return false;"><div class="container rounded-corners">';
		config.text = config.text || '';
		html += '<button class="head search" />';
		html += '<input class="input" type="text" value="'+config.text+'" />';
		html += '<button class="tail reset" onclick="$(this).prev(\'input:text\').val(\'\');return false;" />';
		html += '</div></form>';
		return html;
	}
	
	// factory function
	function _build(type, templateName, config) {
		//console.log('kTemplater._build', arguments);
		var item = null;
		config = config || {};
		switch (templateName) 
		{
			case 'panel.body':
				item = (type === 'html') ? _body(config) : _$body(config);
				break;
				
			case 'panel.header':
				item = (type === 'html') ? _header(config) : _$header(config);
				break;
			
			case 'block.content':
				item = (type === 'html') ? _block('block', config) : _$block('block', config);
				break;

			case 'block.navigation':
				item = (type === 'html') ? _block('block-nav', config) : _$block('block-nav', config);
				break;
				
			case 'block.noresults':
				item = (type === 'html') ? _block('block-noresults', config) : _$block('block-noresults', config);
				break;
				
			case 'line.navigation':
				item = _navigation(config);
				if (type === 'html')
				{
					if (config.data)
					{
						throw new Error('Using data on HTML templates is not supported! Please use kTemplater.jQuery() instead.');
					}
				}
				else
				{
					item = $(item);
					item.data('load', config.data);
				}
				break;
				
			case 'line.clickable':
				item = _clickable(config);
				if (type === 'html')
				{
					if (config.data)
					{
						throw new Error('Using data on HTML templates is not supported! Please use kTemplater.jQuery() instead.');
					}
				}
				else
				{
					item = $(item);
					item.data('load', config.data);
				}
				break;

			case 'line.separator':
				item = (type === 'html') ? _separator(config) : $(_separator(config));
				break;
				
			case 'line.summary':
				item = (type === 'html') ? _summary(config) : $(_summary(config));
				break;
				
			case 'line.search':
				item = (type === 'html') ? _search(config) : $(_search(config));
				break;
				
			default:				
				break;
		}
		//console.log(item);
		
		if (item === null)
		{
			throw new Error('Template "'+templateName+'" not available!');
		}
		
		return item;
	}
	
	/* PUBLIC API */
	
	return {
		html : function(templateName, config) {
			return _build('html', templateName, config);
		},
		jQuery : function(templateName, config){
			return _build('jQuery', templateName, config);
		}
	};
}(jQuery, jKaiten.selectors));