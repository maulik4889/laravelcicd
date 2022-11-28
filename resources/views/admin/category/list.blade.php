@extends('admin.index')
@section('content')

<div class="dashboard-content padding-sm">
<ol class="breadcrumb">
   <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
<div class="dashboard-user-mange-section">
  <div class="header-block">
    <div class="row">
      <div class="col-md-12">
        <div class="sort-input-field margin-bottom-2x">
        
          <form action="{{ route('admin.category.postadd') }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
               @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small">Category Name</label>
                <div class="col-md-4">
                  <input id="input-small" name="category" value="{{ old('category') }}" class="form-control form-control-sm" placeholder="category name" type="text">
                   
                </div>
                
              </div>



              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small">Image</label>
                <div class="col-md-4">
                   <input type="file" class="form-control-file" name="image" id="image" aria-describedby="fileHelp">
                   
                </div>
                
              </div>

                   <div class="form-group">
              <button type="submit" class="button btn btn-sm btn-primary">Submit</button>
            </div>
            </form>
         
      </div>
          @if (Session::has('flash_message'))
    <div class="alert alert-{!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message') !!}
    </div>
@endif

		
      <div class="col-md-8">
        <div class="text-right">
           
        </div>
      </div>
    </div>
  </div>



  <div class="user-mangement-list">
  <form action="" method="get" class="form-inline frm-src">{{ csrf_field() }}
                        <div class="form-group"><input id="myInput" type="text" class="form-control" name="name" value="{{ old('name') }}"  placeholder="Search By Name"></div>
                        <button type="submit" name="submit"  class="btn btn-theme" value="By Name">Search</button>
                        <div class="total-entries"><span>{{ $category->total() }} Entrie(s)</span></div>
                        </form>  
    <div class="data-table">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">Name</th>
              <!-- <th class="text-center">Icon</th> -->
              <th class="text-center">Status</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>

            @if(count($category))
                           @foreach($category as $cat)

            <tr>
                  <td>{{ ucfirst($cat->title) }}</td>
                  <!-- <td><img src="{{ $cat->icon }}" height="100px" width="100px"></td> -->
 <td align="center">
                    @if($cat->status == 1)
                  Active
                     
                     @else
                        Deactivate
                        @endif
                      </td>
                     
                      <td>
                           @if($cat->status == 1)
                  <a title="Deactivate"   style="outline:none;"  href="javascript:void(0);" class="catstatus" data-id="{{ $cat->id }}" data-status="1">
									<span class="n-ico opt-ico"><i class="icon-not-allowed"></i></span></a>
									
                    @else
                   <a title="Activate"  style="outline:none;" class="catstatus" data-id="{{ $cat->id }}" data-status="0" href="javascript:void(0);" >
                                        <span class="opt-ico activate-ico"><i class="icon-unlocked"></i></span></a>
										
                    @endif
                    <span><a href="{{ route('admin.category.getedit', $cat->id) }}"><i class="icon-edit"></i></a></span>
                      <!--<span><a class="catdel" href="javascript:void(0);" data-id="{{$cat->id}}" ><i class="fa fa-trash-o text-danger" aria-hidden="true">delete</i></a></span>-->
                    </td>
                  </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="2">No Result(s) Found</td>
                    </tr>
                    @endif

          </tbody>
        </table>
      </div>
    </div>

       {{$category->links("pagination::bootstrap-4")}}

  </div>
</div>
</div>

<script src="{{ URL::asset('admin_assets/js/category.js') }}"></script>
 @endsection
