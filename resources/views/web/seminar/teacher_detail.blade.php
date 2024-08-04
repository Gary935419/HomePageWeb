<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M6PG4C3');</script>
    <!-- End Google Tag Manager -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<title>講師について｜東海電子株式会社</title>
	<meta name="keywords" content="アルコール検知器,アルコールチェッカー,インターロック,IT点呼システム,飲酒運転,遠隔地用アルコール測定器">
	<meta name="description" content="東海電子株式会社は業務用アルコールチェッカー、インターロック、IT点呼システムなどの開発・製造・販売を行っております。全国のトラック、バス、タクシー業界などで採用実績のある、アルコール検知器をぜひご利用ください。">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@100;300;400;500;700;800;900&display=swap" rel="stylesheet">
	<!-- webfont end -->
    <link rel="stylesheet" href="{{ asset('assets/web_css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/web_css/style.css') }}">
	<!-- css end -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/web_js/function.js') }}"></script>
    <script src="{{ asset('assets/web_js/matchHeight/matchHeight.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/web_js/slick/slick.css') }}">
    <script src="{{ asset('assets/web_js/slick/slick.min.js') }}"></script>
	<!-- slick end -->
    <!-- colorbox -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web_js/colorbox/colorbox.css') }}">
    <script type="text/javascript" src="{{ asset('assets/web_js/colorbox/colorbox.min.js') }}"></script>

	<!-- js end -->
    <link rel="icon" href="{{ asset('assets/icon/favicon.ico') }}">
	<!-- favicon end -->
	<meta property="og:title" content="講師について｜東海電子株式会社">
	<meta property="og:type" content="website">
	<meta property="og:description" content="東海電子株式会社は業務用アルコールチェッカー、インターロック、IT点呼システムなどの開発・製造・販売を行っております。全国のトラック、バス、タクシー業界などで採用実績のある、アルコール検知器をぜひご利用ください。">
	<meta property="og:url" content="https://www.tokai-denshi.co.jp/">
	<meta property="og:image" content="https://www.tokai-denshi.co.jp/img/ogp.jpg">
	<meta property="og:site_name" content="アルコールチェッカー（検知器）、インターロックなら東海電子株式会社">
	<!-- ogp end -->


</head>


<body style="background: #fff;">
	<!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M6PG4C3"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

	<div id="wrapper">

        <div class="seminar_t_box">
            <div class="img"><img src="{{$info_teacher['b_url'] ?? ''}}" alt=""></div>
            <div class="seminar_t_txt">
                <dl>
                    <dt>講師</dt>
                    <dd>{{$info_teacher['l_name'] ?? ''}}</dd>
                </dl>
                <dl>
                    <dt>専門分野</dt>
                    <dd>{{$info_teacher['l_professions'] ?? ''}}</dd>
                </dl>
                <dl>
                    <dt>経歴・資格</dt>
                    <dd>{{$info_teacher['l_career_qualifications'] ?? ''}}</dd>
                </dl>
                <dl>
                    <dt>セミナー実績</dt>
                    <dd>{{$info_teacher['l_seminar_results'] ?? ''}}</dd>
                </dl>
                <dl>
                    <dt>地域</dt>
                    <dd>{{$info_teacher['l_area'] ?? ''}}</dd>
                </dl>
            </div>
            <div class="seminar_t_fot_txt">
                <p class="txt">{!! nl2br($info_teacher['l_contents'] ?? '') !!}</p>
            </div>
        </div>

	</div>
	<!-- wrapper end -->

    <script src="https://ssl.google-analytics.com/urchin.js" type="text/javascript"></script>
    <script type="text/javascript">
      _uacct="UA-3439179-2";
      urchinTracker();
    </script>
</body>
</html>
