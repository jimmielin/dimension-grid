(function($){
	$.fn.colorTip = function(settings){

		var defaultSettings = {
			color		: 'yellow',
			timeout		: 500
		}
		
		var supportedColors = ['red','green','blue','white','yellow','black'];
		
		/* Combining the default settings object with the supplied one */
		settings = $.extend(defaultSettings,settings);

		/*
		*	Looping through all the elements and returning them afterwards.
		*	This will add chainability to the plugin.
		*/
		
		return this.each(function(){
			var elem = $(this);
			if(!elem.attr('title')) return true;
			var scheduleEvent = new eventScheduler();
			var tip = new Tip(elem.attr('title'));

			elem.append(tip.generate()).addClass('colorTipContainer');

			var hasClass = false;
			for(var i=0;i<supportedColors.length;i++)
			{
				if(elem.hasClass(supportedColors[i])){
					hasClass = true;
					break;
				}
			}
			
			if(!hasClass){
				elem.addClass(settings.color);
			}
			
			elem.hover(function(){
				tip.show();
				scheduleEvent.clear();

			},function(){
				scheduleEvent.set(function(){
					tip.hide();
				},settings.timeout);
			});
			elem.removeAttr('title');
		});
		
	}
	/*
	/	Event Scheduler Class Definition
	*/
	function eventScheduler(){}
	eventScheduler.prototype = {
		set	: function (func,timeout){
			this.timer = setTimeout(func,timeout);
		},
		clear: function(){
			clearTimeout(this.timer);
		}
	}

	function Tip(txt){
		this.content = txt;
		this.shown = false;
	}
	
	Tip.prototype = {
		generate: function(){
			return this.tip || (this.tip = $('<span class="colorTip">'+this.content+
											 '<span class="pointyTipShadow"></span><span class="pointyTip"></span></span>'));
		},
		show: function(){
			if(this.shown) return;

			// Center the tip and start a fadeIn animation
			this.tip.css('margin-left',-this.tip.outerWidth()/2 + 7).fadeIn(200);
			this.shown = true;
		},
		hide: function(){
			this.tip.fadeOut(600);
			this.shown = false;
		}
	}
	
})(jQuery);
