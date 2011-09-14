(function($kt){
	if (!window.kConnectors.wikipedia){window.kConnectors.wikipedia = {};}

	window.kConnectors.wikipedia.image = {
		cssFile : 'connectors/wikipedia/wikipedia.css',
		loader : function(data, $panel, $kaiten){
			$panel.data('connector','wikipedia.image');
			if (!data.domain)
			{
				data.domain = $panel.prev().data('domain') || window.kConnectors.wikipedia.domain;
			}
		 	$panel.data('domain',data.domain);
			var self = this,
				queryData = {							
					action		: 'query', 
					prop		: 'imageinfo', 
					iiprop      : 'url|metadata|size|comment',
					iiparse		: true,
					format		: 'json', 
					titles		: data.titles || 'Main Page'
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
					'json html' : function(response){
						$panel.data('fromConnector','wikipedia.image');
						if (data.domain)
						{
						 	$panel.data('domain',data.domain);
						}
						else
						{
						 	$panel.removeData('domain');
						}
						return self.format($panel,response);
					}
				}
			});
		},
		// when clicking on a link element, this function will be called to determine
		// if this connector can be used for loading the corresponding content
		connectable: function(href, $link) {
			return $link.hasClass('image');
		},
		// if the previous function has returned true, the data to pass to the loader
		// is collected by this function
		getData : function(href,$link) {
			var data = { 
				titles : decodeURIComponent(href.split('/').pop())
			};

			if (href.indexOf('http') == 0)
			{
				data.domain = decodeURIComponent(href.match('https?://[^/]*')[0]);
			}
			return data;
		},
		format:function($panel, jsonData) 
		{
			// get page revision, process page HTML and add some custom content (title, footer)
			var $body=$kt('panel.body'), h1;
			var pages = jsonData.query.pages;
			for (var n in pages)
			{
				if (pages.hasOwnProperty(n))
				{
					// set panel title
					$panel.kpanel('setTitle', pages[n].title);
					// console.log(pages[n],pages[n].imageinfo[0].width);

					if (pages[n].imageinfo[0])
					{
						$body.append($kt('block.content',{
							content:'<h1>'+pages[n].title+'</h1>\
									<div class="wikiImageView">\
										<img src="'+pages[n].imageinfo[0].url+'"/>\
									</div>'
						})).css('overflow-x', '');

						$panel.kpanel('setOptimalWidth',pages[n].imageinfo[0].width+'px');
					}
					else
					{
						throw new Error(trad.get('no-content'));
					}
				}
			}

			return $body;
		}
	};
}(kTemplater.jQuery));
