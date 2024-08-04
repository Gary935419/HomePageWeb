/* ヘッダーの高さを取得してその分コンテンツを下げる
----------------------------------------------------------------------*/
$(window).on('load', function () {
    // ページのURLを取得
    const url = $(location).attr('href'),
        // headerの高さを取得してそれに30px追加した値をheaderHeightに代入
        headerHeight = $('header').outerHeight() + 30;

    // urlに「#」が含まれていれば
    if (url.indexOf("#") != -1) {
        // urlを#で分割して配列に格納
        const anchor = url.split("#"),
            // 分割した最後の文字列（#◯◯の部分）をtargetに代入
            target = $('#' + anchor[anchor.length - 1]),
            // リンク先の位置からheaderHeightの高さを引いた値をpositionに代入
            position = Math.floor(target.offset().top) - headerHeight;
        // positionの位置に移動
        $("html, body").animate({scrollTop: position}, 500);
    }
});


$(function () {

    // #で始まるa要素をクリックした場合の処理
    // "#"はダブルクォーテンションで囲まないと、jQueryのバージョンによっては動かない
    $('a[href^="#"]').click(function () {


        var windowWidth = $(window).width();

        // スクロールの速度（ミリ秒）
        var speed = 500;
        // 移動先をずらすためにheaderの高さを取得
        //var adjust = $('header').height();


        if (windowWidth < 768) {
            var adjust = 50;
        } else {
            var adjust = 110;
        }


        // 追加したい高さを設定
        //var additionalHeight = 50;
        // 新しい高さを設定
        //$('header').height(adjust + additionalHeight);
        // クリックしたページ内リンクの値を取得
        var href = $(this).attr("href");
        // 移動先を取得 リンク先(href）のidがある要素を探して代入
        var target = $(href == "#" || href == "" ? 'html' : href);
        // 移動先を調整 idの要素の位置をoffset()で取得して代入
        //var position = target.offset().top - (adjust + additionalHeight);
        var position = target.offset().top - adjust;
        // スムーススクロール linear（等速） or swing（変速）
        $('body,html').animate({scrollTop: position}, speed, 'swing');
        return false;


    });


});


/* page_top
----------------------------------------------------------------------*/
$(function () {
    var topBtn = $('#page_top');
    topBtn.hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) { //スクロールが100に達したらボタン表示
            topBtn.fadeIn();
        } else {
            topBtn.fadeOut();
        }
    });
    topBtn.click(function () { //スクロールしてトップ
        $('body,html').animate({
            scrollTop: 0
        }, 300);
        return false;
    });
});


/* matchHeight
----------------------------------------------------------------------*/
$(window).on('load resize', function () {
    var w = $(window).width();
    var x = 768;
    if (w > x) {
        $('.seminar_box li .txt').matchHeight();
        $('.customers_logo_box li').matchHeight();
        $('.customers_logo').matchHeight();
        $('.customers_name').matchHeight();
        $('#support .support_page_list li dl').matchHeight();
    }
});


/* アコーディオン

----------------------------------------------------------------------*/
$(function () {
    $(".aco_box").hide();
    $(".aco_btn").click(function () {
        $(this).next().slideToggle();
        $(this).toggleClass('open');
    });
});


$(function () {
    $(".f_open .aco_box").show();
    /*$(".f_open .aco_btn").click(function() {
        $(this).next().slideToggle();
        $(this).toggleClass('open');
    });*/
});


$(function () {
    // URLのハッシュ部分（id）を取得
    const urlHash = location.hash;
    // そのidを持つ要素がなかったら処理を抜ける
    if (!$(urlHash).length) return;

    // アコーディオンの要素を開く処理
    $(urlHash)
        .find('#price_aco_btn')
        .addClass('open')
        .next()
        .show();
});


/* slick
----------------------------------------------------------------------*/
/* logo_slide01 */
$(function () {
    $('.slider_logo01').slick({
        autoplay: true, // 自動でスクロール
        autoplaySpeed: 0, // 自動再生のスライド切り替えまでの時間を設定
        speed: 6000, // スライドが流れる速度を設定
        cssEase: "linear", // スライドの流れ方を等速に設定
        slidesToShow: 6, // 表示するスライドの数
        swipe: false, // 操作による切り替えはさせない
        arrows: false, // 矢印非表示
        pauseOnFocus: false, // スライダーをフォーカスした時にスライドを停止させるか
        pauseOnHover: false, // スライダーにマウスホバーした時にスライドを停止させるか
        responsive: [
            {
                breakpoint: 1500,
                settings: {
                    slidesToShow: 5, // 画面幅1500px以下でスライド3枚表示
                },
            },
            {
                breakpoint: 750,
                settings: {
                    slidesToShow: 3, // 画面幅750px以下でスライド3枚表示
                },
            },
        ]
    });
});


/* logo_slide02 */
$(function () {
    $('.slider_logo02').slick({
        autoplay: true, // 自動でスクロール
        autoplaySpeed: 0, // 自動再生のスライド切り替えまでの時間を設定
        speed: 6000, // スライドが流れる速度を設定
        cssEase: "linear", // スライドの流れ方を等速に設定
        slidesToShow: 6, // 表示するスライドの数
        swipe: false, // 操作による切り替えはさせない
        arrows: false, // 矢印非表示
        pauseOnFocus: false, // スライダーをフォーカスした時にスライドを停止させるか
        pauseOnHover: false, // スライダーにマウスホバーした時にスライドを停止させるか
        rtl: true, // スライダーを左から右に流す（逆向き）
        responsive: [
            {
                breakpoint: 1500,
                settings: {
                    slidesToShow: 5, // 画面幅1500px以下でスライド3枚表示
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3, // 画面幅768px以下でスライド3枚表示
                },
            },
        ]
    });
});

/* slider_products */
$(function () {
    $(".slider_products").slick({
        arrows: true,
        autoplay: true,
        adaptiveHeight: true,
        centerMode: true,
        centerPadding: "25%",
        dots: true,

        responsive: [

            {
                breakpoint: 768,
                settings: {
                    centerPadding: "0%", // 画面幅768px以下でスライド3枚表示
                },
            },
        ]

    });
});


/* slider_seminar */
$(function () {
    $(".slider_seminar").slick({
        arrows: true,
        autoplay: true,
        adaptiveHeight: true,
        centerMode: true,
        centerPadding: "15%",
        dots: true,
        slidesToShow: 3, // 表示するスライドの数

        responsive: [
            {
                breakpoint: 1400,
                settings: {
                    centerPadding: "10%",
                    slidesToShow: 3, // 表示するスライドの数
                },
            },

            {
                breakpoint: 1200,
                settings: {
                    centerPadding: "5%",
                },
            },

            {
                breakpoint: 900,
                settings: {
                    centerPadding: "2%",
                    slidesToShow: 1, // 画面幅768px以下でスライド3枚表示
                },
            },
        ]

    });
});

/* topics */
$(function () {
    $('.news_list').slick({
        infinite: false,
        autoplay: false, // 自動でスクロール
        slidesToShow: 5, // 表示するスライドの数
        swipe: false, // 操作による切り替えはさせない
        arrows: true, // 矢印非表示
        dots: false,
        responsive: [
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 4, // 画面幅1500px以下でスライド3枚表示
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2, // 画面幅750px以下でスライド3枚表示
                },
            },
        ]
    });
});


/* slider_customers */
$(function () {
    $(".customers_top").slick({
        arrows: false,
        autoplay: true,
        adaptiveHeight: true,
        centerMode: true,
        centerPadding: "30%",
        dots: true,

        responsive: [

            {
                breakpoint: 1000,
                settings: {
                    centerPadding: "0%", // 画面幅768px以下でスライド3枚表示
                },
            },
        ]

    });
});


/* toggleスマホメニュー
----------------------------------------------------------------------*/
$(function () {
    var btn = $('#btn_nav,#nav');
    var btn_close = $('#btn_nav.active');
    btn.on('click', function () {
        btn.toggleClass('active');
    });
    btn_close.on('click', function () {
        btn.removeClass('active');
    });
});


/* トップページ動画
----------------------------------------------------------------------*/


/* colorbox
----------------------------------------------------------------------*/
$(function () {
    $(".colorbox").colorbox({
        next: false,
        previous: false,
        maxWidth: "90%",
        maxHeight: "90%",
    });
});
$(function () {
    $(".cb_close").click(function () {
        parent.$.fn.colorbox.close();
        return false;
    });
});


/* technology
----------------------------------------------------------------------*/

// URLパラメータを取得する関数
/*
function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}
*/
const params = new URLSearchParams(window.location.search);
console.log("▼パラメータ取得");
console.log(params);

// 'tab' パラメータの値を取得
const tab = params.get('tab');

switch (tab) {
    case 't1':
        console.log("t1取得");

        document.addEventListener('DOMContentLoaded', function () {

            /*
            var element = document.getElementById('tab_list_check');
            element.classList.add('c1');
            */
            // 全てのラジオボタンを取得
            var radios = document.getElementsByName('tab');
            // 現在選択されているラジオボタンを見つける
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    // 現在のチェックを外す
                    radios[i].checked = false;
                    // 次のラジオボタンにチェックを入れる
                    radios[0].checked = true;
                    break;
                }
            }
        });

        break;
    case 't2':
        console.log("t2取得");
        document.addEventListener('DOMContentLoaded', function () {

            // 全てのラジオボタンを取得
            var radios = document.getElementsByName('tab');
            // 現在選択されているラジオボタンを見つける
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    // 現在のチェックを外す
                    radios[i].checked = false;
                    // 次のラジオボタンにチェックを入れる
                    radios[1].checked = true;
                    break;
                }
            }

        });
        break;
    case 't3':
        console.log("t3取得");
        document.addEventListener('DOMContentLoaded', function () {

            // 全てのラジオボタンを取得
            var radios = document.getElementsByName('tab');
            // 現在選択されているラジオボタンを見つける
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    // 現在のチェックを外す
                    radios[i].checked = false;
                    // 次のラジオボタンにチェックを入れる
                    radios[2].checked = true;
                    break;
                }
            }


        });
        break;
    default:
        //document.getElementById('tabContent').innerHTML = '<p>Default content</p>';
        break;
}


/* Concept Movie
----------------------------------------------------------------------*/








