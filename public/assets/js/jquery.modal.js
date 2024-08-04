/*!
* modal.js 1.0
* 
* 使い方
* $().modal("コンテンツの中身").show();
* $().modal({
*	'contents' : "コンテンツの中身",
*	'ok_button' : false,
* }).show();
*/


(function($){

	$('body').css('position', 'relative');
	
	$.fn.modal = function(options) {

		if (typeof options == "string") {
			var contents = options;
			options = {'contents' : contents};
		} 
		
		$this = $(this);
		
		var settings = $.extend({
			'contents' : '',
			'background_color' : '#fff',
			'overlay_background_color' : '#000',
			'button_frame_background_color' : '#fbfbfb',
			'opacity' : 0.5,
			'modal_width' : 350,
			'modal_height' : 200,
			'btn_class' : 'btn-primary',
			'padding' : 20,
			'font_size' : 12,
			'border' : false,							// ボーダーありの場合は true
			'border_color' : '#ccc',
			'ok_button' : true,							// OKボタンが不要の場合はfalse
			'cancel_button' : false,					// キャンセルボタンが不要の場合はfalse
			'blur': false,								// 背景のぼかしがいる場合はtrue
			'callback' : function(e){},
			'loaded_callback' : function(){}
		}, options);
		var overlay = null;
		modal = null;
		var height = $('body').outerHeight();
		var width = $('body').outerWidth();
		var status = false;

		var html_overlay = " \
		<div class='gamodal_overlay'> \
			<div style='position:relative;'> \
			</div> \
		</div> \
";
		
		var html_modal = " \
			<div class='gamodal'> \
				<div class='gamodal_outer_frame'> \
					<div class='gamodal_contents_frame'> \
						"+settings.contents+" \
					</div> \
					<div class='gamodal_button_frame'> \
						<button class='btn btn-primary gamodal_ok "+settings.btn_class+"'>OK</button> \
						<button class='btn gamodal_cancel'>Cancel</button> \
					</div> \
				</div> \
			</div> \
";
		
		
		// overlay
		overlay = $(html_overlay).clone();
		overlay.css('position', 'fixed');

		if (settings.blur) {
			$('body').children("div").css('filter', 'blur(10px)');
			$('body').children("div").css('-webkit-filter', 'blur(10px)');
		}

		overlay.css('z-index', 88888);
		overlay.css('background-color', settings.overlay_background_color);
		overlay.css('filter', 'alpha(opacity='+(settings.opacity*100)+')');
		overlay.css('-moz-opacity', settings.opacity);
		overlay.css('opacity', settings.opacity);
		overlay.css('top', 0);
		overlay.css('left', 0);
		overlay.height(height);
		overlay.width(width);
		
		// modal
		modal = $(html_modal).clone();
		modal.css('position', 'fixed');
		modal.css('padding', settings.padding);
		if (settings.border) {
			modal.css('border', '1px solid '+settings.border_color);
		}
		modal.css('width', settings.modal_width);
		modal.css('height', settings.modal_height);
		modal.css('font-size', settings.font_size);
		modal.css('top', -99999);
		modal.css('z-index', 99999);
		modal.css('background-color', settings.background_color);
		modal.css('left', '50%');
		modal.css('margin-left', (settings.modal_width/2*-1));

		
		// ボタン表示制御
		if (!settings.ok_button) {
			$(modal).find('.gamodal_ok').css('cssText', 'display:none !important;');
		}
		else {
			$(modal).find('.gamodal_ok').css('cssText', 'display:inline !important;');
		}
		if (!settings.cancel_button) {
			$(modal).find('.gamodal_cancel').css('cssText', 'display:none !important;');
		}
		else {
			$(modal).find('.gamodal_cancel').css('cssText', 'display:inline !important;');
		}
		if (!settings.cancel_button && !settings.ok_button) {
			$(modal).find('.gamodal_button_frame').css('cssText', 'display:none !important;');
		}
		else {
			$(modal).find('.gamodal_button_frame').css('cssText', 'display:block !important;');
		}
		
		$(modal).find('.gamodal_button_frame').css('position', 'absolute');
		$(modal).find('.gamodal_button_frame').css('left', 0);
		$(modal).find('.gamodal_button_frame').css('bottom', 0);
		if (settings.border) {
			$(modal).find('.gamodal_button_frame').css('width', settings.modal_width-2);
		}
		else {
			$(modal).find('.gamodal_button_frame').css('width', settings.modal_width);
		}
		$(modal).find('.gamodal_button_frame').css('text-align', 'right');
		$(modal).find('.gamodal_button_frame').css('padding', settings.padding);
		$(modal).find('.gamodal_button_frame').css('background-color', settings.button_frame_background_color);
		$(modal).find('.gamodal_ok').focus();
		
		/*
		 * キャンセルボタン押下時
		 */
		$(modal).find('.gamodal_cancel').click(function(){
			$this.hide(this);
			status = false;
			
		});
		/*
		 * OKボタン押下時
		 */
		$(modal).find('.gamodal_ok').click(function(){
			$this.hide(this);
			status = true;
		});
		
		$this.overlay_show = function(){
			if ($(".gamodal_overlay").size() == 0) {
				$('body').append(overlay);
			}
		};
		$this.overlay_hide = function(){
			//console.debug($(".gamodal").size());
			if ($(".gamodal").size() == 0) {
				$('.gamodal_overlay').remove();
			}
		};
		$this.show = function(){
			
			$this.overlay_show();
			$('body').append(modal);
			modal.css('top', $(modal).height()*-1);
			$(modal).animate({'top':'100px'}, 'normal');
			settings.loaded_callback();
			
		};
		$this.hide = function(o){
			$(o).parents('.gamodal').animate(
				{
					'top':($(modal).height()+50)*-1
				},
				{
					'duration' : 500,
					'complete' : function(){
						$(o).parents('.gamodal').remove();
						$this.overlay_hide();
						if (settings.blur) {
							$('body').children("div").css('filter', 'blur(0px)');
							$('body').children("div").css('-webkit-filter', 'blur(0px)');
						}
						settings.callback(status);
					}
				});
			
			
		};

		return $this;
	};
})(jQuery);
