/* twitter connectors

connectors : {
	"twitter.timeline" : window.kConnectors.twitter.timeline,
	"twitter.search" : window.kConnectors.twitter.search,
	"twitter.tweets" : window.kConnectors.twitter.tweets,
	"twitter.following" : window.kConnectors.twitter.following,
	"twitter.followers" : window.kConnectors.twitter.followers
}

*/

if (!window.kConnectors)
	window.kConnectors = {};

if (!window.kConnectors.twitter)
	window.kConnectors.twitter = {};

// -- timeline --

window.kConnectors.twitter.timeline = {
	cssFile : 'connectors/twitter/twitter.css',
	loader : function(data, $panel, $kaiten)
	{
		return $.ajax({
			url			: 'http://api.twitter.com/1/statuses/public_timeline.json?callback=?',
			type		: 'get',
			dataType	: 'json html',
			converters	: {
				'json html' : function(jsonData) {
					if (jsonData.error) {
						throw new Error(jsonData.error);
					}
					
					$panel.kpanel('setTitle', 'Timeline');

					var $header = kTemplater.jQuery('panel.header');		
					var $block = kTemplater.jQuery('block.navigation');
					$block.append(kTemplater.jQuery('line.search').submit( function(e) {
							e.preventDefault();
							var query = $(this).find('input:text').val();
							$K.kaiten('load', { kConnector:'twitter.search', q:query , title:'Search: '+query },$(this));
						})
					);
					$header.append($block);

					var tweetsHTML = '';
					for (var i=0, l=jsonData.length, d; i<l; i++) {
						tweet = jsonData[i];
						tweetsHTML += window.kConnectors.twitter.markupTweet(tweet);
					}
					var $body = kTemplater.jQuery('panel.body', { content : kTemplater.html('block.navigation', { content : tweetsHTML }) });

					return $header.add($body);
				}
			}
		});
	},
	connectable : function(href, $link)
	{
		var isTimeline = /^https?:\/\/twitter\.com(?:\/#!)?\/?$/;	  
		return isTimeline.test(href);
	},
	getData : function(href, $link)
	{
		return {q:href.split('?q=').pop()};
	}
};

// -- search --
window.kConnectors.twitter.search = {
	cssFile : 'connectors/twitter/twitter.css',
	loader : function(data, $panel, $kaiten)
	{
		if (!data.q)
		{
			throw new Error('No query!');
		}

		return $.ajax({
			url			: 'http://search.twitter.com/search.json?callback=?',
			type		: 'get',
			dataType	: 'json html',
			data		: data,
			converters	: {
				'json html' : function(jsonData)
				{
					if (jsonData.error)
					{
						throw new Error(jsonData.error);
					}

					$panel.kpanel('setTitle', 'Search: '+data.q);

					var $header = kTemplater.jQuery('panel.header');											
					var $block = kTemplater.jQuery('block.navigation');
					$block.append(kTemplater.jQuery('line.search',{text:data.q}).submit(function(e) {
							e.preventDefault();
							var query = $(this).find('input:text').val();
							$panel.kpanel('reload',{ q:query , title:'Search: '+query });
						})
					);
					$header.append($block);

					var tweetsHTML = '', l=jsonData.results.length;
					if (l === 0)
					{
						tweetsHTML += kTemplater.html('block.noresults', { content : 'No results' });
					}
					else
					{
						for (var i=0, l=jsonData.results.length, d; i<l; i++)
						{
							tweet = jsonData.results[i];
							tweetsHTML += window.kConnectors.twitter.markupTweet(tweet);
						}
					}
					var $body = kTemplater.jQuery('panel.body', { content : kTemplater.html('block.navigation', { content : tweetsHTML }) });

					return $header.add($body);
				}
			}
		});
	},
	connectable : function(href, $link)
	{
		var isTwitterSearch  = /^https?:\/\/(?:search\.twitter\.com.*|twitter\.com\/#!\/search.*|twitter\.com\/search\?q\=.*)$/;
		return isTwitterSearch.test(href);
	},
	getData : function(href, $link)
	{
		return {q:href.split('?q=').pop()};
	}
};

// -- tweets --
window.kConnectors.twitter.tweets = {
	cssFile : 'connectors/twitter/twitter.css',
	loader : function(data, $panel, $kaiten)
	{
		if (!data.screen_name)
		{
			throw new Error('No User Defined');
		}

		return $.ajax({
			url			: 'http://api.twitter.com/1/statuses/user_timeline.json?callback=?',
			type		: 'get',
			dataType	: 'json html',
			data		: data,
			converters	: {
				'json html' : function(jsonData)
				{
					if (jsonData.error) {
						throw new Error(jsonData.error);
					}
					
					$panel.kpanel('setTitle', '@'+data.screen_name);

					var user = jsonData[0].user;

					var $header = kTemplater.jQuery('panel.header');
					$header.append(window.kConnectors.twitter.markupProfile(user));
										
					var $body = kTemplater.jQuery('panel.body');
					
					var $block = kTemplater.jQuery('block.navigation');
					$block.append(kTemplater.jQuery('line.navigation', {
						label : 'Following',
						info: user.friends_count + ' friends',
						data: { kConnector:'twitter.following' , kTitle:'Following' , screen_name:user.screen_name }
					}));
					$block.append(kTemplater.jQuery('line.navigation', {
						label: 'Followers',
						info: user.followers_count + ' users',
						data: { kConnector:"twitter.followers" , kTitle:data.screen_name+ " Followers" , screen_name:data.screen_name }
					}));
					$body.append($block);

					$block = kTemplater.jQuery('block.navigation');
					if (user.profile_background_image_url)
						$block.css('background-image','url("'+ user.profile_background_image_url +'")');
					// add the tweets
					for (var i=0, l=jsonData.length, d; i<l; i++) {
						$block.append(window.kConnectors.twitter.markupTweet(jsonData[i]));
					}

					$body.append($block);
				
					return $header.add($body);
				}
			}
		});
	},
	connectable : function(href, $link)
	{
		var	isTwitterSearch  = /^https?:\/\/(?:search\.twitter\.com.*|twitter\.com\/#!\/search.*)$/,
			isTwitterAccount = /^https?:\/\/twitter\.com(?:\/#!)?\/\w+?(?!\/.*)$/;	  

		return !isTwitterSearch.test(href) && isTwitterAccount.test(href);
	},
	getData : function(href, $link)
	{
		var screen_name = href.split('#!/').pop();
		return {screen_name:screen_name,kTitle:screen_name};
	}
};

// -- following --
window.kConnectors.twitter.following = {
	cssFile : 'connectors/twitter/twitter.css',
	loader : function(data, $panel, $kaiten)
	{
		if (!data.screen_name)
		{
			throw new Error('No User Defined');
		}
		return $.ajax({
			url			: 'http://api.twitter.com/1/statuses/friends.json?callback=?',
			type		: 'get',
			dataType	: 'json html',
			data		: data,
			converters	: {
				'json html' : function(jsonData) {
					if (jsonData.error) {
						throw new Error(jsonData.error);
					}
					
					var block, l=jsonData.length;
					if (l > 0)
					{
						var usersHTML = '';
						for (var i=0, d; i<l; i++) {
							user = jsonData[i];
							usersHTML += window.kConnectors.twitter.markupUser(user);
						}
						block = kTemplater.html('block.navigation', { content : usersHTML });
					}
					else
					{
						block = kTemplater.html('block.noresults', { content : 'No friends' })
					}
					var html = kTemplater.html('panel.body', { content : block });											
					return html;
				}
			}
		});
	},
	connectable : function(href, $link)
	{
		var isFollowing = /^https?:\/\/twitter\.com(?:\/#!)?\/\w+?\/following\/?$/;	  
		return isFollowing.test(href);
	},
	getData : function(href, $link)
	{
		var params = href.split('/');
		params.pop();
		return {screen_name:params.pop()};
	},
};

// -- followers --
window.kConnectors.twitter.followers = {
	cssFile : 'connectors/twitter/twitter.css',
	loader : function(data, $panel, $kaiten)
	{
		if (!data.screen_name) {	
			throw new Error('No User Defined');
		}
		return $.ajax({
			url			: 'http://api.twitter.com/1/statuses/followers.json?callback=?',
			type		: 'get',
			dataType	: 'json html',
			data		: data,
			converters	: {
				'json html' : function(jsonData) {
					if (jsonData.error) {
						throw new Error(jsonData.error);
					}
					var block, l=jsonData.length;
					if (l > 0)
					{
						var usersHTML = '';
						for (var i=0, d; i<l; i++) {
							user = jsonData[i];
							usersHTML += window.kConnectors.twitter.markupUser(user);
						}
						block = kTemplater.html('block.navigation', { content : usersHTML });
					}
					else
					{
						block = kTemplater.html('block.noresults', { content : 'No followers' })
					}
					var html = kTemplater.html('panel.body', { content : block });	
					return html;
				}
			}
		});
	},
	connectable : function(href, $link)
	{
		var isFollowers = /^https?:\/\/twitter\.com(?:\/#!)?\/\w+?\/followers\/?$/;	  
		return isFollowers.test(href);
	},
	getData : function(href, $link)
	{
		var params = href.split('/');
		params.pop();
		return {screen_name:params.pop()};
	}
};

// -- tools --
window.kConnectors.twitter.linkTweet = function(tweet)
{
	if (!tweet)
	{
		return;
	}
	tweet = tweet.replace(/http([^\s]+)/g, function(m, c)
	{
		return m.link('http'+c);
	}).replace(/\B@(\w+)/g, function(m, c)
	{
		return m.link('http://twitter.com/#!/'+c);
	}).replace(/\B#(\w+)/g, function(m, c)
	{
		return m.link('http://twitter.com/search?q=#'+c);
	}).replace(/[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g, function(m, c)
	{
		 return '<a href="mailto:'+m+'">'+m+'</a>';
	});
	return tweet;
}

window.kConnectors.twitter.markupTweet = function(jsonTweet)
{
	var markup = '<div class="tweet">';
	if (jsonTweet.profile_background_image_url)
		markup = '<div class="tweet translucid">';
	if (jsonTweet.user) {
		if (jsonTweet.user.protected) {alert(jsonTweet.user.name+' protected!')};
		
		markup += '<a class="link-profile" href="http://twitter.com/#!/'+jsonTweet.user.screen_name+'" title="'+jsonTweet.user.name+' profile"><img src="'+jsonTweet.user.profile_image_url+'" class="photo normal" /></a>';
		markup += '<h4>'+jsonTweet.user.screen_name+' <small>'+jsonTweet.user.name+'</small><span>'+prettyDate(jsonTweet.created_at)+'</span></h4>';
	} else {
		if (jsonTweet.protected) {alert(jsonTweet.from_user+' protected!')};

		markup += '<a class="link-profile" href="http://twitter.com/#!/'+jsonTweet.from_user+'" title="'+jsonTweet.from_user+' profile"><img src="'+jsonTweet.profile_image_url+'" class="photo normal" /></a>';
		markup += '<h4><strong>'+jsonTweet.from_user+'</strong></h4>';
	}
	markup += '<p>'+this.linkTweet(jsonTweet.text)+'</p>';
	markup += '</div>';
	return markup;
}

window.kConnectors.twitter.markupUser = function(jsonUser)
{
	var markup = '<div class="tweet">';
	markup += '<a class="link-profile" href="http://twitter.com/#!/'+jsonUser.screen_name+'" title="'+jsonUser.name+'"><img src="'+jsonUser.profile_image_url+'" class="photo normal" /></a>';
	if (jsonUser.status)
	{
		markup += '<h4><strong>'+jsonUser.screen_name+'</strong> '+jsonUser.name+'<span>'+prettyDate(jsonUser.status.created_at)+'</span></h4>';
		markup += '<p>'+this.linkTweet(jsonUser.status.text)+'</p>';
	}
	else
	{
		markup += '<h4><strong>'+jsonUser.screen_name+'</strong> '+jsonUser.name+'</h4>';
		markup += '<p>'+jsonUser.description+'</p>';
	}
	markup += '</div>';
	return markup;
}

window.kConnectors.twitter.markupProfile = function(jsonUser)
{
	var markup = '<div class="profile">';
	markup += '<img class="photo bigger" src="http://api.twitter.com/1/users/profile_image/twitter.json?size=bigger&screen_name='+jsonUser.screen_name+'"/>';
	markup += '<h2>'+jsonUser.name+'</h2>';
	markup += '<h3>@'+jsonUser.screen_name+' <small>'+jsonUser.location+'</small></h3>';
	markup += '<p>'+this.linkTweet(jsonUser.description)+'</p>';
	if (jsonUser.url)
	{
		markup += '<p><a href="'+jsonUser.url+'">'+jsonUser.url.split('//').pop()+'</a></p>';
	}
	markup += '</div>';
	return markup;
}

/*
* JavaScript Pretty Date
* Copyright (c) 2008 John Resig (jquery.com)
* Licensed under the MIT license.
*/
function prettyDate(time){
	var date = new Date((time || "")),
		diff = (((new Date()).getTime() - date.getTime()) / 1000),
		day_diff = Math.floor(diff / 86400);
	if ( isNaN(day_diff) || day_diff < 0 || day_diff >= 31 )
	{
		return;
	}
	return day_diff == 0 && (
		diff < 60 && "just now" ||
		diff < 120 && "1 minute ago" ||
		diff < 3600 && Math.floor( diff / 60 ) + " minutes ago" ||
		diff < 7200 && "1 hour ago" ||
		diff < 86400 && Math.floor( diff / 3600 ) + " hours ago") ||
		day_diff == 1 && "Yesterday" ||
		day_diff < 7 && day_diff + " days ago" ||
		day_diff < 31 && Math.ceil( day_diff / 7 ) + " weeks ago";
}

// If jQuery is included in the page, adds a jQuery plugin to handle it as well
if ( typeof jQuery != "undefined" )
{
	jQuery.fn.prettyDate = function(){
		return this.each(function(){
			var date = prettyDate(this.title);
			if ( date )
				jQuery(this).text( date );
		});
	}
}
