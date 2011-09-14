(function($kt,trad){
	if (!window.kConnectors.wikipedia){window.kConnectors.wikipedia = {};}

	window.kConnectors.wikipedia.home = {
		cssFile : 'connectors/wikipedia/wikipedia.css',
		loader:function(data, $panel, $kaiten){
			$panel.data('connector','wikipedia.home');
		 	$panel.data('domain',window.kConnectors.wikipedia.domain);

			$panel.kpanel('setTitle', 'Wikipedia');

			var $body = $kt('panel.body');
			$kt('block.navigation')
				/*.append($kt('line.summary',{
							id:'translate-home-summary',
							iconURL:'connectors/wikipedia/images/kaiten-32.png',
							label:trad.get('home-summary').label,
							info:trad.get('home-summary').info
						})
					)*/
				.append($kt('line.summary',{
							iconURL:'connectors/wikipedia/images/wikipedia.png',
							label:'Wikipedia',
							info:''
						})
					)
				.append($kt('line.search').submit(function(evt){
							evt.preventDefault();
							var query = $(this).find('input:text').val();
							$kaiten.kaiten('load', {
								kConnector: 'wikipedia.search',
								query:query,
								title:trad.get('search')+' '+query,
								kTitle : trad.get('search')+' '+query
							},$(this));
						})
					)
				.append($kt('line.navigation',{
							id:'translate-navmain',
							label:trad.get('navmain').label,
							iconURL:'connectors/wikipedia/images/wikipedia-16.png',
							data:{
								kConnector:'wikipedia.page',
								kWidth:'800px'
							}
						})
					)
				.append($kt('line.navigation',{
						id:'translate-navlang',
						label:trad.get('navlang').label,
						info:languages[window.kConnectors.wikipedia.currentLanguage],
						data:{
							kConnector:'wikipedia.languages',
							kTitle:trad.get('navlang').label
						}
					})
				)
				.appendTo($body);

			return $body;
		}
	};
}(kTemplater.jQuery,window.kConnectors.languages));