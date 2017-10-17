(function(d, w, jq){
	var dom = {
		header : jq("header.main_header"),
		sidebar : jq(".main_sidebar"),
		episodes_list : jq(".episodes_list"),
		direction_nav : jq(".direction_nav"),
		browse_filter : jq(".browse_filter"),
		episode_media : jq(".episode_media"),
		seasons_list : jq("ul.seasons"),
		episodes : jq("ul.episodes"),
		categories_link : jq(".categories_link"),
	}

	jq(d).ready(function(){
		/* -------------------
		 * EPISODES LIST CAROUSSEL
		 * ------------------- */
		if(dom.episodes_list.length){
			dom.episodes_list.flexslider({
				animation: "slide",
				controlNav : false,
				directionNav : false,
				itemWidth: 200,
				itemMargin: 15
			});
			dom.direction_nav.find("i.icon").on("click", function(){
				if(jq(this).hasClass("next")) 
					dom.episodes_list.flexslider("next");
				else 
					dom.episodes_list.flexslider("previous");
			});
		}

		dom.categories_link.on("click", function(e){
			e.preventDefault();
			jq(this).next(".categories_menu").slideToggle(200);
		});

		/* -------------------
		 * FILTER TABS
		 * ------------------- */
		if(dom.browse_filter.length){
			var x = dom.browse_filter.find(".filter_item").first().width();
			dom.browse_filter.find(".line").css({
				width : x + "px"
			});
			dom.browse_filter.find(".filter_item").on("click", function(e){
				e.preventDefault();
				dom.browse_filter.find(".filter_item.active").removeClass("active");
				jq(this).addClass("active");

				var x = jq(this).width();
				var left = jq(this).offset().left - jq(this).parent().offset().left;
				jq(this).parent().children(".line").css({
					left : left + "px",
					width : x + "px"
				});
				var speed = 200;
				jq(".series_list").find("li").each(function(){ jq(this).fadeOut(speed); });

				var index = jq(this).html().toLowerCase();
				setTimeout(function(){ 
					var h = '<i class="icon ion-ios-refresh-empty" style="font-size:24px;margin-right:10px"></i> Loading ...';
					jq(".series_list").html(h);

					$.ajax({
						type : "post",
						url  : "index.php?p=filter-series&r=true",
						data : {
							"index" : index
						},
						success : function(data){
							jq(".series_list").html(data);
							jq(".series_list").find("li").each(function(){
								jq(this).fadeIn(200);
							});
						}
					});
				}, speed);
			});
		}

		/* -------------------
		 * EPISODE MEDIA HOVER
		 * ------------------- */
		var mouse_entered = false;
		dom.episode_media.each(function(){
			jq(this).on("mouseenter", function(){
				dom.episode_media.each(function(){ jq(this).css("opacity", .5); });
				jq(this).css("opacity", 1);
				mouse_entered = true;
			});
			jq(this).on("mouseleave", function(){
				if(mouse_entered === true){
					dom.episode_media.each(function(){ jq(this).css("opacity", 1); });
					mouse_entered = false;
				}
			});
		});

		/* -------------------
		 * SWITCH SEASONS
		 * ------------------- */
		if(dom.seasons_list.length){
			var self = dom.seasons_list;
			self.find("a").on("click", function(e){
				e.preventDefault();
				self.find("a.active").removeClass("active");
				jq(this).addClass("active");
				var season = parseInt(jq(this).html());

				dom.episodes.fadeOut(200);

				$.ajax({
					type : "post",
					url  : "index.php?p=episodes-by-season&r=true",
					data : {
						"id_series" : jq(".id_series").html(),
						"season" : season,
					},
					success : function(data){
						setTimeout(function(){
							dom.episodes.html(data);
							dom.episodes.fadeIn(200);
						}, 200);
					}
				});
			});
		}


		jq(".disclaimer_link").on("click", function(e){
			e.preventDefault();
			jq(".disclaimer").fadeIn(200);

			jq(".close_popup").on("click", function(e){
				e.preventDefault();
				jq(this).parents(".popup").fadeOut(200);
			});
		});

		
	})
})(document, window, jQuery);
