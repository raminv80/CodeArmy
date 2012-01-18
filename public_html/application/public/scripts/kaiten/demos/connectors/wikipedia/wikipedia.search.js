(function($kt){
	if (!window.kConnectors.wikipedia){window.kConnectors.wikipedia = {};}

	window.kConnectors.wikipedia.search = {
		searchPaginate: 50,
		cssFile : 'connectors/wikipedia/wikipedia.css',
		loader : function(data, $panel, $kaiten){
			if (!data.query)
			{
				throw new Error('No query!');
			}
			
			$panel.data('fromConnector','wikipedia.search');
			if (!data.domain)
			{
				data.domain = $panel.prev().data('domain') || window.kConnectors.wikipedia.domain;
			}
		 	$panel.data('domain',data.domain);

			var queryData = {
				action		: 'query', 
				list		: 'search',
				srsearch	: data.query,
				srlimit		: this.searchPaginate,
				sroffset    : ((data.page || 1) - 1) * this.searchPaginate,
				srprop		: 'titlesnippet',
				format		: 'json'
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
					'json html' : function(response){
						if (data.domain)
						{
						 	$panel.data('domain',data.domain);
						}
						else
						{
						 	$panel.removeData('domain');
						}
						$panel.data('page',data.page || 1);
						return self.transform($panel, response);
					}
				}
			});
		},
		transform:function($panel, jsonData)
		{
			// get page revision, process page HTML and add some custom content (title, footer)
			var body 		= $kt('panel.body');
			var results		= $kt('block.navigation').appendTo(body);
			var list 		= jsonData.query.search;
			var count		= jsonData.query.searchinfo.totalhits;
			var suggestion	= jsonData.query.searchinfo.suggestion;

			//console.log(jsonData.query);
			if (suggestion) {
				$kt('line.navigation',{
					label:'try: "'+suggestion+'"'
				})
				.click(function(){
					$panel.kpanel('reload',{query:suggestion, kTitle:suggestion, page:1});
				}).appendTo(results);
			}

			for (var n in list)
			{
				if (list.hasOwnProperty(n))
				{
					var match = list[n];

					$kt('line.navigation',{
						label:(match.titlesnippet || match.title),
						data:{
							kConnector:'wikipedia.page',
							titles:match.title,
							kTitle:match.title
						}
					}).appendTo(results);
				}
			}

			if (count > this.searchPaginate)
			{
				var pages = $('<div class="center"/>');
				var page = $panel.data('page') || 1;
				var lastPage = Math.ceil(count/this.searchPaginate);
				var curPage = page - 4;
				if (curPage < 1)
				{
					curPage = 1;
				}

				if (curPage > 1)
				{
					$('<span/>',{
							'class':(page==1?'selected':'selectable'),
							text:1
						})
						.data('page',1)
						.appendTo(pages);
				}
				for (var i=0; curPage <= lastPage && i < 8; curPage++, i++) 
				{
					$('<span/>',{
							'class':(page==curPage?'selected':'selectable'),
							text:curPage
						})
						.data('page',curPage)
						.appendTo(pages);
				};

				if (curPage <= lastPage)
				{
					$('<span/>',{
							'class':(page==lastPage?'selected':'selectable'),
							text:lastPage
						})
						.data('page',lastPage)
						.appendTo(pages);
				}

				body.delegate('.results-browser .selectable','click',function(){
					$panel.kpanel('reload',{page: $(this).data('page')});
				});

				pagination = $('<div class="results-browser"/>');
				pagination.append('<span class="left">'+count+' hits</span>');
				pagination.append('<span class="right">'+count+' hits</span>');
				pagination.append(pages);
				body.prepend(pagination).append(pagination.clone());
			}
			// add a footer
			body.append(window.kConnectors.wikipedia.footer);

			return body;
		}
	};
}(kTemplater.jQuery));
