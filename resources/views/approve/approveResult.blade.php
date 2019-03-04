@extends("admin.adminLayout")
@section("modifyContent")
<h3 align="center"> <b> 已驗證記錄 </b> </h3><br>
<h4 align="center"> <b>(依照"申請時間"排序 最上方為最晚申請傳者)</b> </h4><br>
@if ($dataCount != 0)
	@foreach($approvedData as $key => $value)
		<table id='approvedData' style='background-color: white; font-family: 微軟正黑體; font-weight: bold;'>
			<tr>
				<td id="TorF{{ $value['id'] }}">
					@if($value['status'] == 2)
						失敗
						<script>
							$("#TorF{{ $value['id'] }}").css('background-color', '#FFC8B4');
						</script>
					@else
						成功
						<script>
							$("#TorF{{ $value['id'] }}").css('background-color', '#99FF99');
						</script>
					@endif	
				</td>

				<td>
					編號: {{ $value['id'] }}
				</td>

				<td>
					{{ $value['name'].'   ('.$value['stuOrNot'].')' }}
				</td>
				
				<td>
					{{ $value['schoolID'] }}
				</td>
					
				<td>
					(上傳){{ $value['created_at'] }}
				</td>

				<td>
					(結案){{ $value['updated_at'] }}
				</td>

				<td>
					{{ $value['email'] }}
				</td>

			</tr>
		</table>

		@if($value['status'] == 2)
		<table>
			<tr>
				<td>
					失敗理由：
				</td>
				
				<td>
					{{ $value['failReason'] }}
				</td>
			</tr>
		</table>
		<br>

		@else
		<table>
			<tr>
				<td>
					目前狀態：
				</td>
				
				<td>
					@if($value['changePassword_status'] == 1)
						修改完成
					@elseif($value['changePassword_status'] == 2)
						修改失敗
					@elseif($value['changePassword_status'] == 0)
						處理中
					@else
						無記錄
					@endif

				</td>
			</tr>
		</table>
		@endif
		<br>

	@endforeach

	<script>

		$('td').css({
			'border'		: '1px solid #DDDDDD',
			'padding'		: '7px',
			'font-family'	: '微軟正黑體',
			'font-weight'	: 'bold',
		});

		$('table').css({
			'background-color': 'white',
		});

		//$('#reason td').css('width', '902px');
	</script>
@else
<h4 align="center"> <b> 目前沒有已經審核資料 </b> </h4><br>
@endif

@stop