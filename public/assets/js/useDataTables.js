var list_count = 1000; // 2020-08-14 各ページ検索結果を１ページあたり1000件表示するように変更
var now_page_index = 0;
var total_count = 0;
var datas = [];
var max_page_index = 0;

function init() {
	total_count = sizeof(datas) -1;
	list_count = $('#list_count').val();
	now_page_index = 0;


	$('#tbody').empty();
	$('.index_button').remove();
	$('#total').text(total_count);

	// ページャーを計算
	max_page_index = ceil(total_count / list_count);
	for(var i = 1; i <= max_page_index; i++) {
		var j = i - 1;
		var line = $("<li class='paginate_button index_button' aria-controls='dataTables-common' tabindex='"+j+"'><a href='#'>"+i+"</a></li>");
		line.click(function(){
			var tabindex = $(this).attr('tabindex');
			now_page_index = tabindex;
			draw();
			return false;
		});
		$('#dataTables-common_next').before(line);
	}

}

var jtable = null;

function draw() {
	var start = 0;
	var end = total_count;

	datass = [];
	if (typeof datas_to_list != 'function') {
		return;
	}
	for (var i = start ; i <= end; i++) {
		datass[sizeof(datass)] = datas_to_list.call(window, datas[i]);
	}

        var columns = columns_align;
        if (typeof columns == 'function') {
            columns = columns.call(window);
        }
	//console.debug(datass);
	jtable = $("#dataTables-common").dataTable({
		"iDisplayLength": (typeof(iDisplayLength) == "undefined")? 10 : iDisplayLength,
		"columns": columns,
		data : datass,
		destroy: true,
        "oLanguage": {
            "sLengthMenu" : "显示条数 _MENU_ 件",
            "oPaginate"   : {
                "sNext"     : "下一页",
                "sPrevious" : "上一页",
            },
            "sInfo" : "全_TOTAL_件中 _START_〜_END_件显示中",
            "sSearch" : "检索：",
            "sZeroRecords" : "目前没有任何数据显示。",
            "sInfoEmpty" : "目前没有任何数据显示。",
            "sInfoFiltered" : "(全_MAX_件中、过滤显示)",
            "sProcessing" : "请稍等一会儿。",
        },
        "bStateSave": (typeof(bStateSave) == "undefined")? false : bStateSave,
        "ordering": (typeof(datatables_ordering) == "undefined")? true : datatables_ordering,
        "columnDefs": (typeof(columnDefs) == "undefined")? [] : columnDefs,
        "bAutoWidth": (typeof(datatables_bAutoWidth) == "undefined")? true : datatables_bAutoWidth,
        //"bPaginate" : true, // ページングを表示
        "bPaginate": (typeof(datatables_bPaginate) == "undefined")? true : datatables_bPaginate,
        // TUMITATE-1165 Add End
        "bProcessing" : true // 処理が長いときに処理中の表示をする

	});

	if (typeof after_draw == 'function') {
		after_draw.call(window);
	}
}

function common_search() {

        if(typeof reload_page_if_need == 'function' && reload_page_if_need.call(window)) {
            return;
        }

	var url = "";
	if(typeof search_url != "undefined") {
		url = search_url;
	}
	var params = {};
	if (typeof params_from_form == 'function') {
		params = params_from_form.call(window);
        if(params == false) {
            return;
        }
	} else {
		return;
	}

	$('#tbody').empty();

	ajax.post(url, params, function(data){
		//console.debug(data);
		datas = data['DATAS'];
		if (data['MESSAGE'] != '') {
			alert(data['MESSAGE']);
		}

		init();
		draw();
	});
}

function common_search_pp() {

	if(typeof reload_page_if_need == 'function' && reload_page_if_need.call(window)) {
		return;
	}

	var url = "";
	if(typeof search_url != "undefined") {
		url = search_url;
	}
	var params = {};
	if (typeof params_from_form == 'function') {
		params = params_from_form.call(window);
		if(params == false) {
			return;
		}
	} else {
		return;
	}

	$('#tbody').empty();

	ajax.post(url, params, function(data){
		//console.debug(data);
		datas = data['DATAS'];
		if (data['MESSAGE'] != '') {
			alert(data['MESSAGE']);
		}

		init();
		draw_pp();
	});
}

function draw_pp() {
	var start = 0;
	var end = total_count;

	datass = [];
	if (typeof datas_to_list != 'function') {
		return;
	}
	for (var i = start ; i <= end; i++) {
		datass[sizeof(datass)] = datas_to_list.call(window, datas[i]);
	}

        var columns = columns_align;
        if (typeof columns == 'function') {
            columns = columns.call(window);
        }
	//console.debug(datass);
	jtable = $("#dataTables-common").dataTable({
		"iDisplayLength": (typeof(iDisplayLength) == "undefined")? 10 : iDisplayLength,
		"columns": columns,
		data : datass,
		destroy: true,
		"oLanguage": {
            "sInfo" : "",
        },
		"searching": false,
		"bLengthChange": false,
		"paging":false,
        // TUMITATE-1165 Add Start 2017.2.15
        "ordering": false,
        "columnDefs": (typeof(columnDefs) == "undefined")? [] : columnDefs,
        "bAutoWidth": false,
        //"bPaginate" : true, // ページングを表示
        "bPaginate": false,
        // TUMITATE-1165 Add End
        "bProcessing" : true // 処理が長いときに処理中の表示をする

	});

	if (typeof after_draw == 'function') {
		after_draw.call(window);
	}
}

$(function(){
	if(typeof search_first != "undefined") {
		console.debug("search when loaded");
		common_search();
	}

	$('#before').click(function(){
		now_page_index = now_page_index - 1;
		if (now_page_index < 0) {
			now_page_index = 0;
		}
		draw();
		return false;
	});

	$('#next').click(function(){
		now_page_index = intval(now_page_index) + 1;
		if (now_page_index + 1 >= max_page_index) {
			now_page_index = max_page_index - 1;
		}
		draw();
		return false;
	});

	$('#list_count').change(function(){
		list_count = $(this).val();
		init();
		draw();
	});

	$('#btn_search').click(function(){
		common_search();
        $('#btn_search').blur();
	});

	$('#btn_download').click(function(){

		var url = "";
		if(typeof conditions_url != "undefined") {
			url = conditions_url;
		}
		var params = {};
		if (typeof params_from_form == 'function') {
			params = params_from_form.call(window);
		} else {
			return;
		}
		if(params == false) {
			return;
		}

		if(url != "") {
			ajax.post(url, params, function(data){
				if(typeof download_url != "undefined") {

					if (data['MESSAGE'] != '') {
                        $.alert({
                            title: false,
                            theme: 'white',
                            content: data['MESSAGE'],
                            confirmButton: '我知道啦~',
                            confirmButtonClass: 'btn-info',
                        });
                        return false;
					}

					$.confirm({
						title: false,
						theme: 'white',
						content: '确认进行下载操作么?',
						confirmButton: '确认',
						cancelButton: '取消',
						confirmButtonClass: 'btn-info',
						confirm: function(){
							location.href = download_url;
						},
					});
				}

			});
		}
	});
});
