


@extends('admin.index')
@section('content')

<div class="dashboard-content padding-sm">
<ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="{{ route('admin.coupons.get') }}">Manage Coupons</a></li>
        <li class="breadcrumb-item active">{{ $coupon->name }}</li>
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
       <form action="{{ route('admin.coupon.postedit' , $coupon->id) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
        {{ csrf_field() }}
        
        <div class="form-group row">
                <label class="form-control-label" for="input-small">Coupon</label>
                
                  <input id="input-small" name="name" value="{{ old('name',$coupon->name)}}" class="form-control form-control-sm" placeholder="Coupon name" type="text" >
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
              <div class="form-group row">
                <label class="form-control-label" for="input-small1">Discount</label>
                
                  <input id="input-small1" name="discount" value="{{ old('discount',$coupon->discount) }}" class="form-control form-control-sm" placeholder="discount" type="number">
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
                <label class="form-control-label" for="input-small2">Valid till</label>
                
                  <input id="input-small2" name="valid_till" value="{{ old('valid_till') }}" class="form-control form-control-sm" placeholder="valid_till" type="date">
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
        <button type="submit" class="button btn btn-sm btn-primary">Update</button>
      </form>
      </div>
    </div>
    
  </div>
</div>
</div>

@endsection

