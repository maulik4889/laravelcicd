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
        
          <form action="{{ route('admin.blogs.postadd') }}" method="post" enctype="multipart/form-data">
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
                <label class="form-control-label col-md-3" for="input-small"> Title</label>
                <div class="col-md-4">
                  <!-- <input id="input-small" name="faq_question" value="{{ old('faq_question') }}" class="form-control form-control-sm" placeholder="question" type="text"> -->
                  <textarea   name="title" rows="2" cols="60">{{ old('title') }}</textarea>

                </div>
                
              </div><div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small"> Url Title</label>
                <div class="col-md-4">
                  <!-- <input id="input-small" name="faq_question" value="{{ old('faq_question') }}" class="form-control form-control-sm" placeholder="question" type="text"> -->
                  <textarea    rows="2" cols="60" name="url_title">{{ old('url_title') }}</textarea>

                </div>
                
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small" > Description</label>
                <div class="col-md-10">
                  <!-- <input id="input-small" name="faq_answer" value="{{ old('faq_answer') }}" class="form-control form-control-sm" placeholder="Answer" type="text"> -->
                  <textarea   name="description"   class="form-control form-control-sm" id="summary-ckeditor">{{ old('description') }}</textarea>

                </div>
                
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small"> Image</label>
                <div class="col-md-4">
                  <!-- <input id="input-small" name="faq_answer" value="{{ old('faq_answer') }}" class="form-control form-control-sm" placeholder="Answer" type="text"> -->
<input type="file" name="image">
                </div>
</div>
                <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small"> Meta Tag</label>
                <div class="col-md-4">
                  <!-- <input id="input-small" name="faq_question" value="{{ old('faq_question') }}" class="form-control form-control-sm" placeholder="question" type="text"> -->
                  <textarea   name="tag" rows="2" cols="60">{{ old('tag') }}</textarea>

                </div>
                
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small"> Meta Description</label>
                <div class="col-md-4">
                  <!-- <input id="input-small" name="faq_question" value="{{ old('faq_question') }}" class="form-control form-control-sm" placeholder="question" type="text"> -->
                  <textarea   name="tag_description" rows="2" cols="60">{{ old('tag_description') }}</textarea>

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

    <div class="total-entries"><span>{{ $blogs->total() }} Entrie(s)</span></div>
    <div class="data-table">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">title</th>
              <th class="text-center">description</th>
              <th class="text-center">image</th>

              <th class="text-center">Status</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>

            @if(count($blogs))
                           @foreach($blogs as $cat)

            <tr>
                  <td ><b>{{ $cat->title }}</b></td>
                  <td style="word-wrap: break-word"> {{ \Illuminate\Support\Str::limit($cat->description, 150, '...') }}
</td>
<td ><img src="https://dev.matutto.com/backend/storage/category/{{$cat->image}}"></td>


 <td align="left">
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
                    <span><a href="{{ route('admin.blogs.getedit', $cat->id) }}"><i class="icon-edit"></i></a></span>
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


       {{$blogs->links("pagination::bootstrap-4")}}

  </div>
</div>
</div>

<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'summary-ckeditor' );
</script>
<script src="{{ URL::asset('admin_assets/js/blogs.js') }}"></script>
 @endsection
