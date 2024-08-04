/**
 * version 1.0.1
 *
 * 使用方法
 * var loader_overlay = loader.show('#parent_frame');
 * loader.hide(loader_overlay);
 * (1度に2つ以上は使用できます)
 *
 * 必要ライブラリ
 * jquery
 *
 * カスタマイズ
 * background_color : 背景色
 * opacity : 透明度
 * gif : GIF を base64 したもの このサイトが便利→ http://blog.thingslabo.com/archives/000058.html
 * gif_width : GIFの幅
 * gif_height : GIFの高さ
 */

new function() {
	loader = {
			background_color: '#0b0b0b',
			opacity: 0.6,
			gif: '',
			gif_width:24,
			gif_height:24,
			overlay: null,
			show: function(parent,time=1000) {

				//console.debug('■');
				if ($(parent).find('#loader_overlay').length > 0) {
					return null;
				}
				var height = $(window).outerHeight()+200;
				var width = $(parent).outerWidth();

				$(parent).css('position', 'relative');
				var loader_overlay = " \
					<div id='loader_overlay'> \
						<div style='position:relative;'> \
							<span style='font-wieght:bold; color:#fff; text-align:center; width:100%; position:absolute; left:0; top:30px; display:block;'>Loading</span> \
							<img /> \
						</div> \
					</div> \
";
				loader.overlay = $(loader_overlay).clone();
				if (parent == 'body') {
					$(loader.overlay).css('position', 'fixed');
				}
				else {
					$(loader.overlay).css('position', 'absolute');
				}
				$(loader.overlay).css('z-index', 1000);
				/*
				$(loader.overlay).css('background-color', loader.background_color);
				$(loader.overlay).css('filter', 'alpha(opacity='+(loader.opacity*100)+')');
				$(loader.overlay).css('-moz-opacity', loader.opacity);
				$(loader.overlay).css('opacity', loader.opacity);
				*/
				$(loader.overlay).css('top', 0);
				$(loader.overlay).css('left', 0);
				$(loader.overlay).height(height);
				$(loader.overlay).width(width);

				$(loader.overlay).find('div').css('position', 'relative');
				$(loader.overlay).find('div').width(110);
				$(loader.overlay).find('div').height(110);
				$(loader.overlay).find('div').css('background-color', loader.background_color);
				$(loader.overlay).find('div').css('filter', 'alpha(opacity='+(loader.opacity*100)+')');
				$(loader.overlay).find('div').css('-moz-opacity', loader.opacity);
				$(loader.overlay).find('div').css('opacity', loader.opacity);
				$(loader.overlay).find('div').css('border-radius', 10);
				$(loader.overlay).find('div').css('position', 'fixed');
				$(loader.overlay).find('div').css('left', '50%');
				$(loader.overlay).find('div').css('top', '50%');
				$(loader.overlay).find('div').css('margin-top', '-55px');
				$(loader.overlay).find('div').css('margin-left', '-55px');

				$(loader.overlay).find('img').attr('src', '/assets/imgs/712.GIF');
				$(loader.overlay).find('img').css('position', 'relative');
				$(loader.overlay).find('img').css('left', '50%');
				$(loader.overlay).find('img').css('top', '50%');
				$(loader.overlay).find('img').css('margin-top', (loader.gif_height/2*-1));
				$(loader.overlay).find('img').css('margin-left', (loader.gif_width/2*-1));

				$(loader.overlay).find('img').width(loader.gif_width);
				$(loader.overlay).find('img').height(loader.gif_height);

				$(parent).append(loader.overlay);
                if (time) {
                    setTimeout(function(){
                        loader.overlay.remove();
                    }, time);
                }

				return loader.overlay;
			},
			hide: function(target){
				//$(loader.overlay).remove();
				if (target != null) {
					target.remove();
				}
			},
	}
}
