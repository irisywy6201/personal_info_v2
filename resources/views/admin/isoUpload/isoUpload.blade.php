@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center form-inline">
	<h3>檔案上傳管理</h3>
	<br>
</div>
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
			  @foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			  @endforeach
			</ul>
		</div>
    @endif

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
            <span class="glyphicon glyphicon-ok-sign"></span><strong>{{ $message }}</strong>
    </div>

    @endif
	@if ($delete_suc = Session::get('delete_suc'))
    <div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
            <span class="glyphicon glyphicon-ok-sign"></span><strong>{{ $delete_suc }}</strong>
    </div>

    @endif
	
	
    @if ($plz_login=Session::get('plz_login'))
		<?php echo "<script type='text/javascript'>alert('請登入後下載');</script>"; ?>
    @endif

    @if ($error=Session::get('error'))
    <div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
        <span class="glyphicon glyphicon-remove-sign"></span><strong>{{ $error }}</strong>
    </div>
    @endif
	@if ($error2=Session::get('error2'))
    <div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
        <span class="glyphicon glyphicon-remove-sign"></span><strong>{{ $error2 }}</strong>
    </div>

    @endif
	
		<div class="alert alert-success alert-block hide" id="ShowCopy">
				<strong>已複製<p id="CheckCopy"></p></strong>
		</div>
	
	<div class="content">
			<form  action="{{ url('admin/auth_soft/isoUpload') }}" enctype="multipart/form-data" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="row">
					<div class="col-md-2">
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<span class="btn btn-primary btn-file"><span class="fileupload-new"><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;選擇上傳檔案</span>
								<input type="file" name="isofile"/></span>
							<span class="fileupload-preview"></span>
							<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
						</div>
					</div>
					<div class="col-md-5">
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-upload"></span>&nbsp;&nbsp;確認上傳</button>
					</div>
				</div>
			</form>
		</div><br>

	<table class="table table-hover table-condensed">
        <tr>
            <th>名稱</th>
            <th>最後更改日期</th>
            <th>下載連結</th>
            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;修改/刪除</th>
        </tr>
		<tbody>  
		@foreach($file as $file)
            <tr>
                <td>{{$file->file_title}}</td>
                <td>{{$file->updated_at}}</td>
                <td><p id="copy{{$file->id}}">http://{{$test}}/download/{{$file->file_title}}/{{$file->id}}/</p>
					<button class="btn btn-primary btn-sm" type="button" onclick="copyToClipboard('#copy{{$file->id}}','{{$file->file_title}}')">
					<i style="font-size:12px" class="fa">&#xf0c5;</i>&nbsp;複製
					</button>
				</td>
                <td>
					<div class="col-sm-3">
                        <form class="" action="{{ url('admin/auth_soft/isoUpload/'.$file->id.'/edit') }}" method="get">
                            <button type="summit" class="btn btn-success btn-sm">
                                <span class="glyphicon glyphicon-pencil"></span>
                             </button>
                        </form>&nbsp;&nbsp;&nbsp;
					</div>
					<div class="col-sm-3">
                        <form class="" action="{{ url('admin/auth_soft/isoUpload/'.$file->id) }}" method="post">
							{!! csrf_field() !!}
							{!! method_field('DELETE') !!}
							<button type="summit" class="btn btn-danger btn-sm">
								<span class="glyphicon glyphicon-trash"></span>
							</button>
                        </form>
					</div>
                </td>
            </tr>
		@endforeach
        </tbody>
    </table>					  
              
        
<script>
	
	!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
	/*$(document).ready(function(){
		$("#ShowCopy").hide();

	});*/
	function copyToClipboard(element,title) {
		var $temp = $("<input>");
		$("body").append($temp);
		
		$("#ShowCopy").removeClass("hide");
		$("#CheckCopy").text(title+'的下載連結 :　'+$(element).text());
		$temp.val($(element).text()).select();
		document.execCommand("copy");
		$temp.remove();
	}
	
	
</script>
@stop