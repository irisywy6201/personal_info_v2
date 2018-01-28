<style>
.contentstyle{
	padding-left:25%;
	padding-top:10px;
}
#menu{
	display:block;
	border: 2px solid #cce6ff;
	background-color:#cce6ff;
	text-aligin:center;
	margin-top:5px;
	padding-right:2%;
	float:left;
	border-radius: 25px;
	width:20%;
}

#olstyle{
	color:#0066cc;
	display:block;
	list-style-type:decimal;
	padding-left:25%;
}
</style>

<div id="menu">
<table class="articlelist" >
		<tbody>
		<br>
        <ol id="olstyle">	
			<li><a class="link" href="#" rel="windowskms">Windows KMS 認證方式</a></li>
			<li><a class="link" href="#" rel="officekms">Office KMS 認證方式</a></li>
		</ol>
		</tbody>
</table>
</div>	
	<div class="contentstyle" id="windowskms" style="">
<article class="wk-content clearfix"><h3>Windows KMS 認證方式</h3>
<ol>
<li>本校 KMS 認證方式有兩種:
<ul>
<li>以批次執行檔方式啟動</li>
<li>以個別認證指令方式啟動。可參考「<a href="https://ncu.edu.tw/KMS/">KMS認證</a>」。</li>
</ul>
</li>
</ol>
<h4>認證方法1: 以批次執行檔方式啟動</h4>
<ol>
<li>點擊下載檔案：<a href="/Windows_KMS.bat" target="_blank">Windows_KMS.bat</a>。<br><br></li>
<li>開啟檔案總管 (Windows Explorer), 將檔案移至 C:\Windows\system32 下<br><br></li>
<li><p>A. 在 C:\Windows/system32/Windows_KMS.bat 檔案上按右鍵，<br>B. 選擇「 以系統管理員身分執行」。</p>
</li>
<li>系統將出現使用者帳戶控制的提示，按「是」繼續執行，即可啟用成功。<br><br></li>
<li>啟用成功的畫面如圖（以 Windows 10為例）：<br><br><img alt="Windows_kms.JPG" src="/img/Windows_kms.JPG"></li>
</ol>
<h4>認證方法2: 以指令方式啟動</h4>
<h5>若以上方式無法成功，您可以嘗試「<a href="https://ncu.edu.tw/KMS/">KMS認證</a>」</h5>
</article>
	</div>

    <div class="contentstyle" id="officekms" style="display:none">
<article class="wk-content clearfix"><h3>Office KMS 認證方式</h3>
<h4>本說明適用 Office 2016 / 2013 / 2010&nbsp;作業系統。</h4>
<ul>
<li>安裝時不需要輸入序號，但在安裝後必須通過 KMS 認證。</li>
<li>本校 KMS 認證方式有兩種:
<ul>
<li>以批次執行檔方式啟動</li>
<li>以個別認證指令方式啟動。可參考「<a href="https://ncu.edu.tw/KMS/">KMS認證</a>」。</li>
</ul>
</li>
</ul>
<h3>以執行檔方式啟動</h3>
<ol>
<li>請先確認您安裝Office的檔案位置</li>
<li>請依下述步驟執行Office認證: 請依您安裝的版本，先以右鍵點選連結，並「另存新檔」：<a href="/Office2016_KMS.bat" target="_blank">Office2016</a>&nbsp;/&nbsp;<a href="/Office2013_KMS.bat" target="_blank" >Office2013</a>&nbsp;/&nbsp;<a href="/Office2010_KMS.bat" target="_blank">Office2010</a> 。</li>
<li>請在剛才下載的 .bat 檔案上按右鍵，選擇 「以系統管理員身分執行」。</li>
<li>系統將出現使用者帳戶控制的提示，請按「是」繼續執行，即可啟用成功。</li>
<li>啟用成功的畫面如下圖（以 Office2016 為例）： 圖示位置將出現「Product activation successful」的文字， 表示您已認證成功。<br><img alt="" src="/img/Office2016.JPG"></li>
</ol>
<h3>以指令方式啟動 　　</h3>
<h4>認證方法2: 以指令方式啟動</h4>
<h5>若以上方式無法成功，您可以嘗試「<a href="https://ncu.edu.tw/KMS/">KMS認證</a>」</h5>
</article>
    </div>
<script>
$(".link").on('click', function(){
   var article = $(this).attr('rel');
   $("#"+article).show().siblings(".contentstyle").hide();
   console.log(321);
});
</script>