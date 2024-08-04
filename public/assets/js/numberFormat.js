//数千の量format
//length:小数位桁数
//type(""またわ0またわ"-")フィールド値出ない場合、元の画面に 0.n*0と表示されている場合は"入力0"と入力します、その他と表示されている場合は望ましい値と入力します。
function number_format_edit(value,length,type){
	var str;
	//数字check
	var numcheck = /^[+-]?(0|([1-9]\d*))(\.\d+)?$/g;
	if(!numcheck.test(value)){
		if(type == 0){
			value = 0;
		}else{
			return type;
		}	
	}
	var arr = new Array(2);
	if(value.toString().indexOf(".") != -1){
		arr[0] = value.toString().substr(0,value.toString().indexOf("."));
		arr[1] = value.toString().substr(value.toString().indexOf(".")+1,value.length);
	}else{
		arr[0] = value;
		arr[1] = "";
	}
	var arrLength = arr[1].length;
	if(arrLength < length){
			for(var i = 0; i < (length-arrLength); i++){
				arr[1] = arr[1]+"0";
			}
	}
	str = arr[0].toString().replace(/\d{1,3}(?=(\d{3})+(\.|$))/g,'$&,');
	return str+"."+arr[1];	
}

function change_number_format( $value, $decimals=0, $default='' ){
		if($value == null || $value == "" || $value == 0){
			if($value != 0){
				return $default;
			}
			$value = $default;
		}
		$explode_value = explode(".", $value);
		if(count($explode_value) == 2){
			$point_a = number_format("0."+$explode_value[1], $decimals);
			$point_ab = explode(".", $point_a);
			if($point_a.toString().indexOf("e") == -1){
				$point = $point_a;				
			}else{
				if($point_ab[1].toString().indexOf("e") == -1){
					$point = Number($point_ab[0]).toFixed($decimals); 
				}else{
					$point_ac = explode("e",$point_a);
					$point_b = $point_ac[0]+"e"+$point_ac[1].toString().substr(0,2);
					$point = Number($point_b).toFixed($decimals); 
				}
			}
			if($point >= 1){
				if($value < 0){
					$int = number_format(Number($explode_value[0]) - 1);
				} else {
					$int = number_format(Number($explode_value[0]) + 1);
				}				
				
				if($decimals == 0){
					$point_after = "";
				} else {
					$point_after = explode(".", $point);
				}
			} else {
				$int = number_format($explode_value[0]);

				if($decimals == 0){
					$point_after = "";
				} else {
					$point_after = explode(".", $point);
				}
			}
			$output = $int +"."+ $point_after[1];
			return $output;
		}

		$output = number_format( $value, $decimals );
		return $output;
	}