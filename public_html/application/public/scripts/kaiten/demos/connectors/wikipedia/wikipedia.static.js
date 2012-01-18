(function($kt){
	if (!window.kConnectors.wikipedia){window.kConnectors.wikipedia = {};}

	window.kConnectors.wikipedia.static = {
		cssFile : 'connectors/wikipedia/wikipedia.css',
		loader:function(data, $panel, $kaiten){
			$panel.data('connector','wikipedia.static');
			if (!data.domain)
			{
				data.domain = $panel.prev().data('domain') || window.kConnectors.wikipedia.domain;
			}
		 	$panel.data('domain',data.domain);
			if (!data.formated)
			{
				data.formated = data.formater(data.source, data.title || data.kTitle);
			}
			return data.formated;
		}
	};
}(kTemplater.jQuery));