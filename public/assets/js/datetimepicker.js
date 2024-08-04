$(function() {

    $('#dtp1').datetimepicker({
        // 2017.06 管理画面 外部連携 取引時間設定 で 15分単位で選択できるように。
        step: (typeof(datetimepicker_step) == "undefined")? 5 : datetimepicker_step,
        lang: 'ja',
        autoclose: true,
        onChangeDateTime:function(currentDateTime){
            var end = new Date($('#dtp2').val());
            if($('#dtp2').val()){
                if(end < currentDateTime) {
                    $('#dtp1').val($('#dtp2').val());
                }
                this.setOptions({
                    maxDate:new Date($('#dtp2').val())
                });
            }
        },
    });

    $('#dtp2').datetimepicker({
        // 2017.06 管理画面 外部連携 取引時間設定 で 15分単位で選択できるように。
        step: (typeof(datetimepicker_step) == "undefined")? 5 : datetimepicker_step,
        lang: 'ja',
        autoclose: true,
        onChangeDateTime:function(currentDateTime){
            var start = new Date($('#dtp1').val());
            if($('#dtp1').val()){
                if(currentDateTime < start) {
                    $('#dtp2').val($('#dtp1').val());
                }
                this.setOptions({
                    minDate:new Date($('#dtp1').val())
                });
            }
        },
    });

    $('#dtp3').datetimepicker({
        lang: 'ja',
        step: 30,
    });

    $('#dtp4').datetimepicker({
        lang: 'ja',
        step: 30,
    });

    // CPN対応
    $('#cpn_dtp1').datetimepicker({
        // 2017.06 管理画面 外部連携 取引時間設定 で 15分単位で選択できるように。
        step: (typeof(datetimepicker_step) == "undefined")? 5 : datetimepicker_step,
        lang: 'ja',
        autoclose: true,
        onChangeDateTime:function(currentDateTime){
            //var end = new Date($('#cpn_dtp2').val());
            //if($('#cpn_dtp2').val()){
                //if(end < currentDateTime) {
                //    $('#cpn_dtp1').val($('#cpn_dtp2').val());
                //}
                //this.setOptions({
                //    maxDate:new Date($('#cpn_dtp2').val())
                //});
            //}
        },
    });
    $('#cpn_dtp2').datetimepicker({
        // 2017.06 管理画面 外部連携 取引時間設定 で 15分単位で選択できるように。
        step: (typeof(datetimepicker_step) == "undefined")? 5 : datetimepicker_step,
        lang: 'ja',
        autoclose: true,
        onChangeDateTime:function(currentDateTime){
            //var start = new Date($('#cpn_dtp1').val());
            //if($('#cpn_dtp1').val()){
                //if(currentDateTime < start) {
                //    $('#cpn_dtp2').val($('#dtp1').val());
                //}
                //this.setOptions({
                //    minDate:new Date($('#dtp1').val())
                //});
            //}
        },
    });
});
