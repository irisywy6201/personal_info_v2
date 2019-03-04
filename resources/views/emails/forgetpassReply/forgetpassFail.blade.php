@extends("emails.layout")
@section("content")

{{ $username }} 在 {!! HTML::link('/forgetpass', 'serviceDesk') !!} 嘗試修改密碼失敗
<br><br>
以下為其填寫資料：<br>

<table>
	<tr>
		<td style='border: 1px solid black; width: 100px;'>身分</td>
		<td>{{ $stuOrNot }}</td>
	</tr>
	<tr>
		<td>學校帳號</td>
		<td>{{ $schoolID }}</td>
	</tr>
	<tr>
		<td>身分證字號</td>
		<td>{{ $Ideid }}</td>
	</tr>
	<tr>
		<td>生日</td>
		<td>{{ $wholeBir }}</td>
	</tr>
	<tr>
		<td>信箱</td>
		<td>{{ $email }}</td>
	</tr>
	@if ($phone != '')
		<tr>
			<td>電話</td>
			<td>{{ $phone }}</td>
		</tr>
	@endif
</table>

<style>
td
{
	border: 1px solid black;
	border-collpase: collpase; 
}
</style>

<br>
<div>
	若身分為 staff (教職員):<br>
	=> 學校帳號為 "email 帳號"<br>
	(portal 帳號無法在 serviceDesk 網站做忘記密碼修改)<br><br>
	若身分為 student (學生) 或 alumni (校友):<br>
	=> 學校帳號為 "學號"
</div>
<br>
@stop