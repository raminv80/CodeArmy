(function($kt,trad){
	if (!window.kConnectors.wikipedia){window.kConnectors.wikipedia = {};}

	window.kConnectors.wikipedia.page = {
		cssFile : 'connectors/wikipedia/wikipedia.css',
		loader : function(data,$panel,$kaiten){
			$panel.data('connector','wikipedia.page');
			if (!data.domain)
			{
				data.domain = $panel.prev().data('domain') || window.kConnectors.wikipedia.domain;
			}
		 	$panel.data('domain',data.domain);

			var queryData = {							
				action		: 'query', 
				prop		: 'revisions', 
				rvprop		: 'content', 
				format		: 'json', 
				titles		: data.titles || 'Main Page', // load the main page by default
				rvparse		: true,
				redirects	: 1
			};

			var self = this;

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
						if (data.domain)
						{
						 	$panel.data('domain',data.domain);
						}
						else
						{
						 	$panel.removeData('domain');
						}
						return self.format($panel, response);
					}
				}
			});
		},
		// when clicking on a link element, this function will be called to determine
		// if this connector can be used for loading the corresponding content
		connectable : function(href, $link) {
			var from = $link.closest('.k-panel').data('connector');
			return !$link.hasClass('image') && (
						window.kConnectors.wikipedia.isWikipediaDomain.test(href)
						 || (/^https?:\/\//.test(href)==false && from && from.indexOf('wikipedia') == 0) 
					);
		},
		// if the previous function has returned true, the data to pass to the loader
		// is collected by this function
		getData : function(href, $link) {
			var $this = $(this);

			if ((/^https?:\/\//.test(href) || href.indexOf('/wiki/')==0))
			{
				var data = { 
					titles : decodeURIComponent(href.split('/').pop())
				};

				if (href.indexOf('http') == 0)
				{
					data.domain = decodeURIComponent(href.match('https?://[^/]*')[0]);
				}
				return data;
			}
			else
			{
				return {
					kConnector : 'iframe',
					url      : window.kConnectors.wikipedia.domain + href.replace('&action=edit','')
				};
			}
		},
		format:function($panel, jsonData) 
		{
			// get page revision, process page HTML and add some custom content (title, footer)
			var body,
			 	pages = jsonData.query.pages;

			//console.group('format content');
			for (var n in pages)
			{
				if (pages.hasOwnProperty(n))
				{
					// set panel title
					$panel.kpanel('setTitle', pages[n].title);

					// prepare content
					if (pages[n].revisions)
					{
						body = $kt('panel.body')
								.append($kt('block.content',{
										'content':'<h1>'+pages[n].title+'</h1>\
												<a class="k-exit gotowiki" href="'+$panel.data('domain')+'/wiki/'+pages[n].title+'">'+
													trad.get('exit')+
												'</a>'
										}))
								.append($kt('block.navigation',{'class':'top'}))
								.append($kt('block.content',{'content':pages[n].revisions['0']['*']}))
								.append($kt('block.navigation',{'class':'bottom'}))
								.append($kt('block.content',{'content':window.kConnectors.wikipedia.footer}));


						this.toc(body);
						this.summary(body);	
						this.collapsible(body);
					}
					else
					{
						throw new Error(trad.get('no-content'));
					}
				}
			}
			//console.groupEnd();		
			return body;
		},
		/**
		 * Removes the table of contents from the panel but puts it in a
		 * navigable item.
		 */	
		toc: function (body){
			var node = body.find('#toc'), itemLabel;
			if (!node.size())
			{
				return;
			}
			// itemLabel = node.find('#toctitle').text();
			// if (!itemLabel.trim()){
				itemLabel = window.kConnectors.languages.get('navtoc').label;
			// }
			//itemLabel = window.kConnectors.languages.get('en', 'navtoc-label');
			node.remove();
			body.find('div.top').append($kt('line.navigation',{
					iconURL:'connectors/wikipedia/images/toc.png',
					label:itemLabel,
					data:{
						kConnector:	'wikipedia.static',
						kTitle:		itemLabel,
						formater:	this.transformToc,
						source:		node
					}
				})
			);	
		},
		/**
		 * Trasform the table of contents to have a kaiten like markup
		 */	
		transformToc: function (node, title){			
			var block = $kt('block.navigation')
						.append($kt('line.summary',{
							iconURL:'connectors/wikipedia/images/toc.png',
							label:title,
							info:''
						}));

			var toc = node.find('ul').eq(0).clone().attr('id','toc').appendTo(block);
			toc.delegate('li,a', 'click', function(evt){
				$this = $(this);
				if (!$this.is('a'))
				{
					$this = $this.find('a');
				}
				var $panel   = $this.closest('.k-panel');
				var $prev    = $panel.prev();
				if($prev.is(':hidden')){
					$panel.kpanel('prev');
				}

				var $target = $prev.find($this.attr('href').replace(/\./g,'\\.'));//some ids contains '.'
				if ($target.size() > 0)
				{
					$prev.find('.panel-body').scrollTop($target.position().top + $prev.find('.panel-body').scrollTop() - 8);
				}
				return false;
			});

			return $kt('panel.body').append(block);
		},

		/**
		 * Removes the summary from the panel but puts it in a 
		 * navigable item	 
		 */
		summary: function (body){
			//we cannot do $('table.infobox') because sometimes the class name is
			//appended with oddities like '_v2' (infobox_v2)
			//this finds a table with a class attribute starting with 'infobox'
			var node = body.find('table[class^="infobox"]'),
				itemLabel;
			if (!node.size())
			{
				return;
			}
			itemLabel = window.kConnectors.languages.get('navsummary').label;
			node.remove();
			body.find('div.top').append($kt('line.navigation',{
					iconURL:'connectors/wikipedia/images/toc.png',
					label:itemLabel,
					data:{
						kConnector:	'wikipedia.static',
						kTitle:		itemLabel,
						formater:	this.transformSummary,
						source:		node
					}
				})
			);	
		},
		/**
		 * Trasform the table of contents to have a kaiten like markup
		 */	
		transformSummary: function (node,title){
			var block = $kt('block.navigation').append($kt('line.summary',{
					iconURL:'connectors/wikipedia/images/toc.png',
					label:title, 
					info:''
				}));

			var summary = node.attr('id','summary').appendTo(block);

			return $kt('panel.body').append(block);
		},
		collapsible: function (body){
			var collapsible = body.find('.collapsible');
			var self=this;
			if (collapsible.size())
			{
				var items = body.find('div.bottom');
				collapsible.find('tr:first-child').each(function(){
					$(this).find('.noprint').remove();
					$kt('line.navigation',{
							label:$(this).text(),
							data:{
								kConnector:	'wikipedia.static',
								kTitle:		$(this).text(),
								formater:	self.buildCollapseContent,
								source:		$(this).nextAll(),
								title:		$(this).find('td,th').html()
							}
						}).appendTo(items);

				});
			}
			collapsible.remove();
		},
		buildCollapseContent: function (rows, title){
			var block = $kt('block.navigation').append($kt('line.summary',{label:title, info:''}));

			var body = $kt('panel.body').append(block);

			rows.each(function(){
				var self=$(this);
				if (self.text().trim())
				{
					if (self.find('td,th').size()>1){
						title = self.find('td,th').eq(0);
						body.append($kt('block.content',{
							content:'<h2>'+title.html()+'</h2><div>'+title.nextAll().html()+'</div>'
						}));
					}
					else
					{
						body.append($kt('block.content',{
							content:'<div>'+self.find('td,th').html()+'</div>'
						}));
					}
				}
			});

			return body;
		}
	};
}(kTemplater.jQuery,window.kConnectors.languages));
