@extends("layout")
@section("content")
<div class="row">
	<div class="col-lg-12">
		<div class="page-header">
			<h1 id="tables">{{ Lang::get('messages.userinfo') }}</h1>
		</div>
		<div class="bs-example table-responsive">
			<table class="table table-hover table-condensed">
				<tbody>
					<tr class="info">
						<th>{{ Lang::get('userinfo.account') }}</th>
						<td>
							{{ $portal_id }}
						</td>
					</tr>

					<tr class="info">
						<th>{{ Lang::get('userinfo.backupMail') }}</th>
						<td>
							{{ $email }}
						</td>
					</tr>
					<tr class="info">
						<th>{{ Lang::get('userinfo.lastLogin') }}</th>
						<td>
							@if ($noLoginData == 0)
								{{ $loginCreated_at }}

								{{ $loginCountry.' '.$loginCity }}

								<span style="color: green;">
									&nbsp&nbsp&nbsp ip:
								</span>

								{{ $loginIp }}

								<span style="color: green;">
									{{ Lang::get('userinfo.login') }}
								</span>

							@else 
								{{ Lang::get('userinfo.noLoginInfo') }}

							@endif 

						</td>
					</tr>
					<tr class="info">
						<th>{{ Lang::get('userinfo.lastModifyPass') }}</th>
						<td>
							@if ($noChangePassData == 0)
								{{ $changePassCreated_at }}

								{{ $changePassCountry.' '.$changePassCity }}

								<span style="color: green;">
									&nbsp&nbsp&nbsp ip:
								</span>

								{{ $changePassIp }}

								<span style="color: green;">
									{{ Lang::get('userinfo.modify') }}
								</span>

							@else 
								{{ Lang::get('userinfo.noModifyPassInfo') }}
							@endif
	                	</td>
					</tr>
					
					<tr class="info">
						<th>{{ Lang::get('userinfo.lastModifyBackupMail') }}</th>
						<td>
							@if ($noChangeMailData == 0)
	
								{{ $changeMailCreated_at }}

							{{ $changeMailCountry.' '.$changeMailCity }}

							<span style="color: green;">
								&nbsp&nbsp&nbsp ip:
							</span>

							{{ $changeMailIp }}

							<span style="color: green;">
								{{ Lang::get('userinfo.modify') }}
							</span>

							@else 
								{{ Lang::get('userinfo.noModifyBackupMailInfo') }}
							@endif
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
