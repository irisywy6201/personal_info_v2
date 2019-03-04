var i=1;
var current=1;
var ifClick=0;

function printpdf() {
	var pdf = window.open("../../HDDestroyService.pdf");
	pdf.print();
}

function demagnetize(idd) {
	var bool = document.getElementById(idd.value).checked;
	//alert(bool);
	if(bool == true){
		var str = document.getElementById("note"+idd.value).value+" 需要抹除";
                document.getElementById("note"+idd.value).value = str;
	}else{
		document.getElementById("note"+idd.value).value = "";
	}
}

function add_HD(){
	if (document.getElementById("brandAndStorage"+current).value !== "" && document.getElementById("propertyId"+current).value !== "")
	{
	    //HD++
	    i++;
	    current++;

	    //button change
	    $(".glyphicon-minus").replaceWith(function(){
            	return "<button type='button' class='btn btn-danger glyphicon glyphicon-minus' onclick='delete_HD(this)' ></button>";
       	    });
	    var x = document.getElementsByClassName("non-add");
    	    var j;
    	    for (j = 0; j < x.length; j++) {
                x[j].className = "added";
            }

    	    //add a HD
	    var div=document.createElement('div');
	    div.className='non-add';
  	    div.innerHTML='<input type="checkbox" name="demagnetize[]" value="'+current+'"id="'+current+'" onClick="demagnetize(this)"><label for="brandAndStorage_" >硬碟廠牌／容量 :&nbsp; </label><input id="brandAndStorage'+current+'" class="input form-control" name="brandAndStorage[]" id="brandAndStorage'+current+' " type="text" >&nbsp;<label for="propertyId_" >硬碟所屬報廢主機或硬碟財產編號: &nbsp;</label><input id="propertyId'+current+'" class="input form-control" name="propertyId[]" id="propertyId'+current+' " type="text" >&nbsp;</input><label for="note" >備註 :&nbsp; </label><input class="input form-control" name="note[]" id="note'+current+'" type="text" value=" ">&nbsp; <button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="deleteHD" onclick="delete_HD(this)" style="visibility:hidden"></button>&nbsp;<br><br>';
	    document.getElementById('HD').appendChild(div);
	    window.scrollBy(0, 54);
	} else {
	    alert("請輸入完整硬碟資訊！");
	}
}

function delete_HD(div){
	i--;
	//div.parentNode.removeChild( div );
	document.getElementById('HD').removeChild(div.parentNode);
	//document.getElementById('HDD').removeChild(div.parentNode);
	console.log(div.parentNode);
}

//datetime picker
$('#form_datetime').datetimepicker({
	//format:'y-M-d h:i',
	daysOfWeekDisabled: [0, 6],
	autoclose:true,
	todayBtn:true,
	allowTimes:[
  '10:00', '11:00', '13:00', '14:00',
  '15:00', '16:00',
	],
	onGenerate:function( ct ){
    jQuery(this).find('.xdsoft_date.xdsoft_weekend')
      .addClass('xdsoft_disabled');
  },
  weekends:['01.01.2016','02.01.2016','03.01.2016','04.01.2016','05.01.2016','06.01.2016'],
	startDate:new Date(),
});


document.getElementById('HDbutton').onclick = function() {
   if (document.getElementById("brandAndStorage"+current).value !== "" && document.getElementById("propertyId"+current).value !== "" && document.getElementById("identifyExtensionNumber").value !== "" && document.getElementById("form_datetime").value !== "")
	{
	    $('#HDDestroyform').submit();
	} else {
	    if(document.getElementById("brandAndStorage"+current).value == "" || document.getElementById("propertyId"+current).value == ""){
	        alert("請輸入完整硬碟資訊！");
	    } else{
	        alert("請輸入申請人資料！");
	    }
	}
}


