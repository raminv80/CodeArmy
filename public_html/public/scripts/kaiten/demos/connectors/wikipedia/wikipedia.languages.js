(function($kt){
	if (!window.kConnectors.wikipedia){window.kConnectors.wikipedia = {};}

	window.kConnectors.wikipedia.languages = {
		cssFile : 'connectors/wikipedia/wikipedia.css',
		loader: function(data, $panel, $kaiten){
			$panel.data('fromConnector','wikipedia.languages');
			if (!data.domain)
			{
				data.domain = $panel.prev().data('domain') || window.kConnectors.wikipedia.domain;
			}
		 	$panel.data('domain',data.domain);

			// load the main page by default
			var self = this, queryData = {
				action		: 'sitematrix',
				format		: 'json'
			};
		
			// perform our cross-domain AJX request to the public API and
			// use a custom function to convert JSON received into proper HTML
			return $.ajax({
				url			: data.domain+'/w/api.php?callback=?',
				type		: 'get',
				dataType	: 'json html',
				data		: queryData,
				converters	: {
					/*'json html' : this.convertWikiPageData*/
					'json html' : function(data){
						if (data.domain)
						{
						 	$panel.data('domain',data.domain);
						}
						else
						{
						 	$panel.removeData('domain');
						}
						return self.format($panel, data);
					}
				}
			});
		},
		format: function($panel, jsonData) 
		{
			// get page revision, process page HTML and add some custom content (title, footer)
			var self	= this,
				body 	= $kt('panel.body'),
			 	list 	= jsonData.sitematrix,
			 	block 	= $kt('block.navigation').appendTo(body);

			for (var n in list)
			{
				if (list.hasOwnProperty(n) && list[n].code)
				{
					var lang = list[n];
					if (lang.site.length)
					{
						var nav = $kt('line.clickable',{
							label:lang.name,
							info:lang.site[0].url,
							'class':window.kConnectors.languages.exists(lang.code) ? 'main-language':'other-language'
						}).appendTo(block)
							.click(function(){
								self.changeLanguage($(this));
							})
							.data('domain', lang.site[0].url)
							.data('code', lang.code);
						
						if (lang.site[0].url == window.kConnectors.wikipedia.domain)
						{
							nav.addClass('k-active');
						}
					}
				}
			}

			function sortAlpha(a,b){  
			    return $(a).find('.label').text() > $(b).find('.label').text();  
			};
			
			block.find('.items.main-language').sort(sortAlpha).appendTo(block);
			$kt('line.separator',{id:'translate-other-lang',label:window.kConnectors.languages.get('other-lang').label}).appendTo(block);
			block.find('.items.other-language').sort(sortAlpha).appendTo(block);  

			// add a footer
			$kt('block.content',{'content':window.kConnectors.wikipedia.footer}).appendTo(body);

			return body;
		},
		changeLanguage:function($item){
			window.kConnectors.wikipedia.domain = $item.data('domain');
			$item.closest('.k-panel').prevAll().first().data('domain',window.kConnectors.wikipedia.domain);
			$item.siblings().removeClass('k-active');
			$item.addClass('k-active');
			var language = $item.data('code');
			window.kConnectors.languages.setCurrentLanguage(language);
			window.kConnectors.wikipedia.language = language;
			$('#translate-navlang').find('.info').text(languages[language]);
		}
	};
}(kTemplater.jQuery));
