(function(){
	if (!window.kConnectors.wikipedia){window.kConnectors.wikipedia = {};}

	window.kConnectors.wikipedia.footer = '<p class="nectil-footer">Text is available under the Creative Commons Attribution-ShareAlike License; additional terms may apply. See Terms of Use for details.</p>';
	window.kConnectors.wikipedia.currentLanguage = window.kConnectors.languages.userLanguage();
	window.kConnectors.wikipedia.domain = 'http://'+window.kConnectors.wikipedia.currentLanguage+'.wikipedia.org';
	window.kConnectors.wikipedia.isWikipediaDomain =  /^(http|https):\/\/[a-z]{2,3}.wikipedia\.org\/wiki\//;
}());
