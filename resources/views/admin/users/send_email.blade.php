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
        
          <form action="{{ route('admin.email.post') }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="form-control-label" for="input-small">Receiver Name</label>
                
                  <input id="input-small" name="name" value="{{ old('name') }}" class="form-control form-control-sm" placeholder="skill name" type="text">
                    @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
                
              </div>
              <div class="form-group">
                <label class="form-control-label" for="input-small">Receiver Email</label>
                <input id="input-small" name="email" value="{{ old('email') }}" class="form-control form-control-sm" placeholder="email" type="text">

              </div>
              <div class="form-group">
                <label class="form-control-label" for="input-small">Receiver Email</label>
                <textarea  name="message" class="form-control form-control-sm" placeholder="message" >{{ old('message') }}
                </textarea>

              </div>
                     
              <button type="submit" class="button btn btn-sm btn-primary">Submit</button>
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




 @endsection
