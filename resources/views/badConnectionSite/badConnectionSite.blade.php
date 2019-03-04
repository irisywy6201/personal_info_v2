@extends("layout")
@section("content")

{{ HTML::script('js/datetimepicker/jquery.js') }}
{{ HTML::script('js/datetimepicker/jquery.datetimepicker.js') }}
{{ HTML::style('css/datetimepicker/jquery.datetimepicker.css') }}
	<h3 align="center"> <b> 連結困難網站回報 </b> </h3><br>

	<div style="font-size: 18px; font-weight: bold; font-family: 微軟正黑體;">
		由於眾多師生反映學校 (ip = 140.115.xxx.xxx) 對外連結 (國外網站) 緩慢
        <br>
        煩請於下方輸入您覺得
        <span style="color: red;">連線不順利的網址</span>
        <br>
        計中會依據使用者通報疏通流量解決緩慢問題
        <br>
        謝謝您！
        <br><br>
        由於本站僅收集分析中央大學校內對外連結
        <br>
        您目前使用的 IP 為: 
        <span style="color: red;">{{ $client_ip }}</span>
        @if( $isNcuOrNot == 1)
            (中央大學校內 IP)
            <br>
            <span style="color: green; font-size: 23px;">符合回報條件</span>，請繼續填寫以下資訊
        @else
            (校外 IP)
            <br>
            <span style="color: red; font-size: 23px;">不符合回報條件</span>，煩請回報校內 IP 資訊，感謝您的回報
        @endif
        <br><br>
	</div>

    <div>
        <span style="font-size: 30px; color: red;">{{ Session::get('notNcu') }}</span>
    </div>


<form id="bootstrapSelectForm" method="post" action="badConnectionSite" class="form-horizontal">

        <br><br>

    {{ Form::text('badUrl', '', array('id' => 'badUrlInput', 'class'=>'form-control', 'placeholder'=> '請輸入網址')) }}

    <br><br>

    <span style="font-size: 18px; font-weight: bold; font-family: 微軟正黑體;">並請您選擇事發地點：</span>
    <br><br>

    <div class="form-group">
        <label class="col-xs-3 control-label">宿舍</label>
        <div class="col-xs-5 selectContainer">
            <select id="dormSelector" name="dormSelector" class="form-control">
                <option value="" disabled selected style="display: none;">請選擇宿舍</option>
                <option value="B3">男三舍</option>
                <option value="B5">男五舍</option>
                <option value="B6">男六舍</option>
                <option value="B7">男七舍</option>
                <option value="B9">男九舍A</option>
                <option value="B9">男九舍B</option>
                <option value="B11">男十一舍</option>
                <option value="B12">男十二舍</option>
                <option value="B13">男十三舍</option>

                <option value="G1">女一舍</option>
                <option value="G2">女二舍</option>
                <option value="G3">女三舍</option>
                <option value="G4">女四舍</option>
                <option value="G5">女五舍</option>
                <option value="G14">女十四舍</option>
                <option value="national">國際學生宿舍</option>
                <option value="MaleMaster">研究生宿舍</option>
                <option value="Teacher1">教職員單一舍</option>
                <option value="Teacher2">教職員單二舍</option>
                <option value="Teacher4">教職員單四舍</option>
                <option value="newVillage">中大新村</option>
                <option value="northVillage">中大北村</option>
            </select>
        </div>
    </div>
<span style="font-size: 18px; font-weight: bold; font-family: 微軟正黑體; margin-left: 30%;">或是</span>
<br><br>
    <div class="form-group">
        <label class="col-xs-3 control-label">系館 & 研究中心</label>
        <div class="col-xs-5 selectContainer">
            <select id="buildingSelector" name="buildingSelector" class="form-control">
                <option value="" disabled selected style="display: none;">請選擇建築</option>
                <option value="A1">文學一館</option>
                <option value="C2">文學二館</option>
                <option value="LS">文學三館(人文社會科學大樓)</option>

                <option value="E">工程一館(土木化材)</option>
                <option value="E1">工程二館(通訊電機)</option>
                <option value="E2">工程三館(機械)</option>
                <option value="E3">工程四館(環工化工)</option>
                <option value="E6">工程五館(資工)</option>
                <option value="E4">機電實驗室</option>
                <option value="E5">大型力學實驗室</option>
                

                <option value="H2">理學院教學館</option>
                <option value="H3">實習三館</option>
                <option value="IL">國鼎光電大樓</option>
                <option value="M">鴻經館</option>
                <option value="O">綜教館</option>

                <option value="R2">太空及遙測研究中心</option>
                <option value="R3">研究中心大樓二期</option>

                <option value="S">科學一館</option>
                <option value="S1">科學二館</option>
                <option value="S2">科學三館</option>
                <option value="S4">科學四館(健雄館)</option>
                <option value="S5">科學五館</option>

                <option value="YH">體育館(依仁堂)</option>

                <option value="I">管理一館(志希館)</option>
                <option value="I1">管理二館</option>
                <option value="HK">客家學院大樓</option>

                <option value="EH">實習一廠</option>
                <option value="EQ">風洞實驗室及品保中心</option>
                
                <option value="RWS">氣象觀測站</option>
                <option value="RWR">氣象雷達站</option>
                <option value="G">大氣環境實驗室</option>
            </select>
        </div>
    </div>



<br><br><br><br>
<span style="font-size: 18px; font-weight: bold; font-family: 微軟正黑體;">選擇事發樓層：</span>
<br><br>

    <div class="form-group">
        <label class="col-xs-3 control-label">樓層</label>
        <div class="col-xs-5 selectContainer">
            <select id="floorSelector" name="floorSelector" class="form-control">
                <option value="" disabled selected style="display: none;">請選擇樓層</option>
                <option value="B5">B5</option>
                <option value="B4">B4</option>
                <option value="B3">B3</option>
                <option value="B2">B2</option>
                <option value="B1">B1</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
            </select>
        </div>
    </div>

<br><br><br><br>
<span style="font-size: 18px; font-weight: bold; font-family: 微軟正黑體;">選擇事發時間：</span>
<br><br>


    {{ Form::text('datetimepicker', '', array('id' => 'datetimepicker', 'class'=>'form-control', 'placeholder'=> '點擊輸入框即可選擇')) }}

<br><br><br><br>
    <div class="form-group">
        <div>
            <button id="button" type="button" class="btn btn-default">送出</button>
        </div>
    </div>
</form>




<script>

$('#datetimepicker').datetimepicker();

$('#dormSelector').change(function(){
    $('#buildingSelector').val("");
});

$('#buildingSelector').change(function(){
    $('#dormSelector').val("");
});

$('#button').click(function() 
{
    checkInput();
});

function checkInput()
{
    var temp2 = $('#floorSelector').val();
    var temp3 = $('#datetimepicker').val();
    var temp4 = $('#badUrlInput').val();

    var count = 1;
    if(temp2 == null)
    {
        count = 0;
    }

    if(temp3 == "")
    {
        count = 0;
    }

    if(temp4 == "")
    {
        count = 0;
    }

    if(buildingSelectOrNot() == 0)
    {
        count = 0;
    }
    console.log("count: " + count);
    if(count != 0)
    {
        console.log("good");

        console.log($('#floorSelector').val());
        console.log($('#datetimepicker').val());
        console.log($('#badUrlInput').val());
        $('#bootstrapSelectForm').submit();
    }else
    {
        console.log("bad");
    }
}

function buildingSelectOrNot()
{
    var temp = $('#dormSelector').val();
    var temp1 = $('#buildingSelector').val();
    var count = 0;
    if(temp != null)
    {
        count++;
    }
    if(temp1 != null)
    {
        count++;
    }

    if(count == 0)
    {
        return 0;
    }else
    {
        return 1;
    }
}
</script>

@stop
