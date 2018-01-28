@extends("admin.adminLayout")
@section("modifyContent")
  <div class="row text-center">
    <h3>{{ $title }}</h3>
  </div>
@if(Session::has('tab'))
  <?php
    $tab = Session::get('tab');
  ?>
@endif
@if(Session::has('visibility-toggle'))
  <?php
    $visToggle = Session::get('visibility-toggle');
  ?>
@else
  <?php
    $visToggle = true;
  ?>
@endif
  <div class="navbar" role="navigation">
    <div class="container-fluid">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="{{ !empty($tab) && $tab == 'category' ? 'active in' : '' }}">
          <a href="#category" aria-controls="category" role="tab" data-toggle="tab">
            <h4>{{ Lang::get('Admin/SdCategory.sdCategory') }}</h4>
          </a>
        </li>
        <li role="presentation" class="{{ !empty($tab) && $tab == 'userCategory' ? 'active in' : '' }}">
          <a href="#userCategory" aria-controls="userCategory" role="tab" data-toggle="tab">
            <h4>{{ Lang::get('Admin/SdCategory.userCategory') }}</h4>
          </a>
        </li>
        <li role="presentation" class="{{ !empty($tab) && $tab == 'solutionCategory' ? 'active in' : '' }}">
          <a href="#solutionCategory" aria-controls="solutionCategory" role="tab" data-toggle="tab">
            <h4>{{ Lang::get('Admin/SdCategory.solutionCategory') }}</h4>
          </a>
        </li>
      </ul>

      <!-- tab container -->
      <div class="tab-content">
        <!-- category -->
        <div role="tabpanel" class="tab-pane fade {{ !empty($tab) && $tab == 'category' ? 'active in' : '' }}" id="category">
          <div class="navbar-right">
            <!-- <a class="btn navbar-btn btn-primary" href="{{ URL::to('admin/sdCategory/createCategory') }}"> -->
            <label class="checkbox-inline">
              <input id="visibility-toggle1" type="checkbox" {{$visToggle ? 'checked' : ''}} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-eye'> <b>顯示隱藏分類</b></i>" data-off="<i class='fa fa-eye-slash'> <b>隱藏分類</b></i>" data-width="140">
            </label>
            <a class="btn navbar-btn btn-primary" data-toggle="modal" data-target="#createCategory">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              {{ Lang::get('Admin/SdCategory.createCategory') }}
            </a>
          </div>
          <table class="table table-hover table-responsive">
            <thead>
              <tr>
                <th class="hidden-xs">#</th>
                <th class="th-department">{{ Lang::get('sdRecord/board.department')}}</th>
                <th class="hidden-xs th-category">{{ Lang::get('sdRecord/board.category')}}</th>
                <th class="hidden-xs th-category">{{ Lang::get('Admin/SdCategory.status')}}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($category as $key => $value)
              <tr class="{{$value->visible == 0 ? 'admin-invisible' : ''}}">
                  <td>{{ $key+1 }}</td>
                  @foreach($department as $d_key => $d_value)
                    @if($value->parent_id == $d_value->id)
                      <td>{{ $d_value->name }}</td>
                    @endif
                  @endforeach
                  <td>{{ $value->name }}</td>
                  @if($value->visible == 1)
                    <td>
                      <a href="{{ URL::to('admin/sdCategory/setCatInVisible/'.$value->id) }}">
                        <p class="text-success lead">
                          <span class="glyphicon glyphicon-ok-circle"></span>
                        </p>
                      </a>
                    </td>
                  @else
                    <td>
                      <a href="{{ URL::to('admin/sdCategory/setCatVisible/'.$value->id) }}">
                        <p class="text-muted lead">
                          <span class="glyphicon glyphicon-ban-circle"></span>
                        </p>
                      </a>
                    </td>
                  @endif
                  <td>
                    <div class="btn-group navbar-right" role="group">
                      <!-- <a class="btn btn-primary" href="{{ URL::to('') }}"> -->
                      <a class="btn btn-primary {{$value->visible == 0 ? 'disabled' : ''}}" data-toggle="modal" data-target="#updateCategory" data-value="{{ $value }}">
                      <!-- <a class="btn btn-default" href="{{ URL::to('/deskRecord/detail') }}"> -->
                        <span class="fa fa-pencil"></span>
                        <!-- {{Lang:: get('sdRecord/board.detail')}} -->
                      </a>
                      @if($value->visible == 1)
                        <a class="btn btn-success hidden-xs" href="{{ URL::to('admin/sdCategory/setCatInVisible/'.$value->id) }}">
                          <span class="fa fa-eye"></span>
                          <!-- {{Lang:: get('sdRecord/board.edit')}} -->
                        </a>
                      @else
                        <a class="btn btn-default hidden-xs" href="{{ URL::to('admin/sdCategory/setCatVisible/'.$value->id) }}">
                          <span class="fa fa-eye-slash"></span>
                          <!-- {{Lang:: get('sdRecord/board.edit')}} -->
                        </a>
                      @endif
                    </div>
                  </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- user category -->
        <div role="tabpanel" class="tab-pane fade {{ !empty($tab) && $tab == 'userCategory' ? 'active in' : '' }}" id="userCategory">
          <div class="navbar-right">
            <!-- <a class="btn navbar-btn btn-primary" href="{{ URL::to('admin/sdCategory/createUserCategory') }}"> -->
            <label class="checkbox-inline">
              <input id="visibility-toggle2" type="checkbox" {{$visToggle ? 'checked' : ''}} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-eye'> <b>顯示隱藏分類</b></i>" data-off="<i class='fa fa-eye-slash'> <b>隱藏分類</b></i>" data-width="140">
            </label>
            <a class="btn navbar-btn btn-primary" data-toggle="modal" data-target="#createUserCategory">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              {{ Lang::get('Admin/SdCategory.createCategory') }}
            </a>
          </div>
          <table class="table table-hover table-responsive">
            <thead>
              <tr>
                <th class="hidden-xs">#</th>
                <th class="hidden-xs th-askerID">{{ Lang::get('sdRecord/board.askerID')}}</th>
                <th class="hidden-xs th-category">{{ Lang::get('Admin/SdCategory.status')}}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($user_category as $key => $value )
                <tr class="{{$value->visible == 0 ? 'admin-invisible' : ''}}">
                  <td>{{ $key+1 }}</td>
                  <td>{{ $value->user }}</td>
                  @if($value->visible == 1)
                    <td>
                      <a href="{{ URL::to('admin/sdCategory/setCatUserInVisible/'.$value->id) }}">
                        <p class="text-success lead">
                          <span class="glyphicon glyphicon-ok-circle"></span>
                        </p>
                      </a>
                    </td>
                  @else
                    <td>
                      <a href="{{ URL::to('admin/sdCategory/setCatUserVisible/'.$value->id) }}">
                        <p class="text-muted lead">
                          <span class="glyphicon glyphicon-ban-circle"></span>
                        </p>
                      </a>
                    </td>
                  @endif
                  <td>
                    <div class="btn-group navbar-right" role="group">
                      <!-- <a class="btn btn-primary" href="{{ URL::to('') }}"> -->
                      <a class="btn btn-primary {{$value->visible == 0 ? 'disabled' : ''}}" data-toggle="modal" data-target="#updateUserCategory" data-value="{{ $value }}">
                      <!-- <a class="btn btn-default" href="{{ URL::to('/deskRecord/detail') }}"> -->
                        <span class="fa fa-pencil"></span>
                        <!-- {{Lang:: get('sdRecord/board.detail')}} -->
                      </a>
                      @if($value->visible == 1)
                        <a class="btn btn-success hidden-xs" href="{{ URL::to('admin/sdCategory/setCatUserInVisible/'.$value->id) }}">
                          <span class="fa fa-eye"></span>
                          <!-- {{Lang:: get('sdRecord/board.edit')}} -->
                        </a>
                      @else
                        <a class="btn btn-default hidden-xs" href="{{ URL::to('admin/sdCategory/setCatUserVisible/'.$value->id) }}">
                          <span class="fa fa-eye-slash"></span>
                          <!-- {{Lang:: get('sdRecord/board.edit')}} -->
                        </a>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- solution category -->
        <div role="tabpanel" class="tab-pane fade {{ !empty($tab) && $tab == 'solutionCategory' ? 'active in' : '' }}" id="solutionCategory">
          <div class="navbar-right">
            <!-- <a class="btn navbar-btn btn-primary" href="{{ URL::to('admin/sdCategory/createSolCategory') }}"> -->
            <label class="checkbox-inline">
              <input id="visibility-toggle3" type="checkbox" {{$visToggle ? 'checked' : ''}} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-eye'> <b>顯示隱藏方法</b></i>" data-off="<i class='fa fa-eye-slash'> <b>隱藏方法</b></i>" data-width="140">
            </label>
            <a class="btn navbar-btn btn-primary" data-toggle="modal" data-target="#createSolution">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              {{ Lang::get('Admin/SdCategory.createMethod') }}
            </a>
          </div>
          <table class="table table-hover table-responsive">
            <thead>
              <tr>
                <th class="hidden-xs">#</th>
                <th class="hidden-xs th-solution">{{ Lang::get('sdRecord/board.solution')}}</th>
                <th class="hidden-xs th-category">{{ Lang::get('Admin/SdCategory.status')}}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($solutionCategory as $key => $value)
                <tr class="{{$value->visible == 0 ? 'admin-invisible' : ''}}">
                  <td>{{ $key+1 }}</td>
                  <td>{{ $value->method }}</td>
                  @if($value->visible == 1)
                    <td>
                      <a href="{{ URL::to('admin/sdCategory/setSolInVisible/'.$value->id) }}">
                        <p class="text-success lead">
                          <span class="glyphicon glyphicon-ok-circle"></span>
                        </p>
                      </a>
                    </td>
                  @else
                    <td>
                      <a href="{{ URL::to('admin/sdCategory/setSolVisible/'.$value->id) }}">
                        <p class="text-muted lead ">
                          <span class="glyphicon glyphicon-ban-circle"></span>
                        </p>
                      </a>
                    </td>
                  @endif
                  <td>
                    <div class="btn-group navbar-right" role="group">
                      <!-- <a class="btn btn-primary" href="{{ URL::to('') }}"> -->
                      <a class="btn btn-primary {{$value->visible == 0 ? 'disabled' : ''}}" data-toggle="modal" data-target="#updateSolCategory" data-value="{{ $value }}">
                      <!-- <a class="btn btn-default" href="{{ URL::to('/deskRecord/detail') }}"> -->
                        <span class="fa fa-pencil"></span>
                        <!-- {{Lang:: get('sdRecord/board.detail')}} -->
                      </a>
                      @if($value->visible == 1)
                        <a class="btn btn-success hidden-xs" href="{{ URL::to('admin/sdCategory/setSolInVisible/'.$value->id) }}">
                          <span class="fa fa-eye"></span>
                          <!-- {{Lang:: get('sdRecord/board.edit')}} -->
                        </a>
                      @else
                        <a class="btn btn-default hidden-xs" href="{{ URL::to('admin/sdCategory/setSolVisible/'.$value->id) }}">
                          <span class="fa fa-eye-slash"></span>
                          <!-- {{Lang:: get('sdRecord/board.edit')}} -->
                        </a>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- create category modal -->
  <div class="modal fade" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="createCategoryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="modal-title" id="createCategoryLabel">{{ Lang::get('Admin/SdCategory.createCategory') }}</h4>
          <br>
          <div>
            {!! Form::open(['url' => '/admin/sdCategory/saveCategory', 'files'=> true, 'method'=>'post', 'class'=>'orm-horizontal'])!!}
            <fieldset>
              <div class="form-group @if($errors->has('category')) has-error @endif">
                <label for="adminCategory">
                  <span class="must-fill">*</span>
                  {{ Lang::get('Admin/SdCategory.categoryName') }}
                </label>
                <label class="label label-pill label-danger adminCategory">
                  <span class="glyphicon glyphicon-info-sign"></span>
                  此項不可留白且不可以空格開頭
                </label>
                <input class="form-control" id="adminCategory" name="category" type="text" value="{{ Input::old('category','') }}">
                <label class="control-label has-error" for="adminCategory">
                  @if($errors->has('category'))
                    &nbsp&nbsp&nbsp
                    <span class="glyphicon glyphicon-info-sign"></span>
                    {{ $errors->first('category') }}
                  @endif
                </label>

              </div>
              <div class="form-group text-center">
                <button class="btn btn-lg btn-success adminCategory" type="submit" value="submit">
                  <span class="glyphicon glyphicon-floppy-disk"></span>
                  {{ Lang::get('sdRecord/board.save') }}
                </button>
              </div>
            </fieldset>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- create user category modal -->
  <div class="modal fade" id="createUserCategory" tabindex="-1" role="dialog" aria-labelledby="createUserCategoryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="modal-title" id="createUserCategoryLabel">{{ Lang::get('Admin/SdCategory.createCategory') }}</h4>
          <br>
          <div>
            {!! Form::open(['url' => '/admin/sdCategory/saveUserCategory', 'files'=> true, 'method'=>'post', 'class'=>'orm-horizontal'])!!}
            <fieldset>
              <div class="form-group @if($errors->has('user_category')) has-error @endif">
                <label for="adminUserCategory">
                  <span class="must-fill">*</span>
                  {{ Lang::get('Admin/SdCategory.categoryUser') }}
                </label>
                <label class="label label-pill label-danger adminUserCategory">
                  <span class="glyphicon glyphicon-info-sign"></span>
                  此項不可留白且不可以空格開頭
                </label>
                <input class="form-control" id="adminUserCategory" name="user_category" type="text" value="{{ Input::old('user_category','') }}">
                <label class="control-label has-error" for="adminUserCategory">
                  @if($errors->has('user_category'))
                    &nbsp&nbsp&nbsp
                    <span class="glyphicon glyphicon-info-sign"></span>
                    {{ $errors->first('user_category') }}
                  @endif
                </label>
              </div>
              <div class="form-group text-center">
                <button class="btn btn-lg btn-success adminUserCategory" type="submit" value="submit">
                  <span class="glyphicon glyphicon-floppy-disk"></span>
                  {{ Lang::get('sdRecord/board.save') }}
                </button>
              </div>
            </fieldset>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- create solution modal -->
  <div class="modal fade" id="createSolution" tabindex="-1" role="dialog" aria-labelledby="createSolutionLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="modal-title" id="createSolutionLabel">{{ Lang::get('Admin/SdCategory.createMethod') }}</h4>
          <br>
          <div>
            {!! Form::open(['url' => '/admin/sdCategory/saveSolCategory', 'files'=> true, 'method'=>'post', 'class'=>'orm-horizontal'])!!}
            <fieldset>
              <div class="form-group @if($errors->has('solution')) has-error @endif">
                <label for="adminSolCategory">
                  <span class="must-fill">*</span>
                  {{ Lang::get('Admin/SdCategory.categorySol') }}
                </label>
                <label class="label label-pill label-danger adminSolCategory">
                  <span class="glyphicon glyphicon-info-sign"></span>
                  此項不可留白且不可以空格開頭
                </label>
                <input class="form-control" id="adminSolCategory" name="solution" type="text" value="{{ Input::old('solution','') }}">
                <label class="control-label has-error" for="adminSolCategory">
                  @if($errors->has('solution'))
                    &nbsp&nbsp&nbsp
                    <span class="glyphicon glyphicon-info-sign"></span>
                    {{ $errors->first('solution') }}
                  @endif
                </label>
              </div>
              <div class="form-group text-center">
                <button class="btn btn-lg btn-success adminSolCategory" type="submit" value="submit">
                  <span class="glyphicon glyphicon-floppy-disk"></span>
                  {{ Lang::get('sdRecord/board.save') }}
                </button>
              </div>
            </fieldset>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- update category modal -->
  <div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-labelledby="updateCategoryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="modal-title" id="updateCategoryLabel">{{ Lang::get('Admin/SdCategory.editCategory') }}</h4>
          <br>
          <div>
            {!! Form::open(['id' => 'updateCategoryForm', 'url' => '/admin/sdCategory/updateCategory', 'files'=> true, 'method'=>'post', 'class'=>'orm-horizontal'])!!}
            <fieldset>
              <div class="form-group @if($errors->has('updateCategory')) has-error @endif">
                <label for="adminUpdateCategory">
                  <span class="must-fill">*</span>
                  {{ Lang::get('Admin/SdCategory.categoryName') }}
                </label>
                <label class="label label-pill label-danger adminUpdateCategory">
                  <span class="glyphicon glyphicon-info-sign"></span>
                  此項不可留白且不可以空格開頭
                </label>
                <input class="form-control" id="adminUpdateCategory" name="updateCategory" type="text" value="{{ Input::old('updateCategory','Empty') }}">
                <label class="control-label has-error" for="adminUpdateCategory">
                  @if($errors->has('updateCategory'))
                    &nbsp&nbsp&nbsp
                    <span class="glyphicon glyphicon-info-sign"></span>
                    {{ $errors->first('updateCategory') }}
                  @endif
                </label>
              </div>
              <div class="form-group text-center">
                <button class="btn btn-lg btn-success adminUpdateCategory" type="submit" value="submit">
                  <span class="glyphicon glyphicon-floppy-disk"></span>
                  {{ Lang::get('sdRecord/board.save') }}
                </button>
              </div>
            </fieldset>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- update user category modal -->
  <div class="modal fade" id="updateUserCategory" tabindex="-1" role="dialog" aria-labelledby="updateUserCategoryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="modal-title" id="updateUserCategoryLabel">{{ Lang::get('Admin/SdCategory.editCategory') }}</h4>
          <br>
          <div>
            {!! Form::open(['id' => 'updateUserCategoryForm', 'url' => '/admin/sdCategory/updateUserCategory', 'files'=> true, 'method'=>'post', 'class'=>'orm-horizontal'])!!}
            <fieldset>
              <div class="form-group @if($errors->has('updateUserCategory')) has-error @endif">
                <label for="adminUpdateUserCategory">
                  <span class="must-fill">*</span>
                  {{ Lang::get('Admin/SdCategory.categoryUser') }}
                </label>
                <label class="label label-pill label-danger adminUpdateUserCategory">
                  <span class="glyphicon glyphicon-info-sign"></span>
                  此項不可留白且不可以空格開頭
                </label>
                <input class="form-control" id="adminUpdateUserCategory" name="updateUserCategory" type="text" value="{{ Input::old('updateUserCategory','Empty') }}">
                <label class="control-label has-error" for="adminUpdateUserCategory">
                  @if($errors->has('updateUserCategory'))
                    &nbsp&nbsp&nbsp
                    <span class="glyphicon glyphicon-info-sign"></span>
                    {{ $errors->first('updateUserCategory') }}
                  @endif
                </label>
              </div>
              <div class="form-group text-center">
                <button class="btn btn-lg btn-success adminUpdateUserCategory" type="submit" value="submit">
                  <span class="glyphicon glyphicon-floppy-disk"></span>
                  {{ Lang::get('sdRecord/board.save') }}
                </button>
              </div>
            </fieldset>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- update solution category modal -->
  <div class="modal fade" id="updateSolCategory" tabindex="-1" role="dialog" aria-labelledby="updateSolCategoryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="modal-title" id="updateSolCategoryLabel">{{ Lang::get('Admin/SdCategory.editMethod') }}</h4>
          <br>
          <div>
            {!! Form::open(['id' => 'updateSolCategoryForm', 'url' => '/admin/sdCategory/updateSolCategory', 'files'=> true, 'method'=>'post', 'class'=>'orm-horizontal'])!!}
            <fieldset>
              <div class="form-group @if($errors->has('updateSolCategory')) has-error @endif">
                <label for="adminUpdateSolCategory">
                  <span class="must-fill">*</span>
                  {{ Lang::get('Admin/SdCategory.categorySol') }}
                </label>
                <label class="label label-pill label-danger adminUpdateSolCategory">
                  <span class="glyphicon glyphicon-info-sign"></span>
                  此項不可留白且不可以空格開頭
                </label>
                <input class="form-control" id="adminUpdateSolCategory" name="updateSolCategory" type="text" value="{{ Input::old('updateSolCategory','Empty') }}">
                <label class="control-label has-error" for="adminUpdateSolCategory">
                  @if($errors->has('updateSolCategory'))
                    &nbsp&nbsp&nbsp
                    <span class="glyphicon glyphicon-info-sign"></span>
                    {{ $errors->first('updateSolCategory') }}
                  @endif
                </label>
              </div>
              <div class="form-group text-center">
                <button class="btn btn-lg btn-success adminUpdateSolCategory" type="submit" value="submit">
                  <span class="glyphicon glyphicon-floppy-disk"></span>
                  {{ Lang::get('sdRecord/board.save') }}
                </button>
              </div>
            </fieldset>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
{!! HTML::script('js/sdRecord/adminEditCategory.js') !!}
@stop
