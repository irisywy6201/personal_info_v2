<div class="tab-content">
<div class="tab-pane fade  active in" id="1">
<table class="table table-striped table-hover table-responsive">
    <tbody>
		<input  type="hidden"  name="{{$a=100}}" />
      @foreach($software_category as $software)
	  <tr>
	    <td>
			  <a  href="#{{$a}}" data-toggle="tab" class="listen" style="text-decoration:none;font-size:20px">
				<strong>{{ $software->category_zh }}</strong><br><br>
			  </a>	
	    </td>
	  </tr>
	  <input  type="hidden"  name="{{$a=$a+1}}" />
	  @endforeach
	</tbody>
</table>
</div>
<input  type="hidden"  name="{{$b=100}}" />
 @foreach($software_category as $software)
	<div class="tab-pane fade" id="{{$b}}">
		<table class="table table-striped table-hover table-responsive">
		  <tbody>
			
		  <tr>
			<td>
			  <a href="#{{$test['index']}}" data-toggle="tab" class="listen">
				{{ $software->category_zh }}
			  </a>
			</td>
		  </tr>
		<input  type="hidden"  name="{{$b=$b+1}}" />	
		  </tbody>
		</table>
	  </div>
@endforeach
@if(Auth::check() && Auth::user()->isStaff())  
    <a href="{{url('auth_soft/create_category')}}" class="btn btn-info btn-lg">
        <span class="glyphicon glyphicon-plus"></span>新增
    </a>
@endif

</div>