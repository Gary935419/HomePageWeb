var _loader_overlay;
// デフォルトDateFrom(日数)
var _defaultDate = 180;

function mydialog(message, left_text, right_text, callback) {

	loader.hide(_loader_overlay);
	var html = " \
<div id='message_box_frame'> \
	<div id='message_box'> \
		<div id='message_title'> \
		</div> \
		<div id='message_button_frame' class='clearw'> \
			<div id='btn_message_left' mode='left'> \
				"+left_text+" \
			</div> \
			<div id='btn_message_right' mode='right'> \
				"+right_text+" \
			</div> \
		</div> \
	</div> \
</div> \
	";

	var obj = $(html);
	obj.find('#message_title').html(message);
	obj.find('#btn_message_left, #btn_message_right').click(function(){
		var mode = $(this).attr('mode');
		if (typeof callback != 'undefined') {
			callback(mode);
		}
	});
	$('body').append(obj);
	return false;
}

function myalert(message, callback) {
	loader.hide(_loader_overlay);
	var html = " \
<div id='message_box_frame'> \
	<div id='message_box'> \
		<div id='message_title'> \
		</div> \
		<div id='message_button_frame'> \
			<div id='btn_message_ok'> \
				OK \
			</div> \
		</div> \
	</div> \
</div> \
	";

	var obj = $(html);
	obj.find('#message_title').text(message);
	obj.find('#btn_message_ok').click(function(){
		if (typeof callback != 'undefined') {
			callback();
		}
		$(this).parents('#message_box_frame').remove();
	});
	$('body').append(obj);
	return false;
}

$(function(){


	// 閉じるボタン押下

	$('.menu_button').click(function() {
		$('.overlay_green').show();
		$('.menu_left_hidden_block').animate({'left':0},500);
	});

	$('.overlay_green').click(function() {
		$('.menu_left_hidden_block').animate({'left':-320},500);
		$(this).hide();
	});


	// メニューのLIをリンク化
	$('#menu_left li').click(function(){
		var link = $(this).find('a').attr('href');
		location.href = link;
	});



	$('.back_btn, .close_button, .btn').click(function(){
		if (!$(this).hasClass('noloader')) {
			_loader_overlay = loader.show('body');
		}

		var obj = $(this);
		obj.addClass('btn_click');
		setTimeout(function(){
			obj.removeClass('btn_click');
		}, 500);
	});

	$('.menu_button').click(function(){
		var obj = $(this);
		obj.addClass('btn_click');
		setTimeout(function(){
			obj.removeClass('btn_click');
		}, 500);
	});


	$('.button1, .button2, .button_, #btn_all_buy, .bnt_cancel, .bnt_buy, #btn_sell, #btn_buy_all').click(function(){
		if (!$(this).hasClass('noloader')) {
			_loader_overlay = loader.show('body');
		}
		var obj = $(this);
		obj.addClass('btn_green_click');
		setTimeout(function(){
			obj.removeClass('btn_green_click');
		}, 500);
	});


	$('a').click(function(){
		if ($(this).hasClass('noloader')) {
			return true;
		}
		else {
			_loader_overlay = loader.show('body');
		}
	});

    //inputタグとtextareaタグです,空白入力問題に対してグローバルtrim処理を行います。
    $("input").blur (function (event){
        if(event.target.value.replace(/ /g,"")==""){
            $("#"+event.target.id).val(trim(event.target.value));
        }
    })
    $("textarea").blur (function (event){
        if(event.target.value.replace(/ /g,"")==""){
            $("#"+event.target.id).val(trim(event.target.value));
        }
    })

});

// パスコード認証
function passcode_auth(passcode) {
	$.ajaxSetup({ async: false });
	var result = false;
	$.getJSON("/otb/passcode_auth?passcode="+passcode, {}, function(data) {
		result = data.result;
	});
	$.ajaxSetup({ async: true }); // 非同期に戻す
	return result;
}
// パスコード設定取得
function get_passcode_onoff() {
	$.ajaxSetup({ async: false });
	var result = false;
	$.getJSON("/otb/get_passcode_onoff", {}, function(data) {
		result = data.result;
	});
	$.ajaxSetup({ async: true }); // 非同期に戻す

	return result;
}
// パスコードオンオフ設定
function set_passcode_onoff(val) {
	$.ajaxSetup({ async: false });
	var result = false;
	$.getJSON("/otb/set_passcode_onoff?set="+val, {}, function(data) {
		result = data.result;
	});
	$.ajaxSetup({ async: true }); // 非同期に戻す
	return result;
}


function short_yen(val)
{
	amount = intval(val);

	abs = Math.abs(amount);

	if (abs < 10000) {
		return intval(amount);
	}
	else if (abs < 100000000) {
		amount = bcdiv(amount, 1000);
		amount = intval(amount);
		amount = bcdiv(amount, 10, 0);
		amount = amount+'万';
	}
	else {
		amount = bcdiv(amount, 10000000);
		amount = intval(amount);
		amount = bcdiv(amount, 10, 0);
		amount = amount+'億';
	}

	return amount;
}

function profit_yen(val)
{
	amount = intval(val);

	abs = Math.abs(amount);

	if (abs < 10000) {
		return intval(amount);
	}
	else if (abs < 100000000) {
		amount = bcdiv(amount, 1000);
		amount = intval(amount);
		amount = bcdiv(amount, 10, 1);
		amount = amount+'万';
	}
	else {
		amount = bcdiv(amount, 10000000);
		amount = intval(amount);
		amount = bcdiv(amount, 10, 1);
		amount = amount+'億';
	}

	return amount;
}

function yen(val) {

	amount = val;
	is_minus = false;
	// マイナスかプラスかを保持
	if (amount < 0) {
		is_minus = true;
		amount *= -1;
	}

	// 切り捨てる
	amount = floor(amount) + "";
	amount_rev = 'E';
	// 文字数分おしりからまわす
	count = 1;
	for(i = strlen(amount)-1; i >=0; i--) {
		if (count == 5) {
			amount_rev = amount_rev + 'M';
		}
		if (count == 9) {
			amount_rev = amount_rev + 'O';
		}
		amount_rev = amount_rev + amount[i];
		count++;
	}
	amount = '';
	for(i = strlen(amount_rev)-1; i >=0; i--) {
		amount = amount + amount_rev[i];
	}
	amount = str_replace('E', '円', amount);
	amount = str_replace('M', '万', amount);
	amount = str_replace('O', '億', amount);

	if (is_minus) {
		amount = '-' + amount;
	}
	return amount;
}


/**
 * convert zenkaku to hankaku
 */
function convertToHankaku(id) {
	$(id).change(function(){
		var txt  = $(this).val();
		var han = mb_convert_kana(txt, 'rnmskh');
		$(this).val(han);
	});
}

/**
 * convert hiragana to katakana
 */
function convertToKana(id) {
	$(id).change(function(){
		var txt  = $(this).val();
		var han = mb_convert_kana(txt, 'C');
		$(this).val(han);
	});
}

/**
 * convert hankaku to zenkaku
 */
function convertToZenkaku(id) {
	$(id).change(function(){
		var txt  = $(this).val();
		var han = mb_convert_kana(txt, 'K');
		$(this).val(han);
	});
}
/**
 * date format
 */
function dateFormat(id, type) {
	$(id).change(function(){
		var txt  = $(this).val();
		if (type == 'Y') {
			txt = sprintf('%04d', intval(txt));
		}
		else {
			txt = sprintf('%02d', intval(txt));
		}
		$(this).val(txt);
	});
}

/**
 * validate_intval
 */
function validate_intval(val) {
	if (typeof val == 'undefined') {
		return true;
	}
	if(!val.match(/[^0-9]+/)){
		return true;
	}
	else {
		return false;
	}
}

function ValidateKana(str) {
	if (typeof str == 'undefined') {
		return true;
	}
	return str.match(/^[ァ-ヶー]*$/);
}

/*
 * validate email
 */
function ValidateEmail(mail) {
	if (typeof mail == 'undefined') {
		return true;
	}
	var re = /^(([^<>()[\]\\.,;:\s@\"]+([^<>()[\]\\,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(mail);
}
/*
 * validate url
 */
function ValidateURL(url) {
	if (typeof url == 'undefined') {
		return true;
	}
	var pattern = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
	if (url.match(pattern)){
		return true;
	}
	return false;
}
/**
 * 全角2文字、半角1文字で計算する
 * @returns
 */
function get_str_length(text) {
	var byte = 0;
	for (i = 0; i < text.length; i++) {
		n = escape(text.charAt(i));
		if (n.length < 4) {
			byte++;
		}
		else {
			byte+=2;
		}
	}
	return byte;
}

/**
 * PHPの mb_convert_kana() っぽいもの
 * mMオプションで記号 /[!#-&(-/:-@[\]^_{|}]/ を変換
 * PHPにおける a または A オプションは rnm または RNM オプションとほぼ等価
 * (バッククオーテーションを変換しない点がPHPと異なる)
 * PHPとは違い、hc または kC の組み合わせのオプションにおいて、c または C オプションを無視しない
 * PHPと同様に動かしたいときは上記の組み合わせのオプションを指定しない or このスクリプトをテキトーに弄る
 *
 * @param string str
 * @param string option デフォルトは KV
 *    r : 「全角」英字を「半角」に変換
 *    R : 「半角」英字を「全角」に変換
 *    n : 「全角」数字を「半角」に変換
 *    N : 「半角」数字を「全角」に変換
 *    m : 「全角」記号を「半角」に変換
 *    M : 「半角」記号を「全角」に変換
 *    s : 「全角」スペースを「半角」
 *    S : 「半角」スペースを「全角」
 *    k : 「全角カタカナ」を「半角カタカナ」に変換
 *    K : 「半角カタカナ」を「全角カタカナ」に変換
 *    h : 「全角ひらがな」を「半角カタカナ」に変換
 *    H : 「半角カタカナ」を「全角ひらがな」に変換
 *    c : 「全角カタカナ」を「全角ひらがな」に変換
 *    C : 「全角ひらがな」を「全角カタカナ」に変換
 *    V : 濁点付きの文字を一文字に変換。"K", "H" と共に使用

 *    o : [2011/8/25追加] ”“’‘｀￥ を ""''`\に変換
 *    O : [2011/8/25追加] "'`\ を ”’｀￥ に変換
 */
var mb_convert_kana = function( str, option )
{
	if( option === '' || option === undefined || option === null )
	{
		// デフォルトのオプション
		option = 'KV';
	}

	// 1文字用の正規表現
	var re = '[';

	// 2文字(濁点との組み合わせ)用の正規表現
	var re_v = '(?:';

	// 変換用の配列
	var list = {};

	// list に配列をマージする
	var m = function( o )
	{
		for( var k in o )
		{
			list[k] = o[k];
		}
	}

	if( option.indexOf('r') !== -1 && str.search(/[ａ-ｚＡ-Ｚ]/) !== -1 )
	{
		m( {'ａ':'a','ｂ':'b','ｃ':'c','ｄ':'d','ｅ':'e','ｆ':'f','ｇ':'g','ｈ':'h','ｉ':'i','ｊ':'j','ｋ':'k','ｌ':'l','ｍ':'m','ｎ':'n','ｏ':'o','ｐ':'p','ｑ':'q','ｒ':'r','ｓ':'s','ｔ':'t','ｕ':'u','ｖ':'v','ｗ':'w','ｘ':'x','ｙ':'y','ｚ':'z','Ａ':'A','Ｂ':'B','Ｃ':'C','Ｄ':'D','Ｅ':'E','Ｆ':'F','Ｇ':'G','Ｈ':'H','Ｉ':'I','Ｊ':'J','Ｋ':'K','Ｌ':'L','Ｍ':'M','Ｎ':'N','Ｏ':'O','Ｐ':'P','Ｑ':'Q','Ｒ':'R','Ｓ':'S','Ｔ':'T','Ｕ':'U','Ｖ':'V','Ｗ':'W','Ｘ':'X','Ｙ':'Y','Ｚ':'Z'} );
		re += 'ａ-ｚＡ-Ｚ';
	}

	if( option.indexOf('R') !== -1 && str.search(/[a-zA-Z]/) !== -1 )
	{
		m( {'a':'ａ','b':'ｂ','c':'ｃ','d':'ｄ','e':'ｅ','f':'ｆ','g':'ｇ','h':'ｈ','i':'ｉ','j':'ｊ','k':'ｋ','l':'ｌ','m':'ｍ','n':'ｎ','o':'ｏ','p':'ｐ','q':'ｑ','r':'ｒ','s':'ｓ','t':'ｔ','u':'ｕ','v':'ｖ','w':'ｗ','x':'ｘ','y':'ｙ','z':'ｚ','A':'Ａ','B':'Ｂ','C':'Ｃ','D':'Ｄ','E':'Ｅ','F':'Ｆ','G':'Ｇ','H':'Ｈ','I':'Ｉ','J':'Ｊ','K':'Ｋ','L':'Ｌ','M':'Ｍ','N':'Ｎ','O':'Ｏ','P':'Ｐ','Q':'Ｑ','R':'Ｒ','S':'Ｓ','T':'Ｔ','U':'Ｕ','V':'Ｖ','W':'Ｗ','X':'Ｘ','Y':'Ｙ','Z':'Ｚ'} );
		re += 'a-zA-Z';
	}

	if( option.indexOf('n') !== -1 && str.search(/[０-９]/) !== -1 )
	{
		m( {'０':'0','１':'1','２':'2','３':'3','４':'4','５':'5','６':'6','７':'7','８':'8','９':'9'} );
		re += '０-９';
	}

	if( option.indexOf('N') !== -1 && str.search(/\d/) !== -1 )
	{
		m( {'0':'０','1':'１','2':'２','3':'３','4':'４','5':'５','6':'６','7':'７','8':'８','9':'９'} );
		re += '\\d';
	}

	if( option.indexOf('s') !== -1 && str.indexOf('　') !== -1 )
	{
		m( {'　':' '} );
		re += '　';
	}

	if( option.indexOf('S') !== -1 && str.indexOf(' ') !== -1 )
	{
		m( {' ':'　'} );
		re += ' ';
	}

	if( option.indexOf('m') !== -1 && str.search(/[！＃＄％＆（）＊＋，－．／：；＜＝＞？＠［］＾＿｛｜｝]/) !== -1 )
	{
		m( {'！':'!','＃':'#','＄':'$','％':'%','＆':'&','（':'(','）':')','＊':'*','＋':'+','，':',','－':'-','．':'.','／':'/','：':':','；':';','＜':'<','＝':'=','＞':'>','？':'?','＠':'@','［':'[','］':']','＾':'^','＿':'_','｛':'{','｜':'|','｝':'}'} );
		re += '！＃＄％＆（）＊＋，－．／：；＜＝＞？＠［］＾＿｛｜｝';
	}

	if( option.indexOf('M') !== -1 && str.search(/[!#-&(-/:-@[\]^_{|}]/) !== -1 )
	{
		m( {'!':'！','#':'＃','$':'＄','%':'％','&':'＆','(':'（',')':'）','*':'＊','+':'＋',',':'，','-':'－','.':'．','/':'／',':':'：',';':'；','<':'＜','=':'＝','>':'＞','?':'？','@':'＠','[':'［',']':'］','^':'＾','_':'＿','{':'｛','|':'｜','}':'｝'} );
		re += '!#-&(-/:-@[\\]^_{|}';
	}

	if( option.indexOf('o') !== -1 && str.search(/[”“’‘｀￥]/) !== -1 )
	{
		m( {'”':'"','“':'"','’':"'",'‘':"'",'｀':'`','￥':'\\'} );
		re += '”“’‘｀￥';
	}

	if( option.indexOf('O') !== -1 && str.search(/["'`\\]/) !== -1 )
	{
		m( {'"':'”',"'":'’','`':'｀','\\':'￥'} );
		re += '"\\\'`\\\\';
	}

	if( option.indexOf('k') !== -1 && str.search(/[、。「」゛゜ァ-ヴ・ー]/) !== -1 )
	{
		m( {
			'ガ':'ｶﾞ','ギ':'ｷﾞ','グ':'ｸﾞ','ゲ':'ｹﾞ','ゴ':'ｺﾞ','ザ':'ｻﾞ','ジ':'ｼﾞ','ズ':'ｽﾞ','ゼ':'ｾﾞ','ゾ':'ｿﾞ','ダ':'ﾀﾞ','ヂ':'ﾁﾞ','ヅ':'ﾂﾞ','デ':'ﾃﾞ','ド':'ﾄﾞ','バ':'ﾊﾞ','パ':'ﾊﾟ','ビ':'ﾋﾞ','ピ':'ﾋﾟ','ブ':'ﾌﾞ','プ':'ﾌﾟ','ベ':'ﾍﾞ','ペ':'ﾍﾟ','ボ':'ﾎﾞ','ポ':'ﾎﾟ','ヴ':'ｳﾞ',
			'。':'｡','「':'｢','」':'｣','、':'､','・':'･','ヲ':'ｦ','ァ':'ｧ','ィ':'ｨ','ゥ':'ｩ','ェ':'ｪ','ォ':'ｫ','ャ':'ｬ','ュ':'ｭ','ョ':'ｮ','ッ':'ｯ','ー':'ｰ','ア':'ｱ','イ':'ｲ','ウ':'ｳ','エ':'ｴ','オ':'ｵ','カ':'ｶ','キ':'ｷ','ク':'ｸ','ケ':'ｹ','コ':'ｺ','サ':'ｻ','シ':'ｼ','ス':'ｽ','セ':'ｾ','ソ':'ｿ','タ':'ﾀ','チ':'ﾁ','ツ':'ﾂ','テ':'ﾃ','ト':'ﾄ','ナ':'ﾅ','ニ':'ﾆ','ヌ':'ﾇ','ネ':'ﾈ','ノ':'ﾉ','ハ':'ﾊ','ヒ':'ﾋ','フ':'ﾌ','ヘ':'ﾍ','ホ':'ﾎ','マ':'ﾏ','ミ':'ﾐ','ム':'ﾑ','メ':'ﾒ','モ':'ﾓ','ヤ':'ﾔ','ユ':'ﾕ','ヨ':'ﾖ','ラ':'ﾗ','リ':'ﾘ','ル':'ﾙ','レ':'ﾚ','ロ':'ﾛ','ワ':'ﾜ','ン':'ﾝ','゜':'ﾟ','゛':'ﾞ','ヮ':'ﾜ','ヰ':'ｲ','ヱ':'ｴ'} );
		re += '、。「」゛゜ァ-ヴ・ー';
	}

	if( option.indexOf('V') !== -1 && str.search(/(?:[ｳｶ-ﾄﾊ-ﾎ]ﾞ|[ﾊ-ﾎ]ﾟ)/) !== -1 && option.indexOf('K') !== -1 )
	{
		m( {'ｶﾞ':'ガ','ｷﾞ':'ギ','ｸﾞ':'グ','ｹﾞ':'ゲ','ｺﾞ':'ゴ','ｻﾞ':'ザ','ｼﾞ':'ジ','ｽﾞ':'ズ','ｾﾞ':'ゼ','ｿﾞ':'ゾ','ﾀﾞ':'ダ','ﾁﾞ':'ヂ','ﾂﾞ':'ヅ','ﾃﾞ':'デ','ﾄﾞ':'ド','ﾊﾞ':'バ','ﾊﾟ':'パ','ﾋﾞ':'ビ','ﾋﾟ':'ピ','ﾌﾞ':'ブ','ﾌﾟ':'プ','ﾍﾞ':'ベ','ﾍﾟ':'ペ','ﾎﾞ':'ボ','ﾎﾟ':'ポ','ｳﾞ':'ヴ'} );
		re_v += '[ｳｶ-ﾄﾊ-ﾎ]ﾞ|[ﾊ-ﾎ]ﾟ|';
	}

	if( option.indexOf('K') !== -1 && str.search(/[｡-ﾟ]/) !== -1 )
	{
		m( {'｡':'。','｢':'「','｣':'」','､':'、','･':'・','ｦ':'ヲ','ｧ':'ァ','ｨ':'ィ','ｩ':'ゥ','ｪ':'ェ','ｫ':'ォ','ｬ':'ャ','ｭ':'ュ','ｮ':'ョ','ｯ':'ッ','ｰ':'ー','ｱ':'ア','ｲ':'イ','ｳ':'ウ','ｴ':'エ','ｵ':'オ','ｶ':'カ','ｷ':'キ','ｸ':'ク','ｹ':'ケ','ｺ':'コ','ｻ':'サ','ｼ':'シ','ｽ':'ス','ｾ':'セ','ｿ':'ソ','ﾀ':'タ','ﾁ':'チ','ﾂ':'ツ','ﾃ':'テ','ﾄ':'ト','ﾅ':'ナ','ﾆ':'ニ','ﾇ':'ヌ','ﾈ':'ネ','ﾉ':'ノ','ﾊ':'ハ','ﾋ':'ヒ','ﾌ':'フ','ﾍ':'ヘ','ﾎ':'ホ','ﾏ':'マ','ﾐ':'ミ','ﾑ':'ム','ﾒ':'メ','ﾓ':'モ','ﾔ':'ヤ','ﾕ':'ユ','ﾖ':'ヨ','ﾗ':'ラ','ﾘ':'リ','ﾙ':'ル','ﾚ':'レ','ﾛ':'ロ','ﾜ':'ワ','ﾝ':'ン','ﾟ':'゜','ﾞ':'゛'} );
		re += '｡-ﾟ';
	}

	if( option.indexOf('h') !== -1 && str.search(/[、。「」゛゜ぁ-ん・ー]/) !== -1 )
	{
		m( {
			'が':'ｶﾞ','ぎ':'ｷﾞ','ぐ':'ｸﾞ','げ':'ｹﾞ','ご':'ｺﾞ','ざ':'ｻﾞ','じ':'ｼﾞ','ず':'ｽﾞ','ぜ':'ｾﾞ','ぞ':'ｿﾞ','だ':'ﾀﾞ','ぢ':'ﾁﾞ','づ':'ﾂﾞ','で':'ﾃﾞ','ど':'ﾄﾞ','ば':'ﾊﾞ','ぱ':'ﾊﾟ','び':'ﾋﾞ','ぴ':'ﾋﾟ','ぶ':'ﾌﾞ','ぷ':'ﾌﾟ','べ':'ﾍﾞ','ぺ':'ﾍﾟ','ぼ':'ﾎﾞ','ぽ':'ﾎﾟ',
			'。':'｡','「':'｢','」':'｣','、':'､','・':'･','を':'ｦ','ぁ':'ｧ','ぃ':'ｨ','ぅ':'ｩ','ぇ':'ｪ','ぉ':'ｫ','ゃ':'ｬ','ゅ':'ｭ','ょ':'ｮ','っ':'ｯ','ー':'ｰ','あ':'ｱ','い':'ｲ','う':'ｳ','え':'ｴ','お':'ｵ','か':'ｶ','き':'ｷ','く':'ｸ','け':'ｹ','こ':'ｺ','さ':'ｻ','し':'ｼ','す':'ｽ','せ':'ｾ','そ':'ｿ','た':'ﾀ','ち':'ﾁ','つ':'ﾂ','て':'ﾃ','と':'ﾄ','な':'ﾅ','に':'ﾆ','ぬ':'ﾇ','ね':'ﾈ','の':'ﾉ','は':'ﾊ','ひ':'ﾋ','ふ':'ﾌ','へ':'ﾍ','ほ':'ﾎ','ま':'ﾏ','み':'ﾐ','む':'ﾑ','め':'ﾒ','も':'ﾓ','や':'ﾔ','ゆ':'ﾕ','よ':'ﾖ','ら':'ﾗ','り':'ﾘ','る':'ﾙ','れ':'ﾚ','ろ':'ﾛ','わ':'ﾜ','ん':'ﾝ','゜':'ﾟ','゛':'ﾞ','ゎ':'ﾜ','ゐ':'ｲ','ゑ':'ｴ'} );
		re += '、。「」゛゜ぁ-ん・ー';
	}

	if( option.indexOf('H') !== -1 && option.indexOf('K') === -1 && option.indexOf('V') !== -1 && str.search(/(?:[ｶ-ﾄﾊ-ﾎ]ﾞ|[ﾊ-ﾎ]ﾟ)/) !== -1 )
	{
		m( {'ｶﾞ':'が','ｷﾞ':'ぎ','ｸﾞ':'ぐ','ｹﾞ':'げ','ｺﾞ':'ご','ｻﾞ':'ざ','ｼﾞ':'じ','ｽﾞ':'ず','ｾﾞ':'ぜ','ｿﾞ':'ぞ','ﾀﾞ':'だ','ﾁﾞ':'ぢ','ﾂﾞ':'づ','ﾃﾞ':'で','ﾄﾞ':'ど','ﾊﾞ':'ば','ﾊﾟ':'ぱ','ﾋﾞ':'び','ﾋﾟ':'ぴ','ﾌﾞ':'ぶ','ﾌﾟ':'ぷ','ﾍﾞ':'べ','ﾍﾟ':'ぺ','ﾎﾞ':'ぼ','ﾎﾟ':'ぽ'} );
		re_v += '[ｶ-ﾄﾊ-ﾎ]ﾞ|[ﾊ-ﾎ]ﾟ|';
	}

	if( option.indexOf('H') !== -1 && option.indexOf('K') === -1 && str.search(/[｡-ﾟ]/) !== -1 )
	{
		m( {'｡':'。','｢':'「','｣':'」','､':'、','･':'・','ｦ':'を','ｧ':'ぁ','ｨ':'ぃ','ｩ':'ぅ','ｪ':'ぇ','ｫ':'ぉ','ｬ':'ゃ','ｭ':'ゅ','ｮ':'ょ','ｯ':'っ','ｰ':'ー','ｱ':'あ','ｲ':'い','ｳ':'う','ｴ':'え','ｵ':'お','ｶ':'か','ｷ':'き','ｸ':'く','ｹ':'け','ｺ':'こ','ｻ':'さ','ｼ':'し','ｽ':'す','ｾ':'せ','ｿ':'そ','ﾀ':'た','ﾁ':'ち','ﾂ':'つ','ﾃ':'て','ﾄ':'と','ﾅ':'な','ﾆ':'に','ﾇ':'ぬ','ﾈ':'ね','ﾉ':'の','ﾊ':'は','ﾋ':'ひ','ﾌ':'ふ','ﾍ':'へ','ﾎ':'ほ','ﾏ':'ま','ﾐ':'み','ﾑ':'む','ﾒ':'め','ﾓ':'も','ﾔ':'や','ﾕ':'ゆ','ﾖ':'よ','ﾗ':'ら','ﾘ':'り','ﾙ':'る','ﾚ':'れ','ﾛ':'ろ','ﾜ':'わ','ﾝ':'ん','ﾟ':'゜','ﾞ':'゛'} );
		re += '｡-ﾟ';
	}

	if( option.indexOf('c') !== -1 && option.indexOf('k') === -1 && str.search(/[ァ-ン]/) !== -1 )
	{

		m( {
			'ガ':'が','ギ':'ぎ','グ':'ぐ','ゲ':'げ','ゴ':'ご','ザ':'ざ','ジ':'じ','ズ':'ず','ゼ':'ぜ','ゾ':'ぞ','ダ':'だ','ヂ':'ぢ','ヅ':'づ','デ':'で','ド':'ど','バ':'ば','パ':'ぱ','ビ':'び','ピ':'ぴ','ブ':'ぶ','プ':'ぷ','ベ':'べ','ペ':'ぺ','ボ':'ぼ','ポ':'ぽ',
			'ヲ':'を','ァ':'ぁ','ィ':'ぃ','ゥ':'ぅ','ェ':'ぇ','ォ':'ぉ','ャ':'ゃ','ュ':'ゅ','ョ':'ょ','ッ':'っ','ア':'あ','イ':'い','ウ':'う','エ':'え','オ':'お','カ':'か','キ':'き','ク':'く','ケ':'け','コ':'こ','サ':'さ','シ':'し','ス':'す','セ':'せ','ソ':'そ','タ':'た','チ':'ち','ツ':'つ','テ':'て','ト':'と','ナ':'な','ニ':'に','ヌ':'ぬ','ネ':'ね','ノ':'の','ハ':'は','ヒ':'ひ','フ':'ふ','ヘ':'へ','ホ':'ほ','マ':'ま','ミ':'み','ム':'む','メ':'め','モ':'も','ヤ':'や','ユ':'ゆ','ヨ':'よ','ラ':'ら','リ':'り','ル':'る','レ':'れ','ロ':'ろ','ワ':'わ','ン':'ん','ヮ':'ゎ','ヰ':'ゐ','ヱ':'ゑ'} );
		re += 'ァ-ン';
	}

	if( option.indexOf('C') !== -1 && option.indexOf('h') === -1 && str.search(/[ぁ-ん]/) !== -1 )
	{

		m( {
			'が':'ガ','ぎ':'ギ','ぐ':'グ','げ':'ゲ','ご':'ゴ','ざ':'ザ','じ':'ジ','ず':'ズ','ぜ':'ゼ','ぞ':'ゾ','だ':'ダ','ぢ':'ヂ','づ':'ヅ','で':'デ','ど':'ド','ば':'バ','ぱ':'パ','び':'ビ','ぴ':'ピ','ぶ':'ブ','ぷ':'プ','べ':'ベ','ぺ':'ペ','ぼ':'ボ','ぽ':'ポ','を':'ヲ',
			'ぁ':'ァ','ぃ':'ィ','ぅ':'ゥ','ぇ':'ェ','ぉ':'ォ','ゃ':'ャ','ゅ':'ュ','ょ':'ョ','っ':'ッ','あ':'ア','い':'イ','う':'ウ','え':'エ','お':'オ','か':'カ','き':'キ','く':'ク','け':'ケ','こ':'コ','さ':'サ','し':'シ','す':'ス','せ':'セ','そ':'ソ','た':'タ','ち':'チ','つ':'ツ','て':'テ','と':'ト','な':'ナ','に':'ニ','ぬ':'ヌ','ね':'ネ','の':'ノ','は':'ハ','ひ':'ヒ','ふ':'フ','へ':'ヘ','ほ':'ホ','ま':'マ','み':'ミ','む':'ム','め':'メ','も':'モ','や':'ヤ','ゆ':'ユ','よ':'ヨ','ら':'ラ','り':'リ','る':'ル','れ':'レ','ろ':'ロ','わ':'ワ','ん':'ン','ゎ':'ヮ','ゐ':'ヰ','ゑ':'ヱ'} );
		re += 'ぁ-ん';
	}

	if( re === '[' )
	{
		return str;
	}

	re += ']';
	if( re_v === '(?:' )
	{
		re_all = new RegExp( re, 'g' );
	}
	else
	{
		re_v += '))';
		re_v = re_v.replace('|)', '');
		var re_all = '(?:';
		re_all += re_v;
		re_all += '|';
		re_all += re;
		re_all += ')';
		re_all = new RegExp( re_all, 'g' );
	}

	return str.replace( re_all, function(m){
		return list[m];
	} );
};


/**
 * validate_birth_d
 */
function validate_birth_d(val) {
	if (typeof val == 'undefined') {
		return true;
	}
	if(val.match(/^19[0-9]+|^20[0-9]+/) && 4 == get_str_length(val)){
		return true;
	}
	else {
		return false;
	}
}

/**
 * validateZenkaku
 */
function validateZenkaku(val) {
	if (typeof val == 'undefined') {
		return true;
	}
	for(i = 0; i < val.length; i++) {
		var len = escape(val.charAt(i)).length;
		if(len < 4) {
			return false;
		} else {
//			return true;
		}
	}
	return true;

}

/**
 * validateClientId
 */
function validateClientId(val) {
	if (typeof val == 'undefined') {
		return true;
	}

	if(val.match(/[^0-9a-zA-Z\_\-\.]+/) || get_str_length(val) < 5){
		return false;
	} else {
		if(val.match(/[a-zA-Z\_\-\.]+/)){
			return true;
		} else {
			return false;
		}
	}
}

/**
 * validateCaId
 */
function validateCaId(val) {
	if (typeof val == 'undefined') {
		return true;
	}

		if(val.match(/[^0-9a-zA-Z\_\-\.]+/)){
			return false;
		} else {
			return true;
		}

}

/**
 * validateSameval
 */
function validateSameval(text) {

	if(1 < text.length) {
		var val = text.charAt(0);
		for (i = 0; i < text.length; i++) {
			if(val != text.charAt(i)) {
				return false;
			} else {
				val = text.charAt(i);
			}
		}
	}
	return true;

}

/**
 * validateSurrogatePair
 */
function validateSurrogatePair(text) {

	if(1 < text.length) {
		if(0 < (text.match(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g)||[]).length) {
			return false;
		}
	}
	return true;

}

/**
 * SeirekiToWareki
 */
function seirekiToWareki(str) {
	var nengou = "";
	var year = "";
	a = str.split("/");
	a[0] = parseInt(a[0]);
	a[1] = parseInt(a[1]);
	a[2] = parseInt(a[2]);
	if(a[0] > 2019 || (a[0] == 2019 && a[1] > 4)){
		a[0] = a[0] - 2018;
		nengou = "令和";
	}else if(a[0] > 1989 || (a[0] == 1989 && a[1] == 1 && a[2] > 6)){
		a[0] = a[0] - 1988;
		nengou = "平成";
	}else if(a[0] > 1926 || (a[0] == 1926 && a[1] == 12 && a[2] > 24)){
		a[0] = a[0] - 1925;
		nengou = "昭和";
	}else if(a[0] > 1912 || (a[0] == 1912 && a[1] == 7 && a[2] > 30)){
		a[0] = a[0] - 1911;
		nengou = "大正";
	}else if(a[0] > 1868 || (a[0] == 1868 && a[1] == 1 && a[2] > 24)){
		a[0] = a[0] - 1867;
		nengou = "明治";
	}
	if(a[0] == 1){
		a[0] = "元";
	}
//	return nengou + a[0] + "年" + a[1] + "月" + a[2] + "日";
	return nengou + a[0];
}


/**
 * getDefaultDate
*/
function getDefaultDate(dtp_val, sign) {
	// 指定されたdtp_valに指定されたsignで、日付を加算(減算)
	var ret_dtp = new Date(dtp_val.getTime()+1000*60*60*24*_defaultDate*sign);
	// yyyy/mm/dd HH:MM フォーマットで結果を返す
	return ret_dtp.getFullYear()
				+ "/" + ("0" + (ret_dtp.getMonth()+1)).substr(-2)
				+ "/" + ("0" + ret_dtp.getDate()).substr(-2)
				+ " " + ("0" + ret_dtp.getHours()).substr(-2)
				+ ":" + ("0" + ret_dtp.getMinutes()).substr(-2);
}


/**
 * setDate
*/
function setDate(from, to) {

	// 申込日時Toだけが入力されている場合、申込日時Fromに（申込日時To－6ヶ月）をセットする。
	if(from.val() == "" && to.val() != "") {
		from.val(getDefaultDate(new Date(to.val()), -1));
	}
	// 申込日時Fromだけが入力されている場合、申込日時に（申込日時From＋6ヶ月）をセットする。
	if(from.val() != "" && to.val() == "") {
		to.val(getDefaultDate(new Date(from.val()), 1));
	}
}


/**
 * getDefaultDateTime
*/
function getDefaultDateTime(dtp_val, sign) {
	// 指定されたdtp_valに指定されたsignで、日付を加算(減算)
	var ret_dtp = new Date(dtp_val.getTime()+1000*60*60*24*_defaultDate*sign);
	// yyyy/mm/dd HH:MM フォーマットで結果を返す
	return ret_dtp.getFullYear()
				+ "/" + ("0" + (ret_dtp.getMonth()+1)).substr(-2)
				+ "/" + ("0" + ret_dtp.getDate()).substr(-2)
				+ " " + ("0" + ret_dtp.getHours()).substr(-2)
				+ ":" + ("0" + ret_dtp.getMinutes()).substr(-2);
}


/**
 * setDateTime
*/
function setDateTime(from, to) {

	// 申込日時Toだけが入力されている場合、申込日時Fromに（申込日時To－6ヶ月）をセットする。
	if(from.val() == "" && to.val() != "") {
		from.val(getDefaultDateTime(new Date(to.val()), -1));
	}
	// 申込日時Fromだけが入力されている場合、申込日時に（申込日時From＋6ヶ月）をセットする。
	if(from.val() != "" && to.val() == "") {
		to.val(getDefaultDateTime(new Date(from.val()), 1));
	}
}

/*
 * setRecentAvailableMaxTerm 利用可能な直近（の最大期間）をセットする。
 * from : 開始日セレクタ
 * to : 終了日セレクタ
 * set_to_flg : 開始日設定フラグ（true:日付を設定、false:空文字列を設定）
 */
function setRecentAvailableMaxTerm(from, to, set_to_flg){
	var ret_to = new Date();
	var to_optimized = 	ret_to.getFullYear()
							+ "/" + ("0" + (ret_to.getMonth()+1)).substr(-2)
							+ "/" + ("0" + ret_to.getDate()).substr(-2)
							+ " " + ("0" + ret_to.getHours()).substr(-2)
							+ ":" + ("0" + ret_to.getMinutes()).substr(-2);
	to.val(to_optimized);
	from.val("");
	if(set_to_flg){
		setDateTime(from, to);
	}
}

/*
 *checkDateDiff 日付の差分日数を返却します。
 */
function checkDateDiff(date1Str, date2Str) {
	var date1 = new Date(date1Str);
	var date2 = new Date(date2Str);

	var ret = true;

	// getTimeメソッドで経過ミリ秒を取得し、２つの日付の差を求める
	var msDiff = date2.getTime() - date1.getTime();

	// 求めた差分（ミリ秒）を日付へ変換します（経過ミリ秒÷(1000ミリ秒×60秒×60分×24時間)。端数切り捨て）
	var daysDiff = Math.floor(msDiff / (1000 * 60 * 60 *24));

	// 求めた差分が_defaultDate(日数)より大きい場合
	if(_defaultDate < daysDiff) {
		ret = false;
	}
	return ret;
}

function getWareki(date) {

    var y = date.slice(0, 4);
    var gengo_year = "";

    var R = 2018; //令和変換用
    var H = 1988; //平成変換用
    var S = 1925; //昭和変換用
    var T = 1911; //大正変換用
    var M = 1867; //明治変換用

    if (y > R) {
        if(y == R + 1){
            gengo_year = "令和元年・平成31年";
        }else{
            gengo_year = "令和"+ (y - R) + "年";
        }
    } else if (y > H) {
    	if(y == H + 1){
    		gengo_year = "平成元年・昭和64年";
    	}else{
    		gengo_year = "平成"+ (y - H) + "年";
    	}
    } else if (y > S) {
    	if(y == S + 1){
    		gengo_year = "昭和元年・大正15年";
    	}else{
    		gengo_year = "昭和"+ (y - S) + "年";
    	}
    } else if (y > T) {
    	if(y == T + 1){
    		gengo_year = "大正元年・明治45年";
    	}else{
    		gengo_year = "大正"+ (y - T) + "年";
    	}
    } else if (y > M) {
		gengo_year = "明治"+ (y - M) + "年";
    }

    return gengo_year;

}

/*
値が空( null or undefined or ''(空文字) or [](空の配列) or {}(空のオブジェクト) )を判定
返り値 true: 空
*/
function isEmpty(val) {
    if (!val) {
        //null or undefined or ''(空文字) or 0 or false
        if (val !== 0 && val !== false) {
            return true;
        }
    } else if (typeof val == "object") {
        //array or object
        return Object.keys(val).length === 0;
    }
    return false; //値は空ではない
}

//Htmlの特殊文字はエスケープされない
function specialSymbolEscape(val) {
    var sword = val;
    var put = document.createElement("div");
    put.innerHTML = sword;
    sword = put.innerText || put.textContent;
    return sword;
}

function strlen(string) {
    var str = string + '';
    var i = 0, chr = '', lgth = 0;
    if (!this.php_js || !this.php_js.ini || !this.php_js.ini['unicode.semantics'] || this.php_js.ini['unicode.semantics'].local_value.toLowerCase() !== 'on') {
        return string.length;
    }
    var getWholeChar = function (str, i) {
        var code = str.charCodeAt(i);
        var next = '', prev = '';
        if (0xD800 <= code && code <= 0xDBFF) {
            if (str.length <= (i + 1)) {
                throw 'High surrogate without following low surrogate';
            }
            next = str.charCodeAt(i + 1);
            if (0xDC00 > next || next > 0xDFFF) {
                throw 'High surrogate without following low surrogate';
            }
            return str.charAt(i) + str.charAt(i + 1);
        } else if (0xDC00 <= code && code <= 0xDFFF) {
            if (i === 0) {
                throw 'Low surrogate without preceding high surrogate';
            }
            prev = str.charCodeAt(i - 1);
            if (0xD800 > prev || prev > 0xDBFF) {
                throw 'Low surrogate without preceding high surrogate';
            }
            return false;
        }
        return str.charAt(i);
    };
    for (i = 0, lgth = 0; i < str.length; i++) {
        if ((chr = getWholeChar(str, i)) === false) {
            continue;
        }
        lgth++;
    }
    return lgth;
}
