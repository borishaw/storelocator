if (!self.jaSLWI) {
	var jaSLWI = {
		jaSLWIInit: function() {
			jaSLWI.modules = document.getElementsByClassName("ja-slwi");
			jaSLWI.modulesText = document.getElementsByClassName("ja-slwi-text");
			var x = new Fx.Elements(jaSLWI.modulesText, { wait: false, duration: 250 });

		var obj = {};
			jaSLWI.modules.each(function(module, i) {
				jaSLWI.modulesText[i].collapseH = module.getElementsByTagName('H3')[0].offsetHeight;
				obj[i] = { 'height': [jaSLWI.modulesText[i].getStyle('height').toInt(), jaSLWI.modulesText[i].collapseH]};
				module.addEvent('mouseenter', function(e) {
					var obj = {};
					obj[i] = { 'height': [jaSLWI.modulesText[i].getStyle('height').toInt(), jaSLWI.expandH]};
					jaSLWI.modules.each(function(other, j) {
						if (other != module) {
							var h = jaSLWI.modulesText[j].getStyle('height').toInt();
							if (h != jaSLWI.modulesText[j].collapseH) obj[j] = { 'height': [h, jaSLWI.modulesText[j].collapseH] };
						}
					});
					x.start(obj);
				});

				module.addEvent('mouseleave', function(e) {
					var obj = {};
					jaSLWI.modules.each(function(other, j) {
						obj[j] = { 'height': [jaSLWI.modulesText[j].getStyle('height').toInt(), jaSLWI.modulesText[j].collapseH]};
					});
					x.start(obj);
				});
			});
			x.start(obj);
		}
	}

	window.addEvent('domready', jaSLWI.jaSLWIInit);
}
