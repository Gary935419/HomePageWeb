$(function() {

    // 期間FROM
    $('#dp1').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        autoclose: true,
    })
        .on('changeDate', function(e){ //開始日が選択されたら
            selected_date = e['date']; //開始日のデータ取得
            $('#dp2').datepicker('setStartDate', selected_date); //開始日より前の日を無効化する
            end_date = new Date($('#dp2').val());

            var gengo_year = getWareki("" + selected_date.getFullYear());
            if (gengo_year != "") {
            	$('#wareki1').text("西暦 " + selected_date.getFullYear() + " 年 ： " + gengo_year);
            } else {
            	$('#wareki1').html("<p style='color:red'>生年月日が不正の可能性あり</p>");
            }

            if (selected_date > end_date ){
               $('#dp2').val(selected_date.getFullYear() + "/" + ("0" + (selected_date.getMonth()+1)).substr(-2) + "/" + ("0" + selected_date.getDate()).substr(-2));
            }
        })
    ;

    // 期間TO
    $('#dp2').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        autoclose: true,
    })
        .on('click', function() {
            selected_date = $('#dp1').val();
            $('#dp2').datepicker('setStartDate', selected_date); //開始日より前の日を無効化する
        })
    ;

    // 期間FROM
    $('#dp11').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        autoclose: true,
    })
        .on('changeDate', function(e){ //開始日が選択されたら
            selected_date = e['date']; //開始日のデータ取得
            $('#dp12').datepicker('setStartDate', selected_date); //開始日より前の日を無効化する
            end_date = new Date($('#dp12').val());
            if (selected_date > end_date ){
               $('#dp12').val(selected_date.getFullYear() + "/" + ("0" + (selected_date.getMonth()+1)).substr(-2) + "/" + ("0" + selected_date.getDate()).substr(-2) );
            }
        })
    ;

    // 期間TO
    $('#dp12').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        autoclose: true,
    })
        .on('click', function() {
            selected_date = $('#dp11').val();
            $('#dp12').datepicker('setStartDate', selected_date); //開始日より前の日を無効化する
        })
    ;

    // 期間FROM
    $('#dp13').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        autoclose: true,
    })
        .on('changeDate', function(e){ //開始日が選択されたら
            selected_date = e['date']; //開始日のデータ取得
            $('#dp14').datepicker('setStartDate', selected_date); //開始日より前の日を無効化する
            end_date = new Date($('#dp14').val());
            if (selected_date > end_date ){
               $('#dp14').val(selected_date.getFullYear() + "/" + ("0" + (selected_date.getMonth()+1)).substr(-2) + "/" + ("0" + selected_date.getDate()).substr(-2) );
            }
        })
    ;
    // 期間TO
    $('#dp14').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        autoclose: true,
    })
        .on('click', function() {
            selected_date = $('#dp13').val();
            $('#dp13').datepicker('setStartDate', selected_date); //開始日より前の日を無効化する
        })
    ;

//    dt = new Date();
//    today_hizuke = dt.getFullYear() + "/" + ("0" + (dt.getMonth()+1)).substr(-2) + "/" + ("0" + dt.getDate()).substr(-2);
//    $('#dp1').datepicker("setDate", today_hizuke);
//    $('#dp2').datepicker("setDate", today_hizuke);

    $('#dp3').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        autoclose: true,
    });

    $('#dp4').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        autoclose: true,
    });

});
