/* crunchbase connectors */

if (!window.kConnectors.crunchbase)
{
	window.kConnectors.crunchbase = {};
}

window.kConnectors.crunchbase.helpers = {
	labels: {
		homepage_url: 			'Website',
		twitter_username: 		'Twitter',
		category_code: 			'Category',
		blog_url: 				'Blog',
		email_address: 			'Email',
		founded: 				'Founded in',
		launched: 				'Launched in',
		number_of_employees: 	'Number of employees',
		company:				'Company',
		person:					'People',
		product:				'Product',
		'financial-organization':'Financial Organization'	 
	},

	months:["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],

	_infoLine:function(data,info){
		var value, label=this.labels[info];
		if (info=='homepage_url' && data.homepage_url)
		{
			value = '<a href="'+data.homepage_url+'">'+data.homepage_url+'</a>';
		}
		else if (info=='founded' && data.founded_month && data.founded_year)
		{
			value = this.months[data.founded_month-1] + ' ' + data.founded_year;
		}
		else if (info=='launched' && data.launched_month && data.launched_year)
		{
			value = this.months[data.launched_month-1] + ' ' + data.launched_year;
		}
		else if (info == 'twitter_username' && data.twitter_username)
		{
			value = '<a href="http://twitter.com/#!/'+data.twitter_username+'">@'+data.twitter_username+'</a>';
		}
		else if (info == 'blog_url' && data.blog_url)
		{
			value = '<a href="'+data.blog_url+'">'+data.blog_url+'</a>';
		}
		else if (info == 'email_address' && data.email_address)
		{
			value = '<a href="mailto:'+data.email_address+'">'+data.email_address+'</a>';
		}
		else if (data[info])
		{
			value = data[info];
		}
		else
		{
			return;
		}
		return '<p class="infoline">'+label+': <strong>'+value+'</strong></p>';
	},

	_navigationLine:function(json){
		//console.log(json);
		if (json.person)
		{
			return kTemplater.jQuery('line.navigation', {
				label : json.person.first_name+' '+json.person.last_name,
				info : json.title,
				data : { kConnector:'crunchbase.person', permalink:json.person.permalink }
			});
		}
		else if (json.firm)
		{
			return kTemplater.jQuery('line.navigation', {
				label : json.firm.name,
				data : { kConnector:'crunchbase.company', permalink:json.firm.permalink }
			});
		}
		else
		{
			var label = json.name||(json.last_name+' '+json.first_name);
			var config = {
				label:label,
				info:helpers.labels[json.namespace],
				iconURL:'connectors/crunchbase/images/'+json.namespace+'-16.png',
				 data:{
					kConnector:'crunchbase.' +json.namespace.replace('-',''),
					kTitle:label,
					permalink:json.permalink
				}
			};
			if (json.image)
			{
				config.iconURL = 'http://www.crunchbase.com/' + json.image.available_sizes[0][1];
			}
			return kTemplater.jQuery('line.navigation', config);
		}
	}
}

var helpers = window.kConnectors.crunchbase.helpers;

// -- company --
window.kConnectors.crunchbase.company = {
	// CSS file used by this connector
	cssFile : 'connectors/crunchbase/crunchbase.css', 
	// load content, dependening on the argument data
	loader : function(data, $panel, $kaiten){
		var defaultData = {
		};

		// merge default data with custom data
		var data2Send = $.extend({}, defaultData, data);
		if (!data2Send.permalink)
		{
			throw new Error('No permalink! Cannot retrieve company details.');
		}

		var self = this;

		// the API requires to dynamically build the URL, we have no data to send
		var url = 'http://api.crunchbase.com/v/1/company/'+data2Send.permalink+'.js?callback=?';

		// uncomment for offline development
		// var url = 'connectors/crunchbase/json/company.js';

		// perform our cross-domain AJX request to the public API and
		// use a custom function to convert JSON received into proper HTML
		return $.ajax({
			url			: url,
			type		: 'get',
			dataType	: 'json html',
			converters	: {
				'json html' : function(jsonData){
					if (jsonData.error)
					{
						throw new Error(jsonData.error);
					}
					$panel.kpanel('setTitle', jsonData.name);
					var $body = kTemplater.jQuery('panel.body');
					var $html = self.convertCompanyData(jsonData, $body, $kaiten);
					return $html;
				}
			}
		});
	},
	// when clicking on a link element, this function will be called to determine
	// if this connector can be used for loading the corresponding content
	connectable : function(href, $link) {
		var parts = href.split('/');
		var permalink = parts.pop();
		if ((href[0] == '/') || (href.indexOf('http://www.crunchbase.com/') > -1))
		{
			var namespace = parts.pop();
			return (namespace == 'company');
		}
		return false;
	},
	// if the previous function has returned true, the data to pass to the loader
	// is collected by this function
	getData : function(href, $link) {
		return {
			permalink : href.split('/').pop()
		};
	},
	/* JSON 2 HTML conversion functions */
	convertCompanyData : function(jsonData, $body, $kaiten) {
		var n, limit = 5, $block = kTemplater.jQuery('block.content');

		$block.append('<h1>'+jsonData.name+'</h1>');

		if (jsonData.image)
		{
			$block.append('<img class="company-img" src="http://www.crunchbase.com/'+jsonData.image.available_sizes[0][1]+'"/>');
		}

		if (jsonData.description)
		{
			$block.append('<h3>'+jsonData.description+'</h3>');
		}

		if (jsonData.overview)
		{
			$block.append(jsonData.overview);
		}

		$block.append('<h2>General informations</h2>');
		$block.append(helpers._infoLine(jsonData,'homepage_url'));
		$block.append(helpers._infoLine(jsonData,'blog_url'));
		$block.append(helpers._infoLine(jsonData,'number_of_employees'));
		$block.append(helpers._infoLine(jsonData,'twitter_username'));
		$block.append(helpers._infoLine(jsonData,'category_code'));
		$block.append(helpers._infoLine(jsonData,'email_address'));
		$block.append(helpers._infoLine(jsonData,'founded'));

		$body.append($block);

		$block = kTemplater.jQuery('block.navigation');
		$body.append($block);
		
		// tags
		if (jsonData.tag_list)
		{
			var tagsArray = jsonData.tag_list.split(', ');
			tagsArray.sort(function(a, b){
				return a > b;
			});
			
			var $tagsBlock = kTemplater.jQuery('block.navigation');
			kTemplater.jQuery('line.summary',{
				iconURL:'connectors/crunchbase/images/tag-32.png',
				label:'Tags',
				info:''
			}).appendTo($tagsBlock);
			
			$.each(tagsArray, function(ind, tag){
				$tagsBlock.append(kTemplater.jQuery('line.navigation', {
					iconURL:'connectors/crunchbase/images/tag-16.png',
					label : tag,
					data : { kConnector:'crunchbase.search', query:tag }
				}));
			});
			kTemplater.jQuery('line.navigation',{
				iconURL:'connectors/crunchbase/images/tag-16.png',
				label:'Tags',
				info:$tagsBlock.children('.items').size(),
				data:{
					kConnector:'html.string',
					html:kTemplater.jQuery('panel.body').append($tagsBlock),
					kTitle:'Tags'
				}
			}).appendTo($block);
		}

		// -- peoples --
		if (jsonData.relationships)
		{
			if (jsonData.relationships.length)
			{
				$block.append(kTemplater.jQuery('line.summary',{
					iconURL:'connectors/crunchbase/images/persons.png',
					label:'People',
					info:''
				}));

				var $allActivePeople = kTemplater.jQuery('block.navigation');
				$allActivePeople.append(kTemplater.jQuery('line.summary',{
					iconURL:'connectors/crunchbase/images/persons.png',
					label:'All Active People',
					info:''
				}));
			
				var $allFormerPeople = kTemplater.jQuery('block.navigation');
				$allFormerPeople.append(kTemplater.jQuery('line.summary',{
					iconURL:'connectors/crunchbase/images/persons.png',
					label:'All Former People',
					info:''
				}));

				var line, count = 0;

				$.each(jsonData.relationships,function(ind,relation){
					line = helpers._navigationLine(relation);
					if (relation.is_past == false)
					{
						$allActivePeople.append(line);
						if (count < limit)
						{
							$block.append(line.clone(true));
						}
						count++;
					}
					else
					{
						$allFormerPeople.append(line);
					}
				});

				if (count > limit)
				{
					kTemplater.jQuery('line.navigation',{
						iconURL:'connectors/crunchbase/images/persons.png',
						label:'All people...',
						info:$allActivePeople.children('.items').size(),
						data:{
							kConnector:'html.string',
							html:kTemplater.jQuery('panel.body').append($allActivePeople),
							kTitle : 'All Active People'
						}
					}).appendTo($block);
				}
			
				if ($allFormerPeople.children('.items').size()){
					kTemplater.jQuery('line.navigation',{
						iconURL:'connectors/crunchbase/images/persons.png',
						label:'Former people',
						info:$allFormerPeople.children('.items').size(),
						data:{
							kConnector:'html.string',
							html:kTemplater.jQuery('panel.body').append($allFormerPeople),
							kTitle : 'All Former People'
						}
					}).appendTo($block);
				}
			}
		}
		
		// -- products --
		if (jsonData.products)
		{
			if (jsonData.products.length)
			{
				$block.append(kTemplater.jQuery('line.summary',{
					iconURL:'connectors/crunchbase/images/product-32.png',
					label:'Products',
					info:''
				}));

				var $productsBlock = kTemplater.jQuery('block.navigation');
				kTemplater.jQuery('line.summary',{
					iconURL:'connectors/crunchbase/images/product-32.png',
					label:'Products',
					info:''
				}).appendTo($productsBlock);

				var count = 0;
				$.each(jsonData.products,function(ind,product){
					if (count < limit)
					{
						$block.append(kTemplater.jQuery('line.navigation', {
							//iconURL:'connectors/crunchbase/images/product-16.png',
							label : product.name,
							data : { kConnector:'crunchbase.product', permalink:product.permalink }
						}));
					};

					$productsBlock.append(kTemplater.jQuery('line.navigation', {
						//iconURL:'connectors/crunchbase/images/product-16.png',
						label : product.name,
						data : { kConnector:'crunchbase.product', permalink:product.permalink }
					}));

					count++;
				});

				if (count > limit) {
					kTemplater.jQuery('line.navigation',{
						iconURL:'connectors/crunchbase/images/product-16.png',
						label:'All Products...',
						info:$productsBlock.children('.items').size(),
						data:{
							kConnector:'html.string',
							html:kTemplater.jQuery('panel.body').append($productsBlock),
							kTitle : 'Products'
						}
					}).appendTo($block);
				}

			}
		}

		// -- competitors --
		if (jsonData.competitions)
		{
			if (jsonData.competitions.length)
			{
				$block.append(kTemplater.jQuery('line.summary',{
					iconURL:'connectors/crunchbase/images/company-32.png',
					label:'Competitors',
					info:''
				}));

				var $competitorsBlock = kTemplater.jQuery('block.navigation');
				kTemplater.jQuery('line.summary',{
					iconURL:'connectors/crunchbase/images/company-32.png',
					label:'Competitors',
					info:''
				}).appendTo($competitorsBlock);
			
				var count = 0;
				$.each(jsonData.competitions,function(ind,competition){
					if (count < limit)
					{
						$block.append(kTemplater.jQuery('line.navigation', {
							//iconURL:'connectors/crunchbase/images/company-16.png',
							label : competition.competitor.name,
							data : { kConnector:'crunchbase.company', permalink:competition.competitor.permalink }
						}));
					};

					$competitorsBlock.append(kTemplater.jQuery('line.navigation', {
						//iconURL:'connectors/crunchbase/images/company-16.png',
						label : competition.competitor.name,
						data : { kConnector:'crunchbase.company', permalink:competition.competitor.permalink }
					}));
				
					count++;
				});

				if (count > limit)
				{
					kTemplater.jQuery('line.navigation',{
						iconURL:'connectors/crunchbase/images/company-16.png',
						label:'All Competitors...',
						info:$competitorsBlock.children('.items').size(),
						data:{
							kConnector:'html.string',
							html:kTemplater.jQuery('panel.body').append($competitorsBlock),
							kTitle : 'Competitors'
						}
					}).appendTo($block);
				}
			}
		}

		$body.append('<div class="spacer"/>');
		return $body;
	}
};

window.kConnectors.crunchbase.financialorganization = {
	// CSS file used by this connector
	cssFile : 'connectors/crunchbase/crunchbase.css', 
	// load content, dependening on the argument data
	loader : function(data, $panel, $kaiten){
		var defaultData = {
		};

		// merge default data with custom data
		var data2Send = $.extend({}, defaultData, data);
		if (!data2Send.permalink)
		{
			throw new Error('No permalink! Cannot retrieve financial organization details.');
		}

		var self = this;

		// the API requires to dynamically build the URL, we have no data to send
		var url = 'http://api.crunchbase.com/v/1/financial-organization/'+data2Send.permalink+'.js?callback=?';

		// uncomment for offline development
		// var url = 'connectors/crunchbase/json/financial-organization.js';

		// perform our cross-domain AJX request to the public API and
		// use a custom function to convert JSON received into proper HTML
		return $.ajax({
			url			: url,
			type		: 'get',
			dataType	: 'json html',
			converters	: {
				'json html' : function(jsonData){
					if (jsonData.error)
					{
						throw new Error(jsonData.error);
					}
					$panel.kpanel('setTitle', jsonData.name);
					var $body = kTemplater.jQuery('panel.body');
					var $html = window.kConnectors.crunchbase.company.convertCompanyData(jsonData, $body, $kaiten);
					return $html;
				}
			}
		});
	},
	// when clicking on a link element, this function will be called to determine
	// if this connector can be used for loading the corresponding content
	connectable : function(href, $link) {
		var parts = href.split('/');
		var permalink = parts.pop();
		if ((href[0] == '/') || (href.indexOf('http://www.crunchbase.com/') > -1))
		{
			var namespace = parts.pop();
			return (namespace == 'financial-organization');
		}
		return false;
	},
	// if the previous function has returned true, the data to pass to the loader
	// is collected by this function
	getData : function(href, $link) {
		return {
			permalink : href.split('/').pop()
		};
	}
}

// -- product --
window.kConnectors.crunchbase.product = {
	// CSS file used by this connector
	cssFile : 'connectors/crunchbase/crunchbase.css', 
	// load content, dependening on the argument data
	loader : function(data, $panel, $kaiten){
		var defaultData = {
		};

		// merge default data with custom data
		var data2Send = $.extend({}, defaultData, data);
		if (!data2Send.permalink)
		{
			throw new Error('No permalink! Cannot retrieve product details.');
		}

		var self = this;

		// the API requires to dynamically build the URL, we have no data to send
		var url = 'http://api.crunchbase.com/v/1/product/'+data2Send.permalink+'.js?callback=?';

		// uncomment for offline development
		// var url = 'connectors/crunchbase/json/product.js';

		// perform our cross-domain AJX request to the public API and
		// use a custom function to convert JSON received into proper HTML
		return $.ajax({
			url			: url,
			type		: 'get',
			dataType	: 'json html',
			converters	: {
				'json html' : function(jsonData){
					if (jsonData.error)
					{
						throw new Error(jsonData.error);
					}
					$panel.kpanel('setTitle', jsonData.name);
					var $body = kTemplater.jQuery('panel.body');
					var $html = self.convertProductData(jsonData, $body, $kaiten);
					return $html;
				}
			}
		});
	},
	// when clicking on a link element, this function will be called to determine
	// if this connector can be used for loading the corresponding content
	connectable : function(href, $link) {
		var parts = href.split('/');
		var permalink = parts.pop();
		if ((href[0] == '/') || (href.indexOf('http://www.crunchbase.com/') > -1))
		{
			var namespace = parts.pop();
			return (namespace == 'product');
		}
		return false;
	},
	// if the previous function has returned true, the data to pass to the loader
	// is collected by this function
	getData : function(href, $link) {
		return {
			permalink : href.split('/').pop()
		};
	},
	/* JSON 2 HTML conversion functions */
	convertProductData : function(jsonData, $body, $kaiten) {
		var n, $block = kTemplater.jQuery('block.content');
		// general description
		if (jsonData.image)
		{
			$block.append('<img class="product-img" src="http://www.crunchbase.com/'+jsonData.image.available_sizes[0][1]+'"/>');
		}
		$block.append('<h1>'+jsonData.name+'</h1>');

		if (jsonData.overview)
		{
			$block.append(jsonData.overview);
		}

		$block.append('<h2>General informations</h2>');
		$block.append(helpers._infoLine(jsonData,'launched'));
		$block.append(helpers._infoLine(jsonData,'homepage_url'));
		$block.append(helpers._infoLine(jsonData,'twitter_username'));

		$body.append($block);
		// company
		if (jsonData.company)
		{
			$block = kTemplater.jQuery('block.navigation');
			$block.append(kTemplater.jQuery('line.summary',{
				iconURL:'connectors/crunchbase/images/company-32.png',
				label:'Company',
				info:''
			}));
			$body.append($block);

			$block.append(kTemplater.jQuery('line.navigation', {
				label : jsonData.company.name,
				data : { kConnector:'crunchbase.company', permalink:jsonData.company.permalink }
			}));
			$body.append($block);
		}
		return $body;
	}
};

// -- person --
window.kConnectors.crunchbase.person = {
	// CSS file used by this connector
	cssFile : 'connectors/crunchbase/crunchbase.css', 
	// load content, dependening on the argument data
	loader : function(data, $panel, $kaiten){
		var defaultData = { 
		};

		// merge default data with custom data
		var data2Send = $.extend({}, defaultData, data);
		if (!data2Send.permalink)
		{
			throw new Error('No permalink! Cannot retrieve person details.');
		}

		var self = this;

		// the API requires to dynamically build the URL, we have no data to send
		var url = 'http://api.crunchbase.com/v/1/person/'+data2Send.permalink+'.js?callback=?';

		// uncomment for offline development
		// var url = 'connectors/crunchbase/json/person.js';

		// perform our cross-domain AJX request to the public API and
		// use a custom function to convert JSON received into proper HTML
		return $.ajax({
			url			: url,
			type		: 'get',
			dataType	: 'json html',
			converters	: {
				'json html' : function(jsonData){
					if (jsonData.error)
					{
						throw new Error(jsonData.error);
					}
					$panel.kpanel('setTitle', jsonData.first_name+' '+jsonData.last_name);
					var $body = kTemplater.jQuery('panel.body');
					var $html = self.convertPersonData(jsonData, $body, $kaiten);
					return $html;
				}
			}
		});
	},
	// when clicking on a link element, this function will be called to determine
	// if this connector can be used for loading the corresponding content
	connectable : function(href, $link) {
		var parts = href.split('/');
		var permalink = parts.pop();
		if ((href[0] == '/') || (href.indexOf('http://www.crunchbase.com/') > -1))
		{
			var namespace = parts.pop();
			return (namespace == 'person');
		}
		return false;
	},
	// if the previous function has returned true, the data to pass to the loader
	// is collected by this function
	getData : function(href, $link) {
		return {
			permalink : href.split('/').pop()
		};
	},
	/* JSON 2 HTML conversion functions */
	convertPersonData : function(jsonData, $body, $kaiten) {
		var $block = kTemplater.jQuery('block.content');
		// general description
		if (jsonData.image)
		{
			$block.append('<img class="product-img" src="http://www.crunchbase.com/'+jsonData.image.available_sizes[0][1]+'"/>');
		}
		$block.append('<h1>'+jsonData.first_name+' '+jsonData.last_name+'</h1>');
		$body.append($block);
		if (jsonData.overview)
		{
			$block.append(jsonData.overview);
		}
		// companies
		if (jsonData.relationships.length)
		{
			$block = kTemplater.jQuery('block.navigation');
			$block.append(kTemplater.jQuery('line.summary',{
				iconURL:'connectors/crunchbase/images/company-32.png',
				label:'Companies',
				info:''
			}));

			$body.append($block);

			var relation;
			for (var n in jsonData.relationships)
			{
				if (jsonData.relationships.hasOwnProperty(n))
				{
					relation = jsonData.relationships[n];
					$block.append(kTemplater.jQuery('line.navigation', {
						label : relation.firm.name,
						info : relation.title,
						data : { kConnector:'crunchbase.company', permalink:relation.firm.permalink }
					}));
					$body.append($block);
				}
			}
		}
		return $body;
	}
};

//MAP CONNECTOR
window.kConnectors.crunchbase.map = {
	// when clicking on a link element, this function will be called to determine
	// if this connector can be used for loading the corresponding content
	connectable : function(href, $link) {
		var parts = href.split('/');
		var permalink = parts.pop();
		var location = parts.pop();
		if ((href[0] == '/') || (href.indexOf('http://www.crunchbase.com/') > -1))
		{
			var namespace = parts.pop();
			return (namespace == 'maps');
		}
		return false;
	},
	// if the previous function has returned true, the data to pass to the loader
	// is collected by this function
	getData : function(href, $link) {
		// switch to the iframe connector
		return {
			kConnector : 'iframe',
			href : 'http://www.crunchbase.com'+href
		};
	}
};


// -- home --
window.kConnectors.crunchbase.home = {
	cssFile : 'connectors/crunchbase/crunchbase.css',
	loader : function(data, $panel, $kaiten){
		var $header = kTemplater.jQuery('panel.header');
		var $block = kTemplater.jQuery('block.navigation');
		
		$block.append(kTemplater.jQuery('line.search').submit( function(e) {
				e.preventDefault();
				var query = $(this).find('input:text').val();
				$K.kaiten('load', { kConnector:'crunchbase.search', query:query },$(this));

				$block.append(kTemplater.jQuery('line.navigation', {
					label : 'Search: ' + query,
					data : { kConnector:'crunchbase.search', query:query }
				}));

			})
		);
		$header.append($block);

		var $body = kTemplater.jQuery('panel.body');
		$block = kTemplater.jQuery('block.navigation');

		$block.append(kTemplater.jQuery('line.navigation', {
			label : 'Company',
			data : { kConnector:'crunchbase.company', permalink:'apple' }
		}));

		$block.append(kTemplater.jQuery('line.navigation', {
			label : 'Person',
			data : { kConnector:'crunchbase.person', permalink:'steve-jobs' }
		}));

		$block.append(kTemplater.jQuery('line.navigation', {
			label : 'Product',
			data : { kConnector:'crunchbase.product', permalink:'iphone' }
		}));

		$body.append($block);
		return $header.add($body);
	},
	connectable : function(href, $link) {
		var isCrunchbaseHome = /^https?:\/\/www\.crunchbase\.com\/?$/;	  
		return isCrunchbaseHome.test(href);
	}
};


// -- search --
window.kConnectors.crunchbase.search = {
	cssFile : 'connectors/crunchbase/crunchbase.css', 
	loader : function(data, $panel, $kaiten)
	{
		if (!data.query)
		{
			throw new Error('No query!');
		}

		var url = 'http://api.crunchbase.com/v/1/search.js?query='+data.query+'&callback=?';

		// uncomment for offline development
		// var url = 'connectors/crunchbase/json/search.js';

		return $.ajax({
			url			: url,
			type		: 'get',
			dataType	: 'json html',
			//data		: data,
			converters	: {
				'json html' : function(jsonData) {
					if (jsonData.error)
					{
						throw new Error(jsonData.error);
					}
					$panel.kpanel('setTitle', 'Search '+data.query);

					var $header = kTemplater.jQuery('panel.header');
					var $body = kTemplater.jQuery('panel.body');

					// -- search input --
					var $block = kTemplater.jQuery('block.navigation');
					$block.append(kTemplater.jQuery('line.search',{text:data.query}).submit(function(e) {
						e.preventDefault();
						var query = $(this).find('input:text').val();
						$panel.kpanel('reload',{ query:query , kTitle:'Search: '+query });
					}));
					$header.append($block);

					// here loop in results
					var total = jsonData.total;
					if (total === 0)
					{
						$body.append(kTemplater.jQuery('block.noresults', { content : 'No results' }));
					}
					else
					{
						var $results = kTemplater.jQuery('block.navigation');

						if (total > 25) 
						{
							// paginate
						}

						for (var i=0, l=jsonData.results.length; i<l; i++)
						{
							$results.append(helpers._navigationLine(jsonData.results[i]));
						}

						if (total > 25) 
						{
							// paginate
						}
						$body.append($results);
					}
					
					return $header.add($body);
				}
			}
		});
	}
};