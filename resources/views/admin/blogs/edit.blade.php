


@extends('admin.index')
@section('content')

<div class="dashboard-content padding-sm">
<ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="{{ route('admin.faq.get') }}">Manage Blogs</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
<div class="dashboard-user-mange-section">
  <div class="header-block">
    <div class="row">
      <div class="col-md-4">
        
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

      @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
    <div class="data-table">
      <div class="">
       <form action="{{ route('admin.blogs.postedit' , $blog->id) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
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
                  <textarea   name="title" rows="2" cols="60">{{ old('title',$blog->title) }}</textarea>

                </div>
                
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small"> Url Title</label>
                <div class="col-md-4">
                  <!-- <input id="input-small" name="faq_question" value="{{ old('faq_question') }}" class="form-control form-control-sm" placeholder="question" type="text"> -->
                  <textarea   name="url_title" rows="2" cols="60">{{ old('url_title',$blog->url_title) }}</textarea>

                </div>
                
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small"> Description</label>
                <div class="col-md-10">
                  <!-- <input id="input-small" name="faq_answer" value="{{ old('faq_answer') }}" class="form-control form-control-sm" placeholder="Answer" type="text"> -->
                  <textarea   name="description" id="summary-ckeditor">{{ old('description',$blog->description) }}</textarea>

                </div>
                
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small"> Meta Tag</label>
                <div class="col-md-4">
                  <!-- <input id="input-small" name="faq_question" value="{{ old('faq_question') }}" class="form-control form-control-sm" placeholder="question" type="text"> -->
                  <textarea   name="tag" rows="2" cols="60">{{ old('tag', $blog->tag) }}</textarea>

                </div>
                
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small"> Meta Description</label>
                <div class="col-md-4">
                  <!-- <input id="input-small" name="faq_question" value="{{ old('faq_question') }}" class="form-control form-control-sm" placeholder="question" type="text"> -->
                  <textarea   name="tag_description" rows="2" cols="60">{{ old('tag_description,$blog->tag_description') }}</textarea>

                </div>
                
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3" for="input-small"> Image</label>
                <div class="col-md-4">
                  <!-- <input id="input-small" name="faq_answer" value="{{ old('faq_answer') }}" class="form-control form-control-sm" placeholder="Answer" type="text"> -->
<input type="file" name="image">
                </div>
                
              </div>

                   <div class="form-group">
              <button type="submit" class="button btn btn-sm btn-primary">Submit</button>
            </div>
            </form>
      </div>
    </div>
    
  </div>
</div>
</div>

<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'summary-ckeditor' );
</script>
@endsection

