


@extends('admin.index')
@section('content')

<div class="dashboard-content padding-sm">
<ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="{{ route('admin.pages.get') }}">Manage pages</a></li>
          <li class="breadcrumb-item active">{{ $pages->name }}</li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
<div class="dashboard-user-mange-section">
  <div class="header-block">
    <div class="row">
      <div class="col-md-2">
        
          @if (Session::has('flash_message'))
    <div class="alert alert-{!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message') !!}
    </div>
@endif

		
      <div class="col-md-10">
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
   
       <form action="{{ route('admin.pages.postedit' , $pages->id) }}" method="post" class="form-horizontal">
                                  {{ csrf_field() }}
                                                                        <div class="form-group row">
                                                                            <!--<label class="col-sm-3 form-control-label" for="input-small">Page Name</label>-->
                                                                            <div class="col-md-9">
                                                                                   <input id="input-small" readonly name="name" class="form-control form-control-sm" placeholder="page name" type="hidden" value="{{ old('name',$pages->meta_key) }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-3 form-control-label" for="input-small">Page Content</label>
                                                                            <div class="col-md-9">
                                                                                <textarea id="summary-ckeditor" name="content">{{ old('content',$pages->meta_value) }}</textarea>
                                                                            </div>
                                                                        </div>

                                                                      <button type="submit" class="btn btn-sm btn-primary button">Update</button>
                                                                    </form>
     
    </div>
    
  </div>
</div>
</div>

<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'summary-ckeditor' );
</script>
@endsection


