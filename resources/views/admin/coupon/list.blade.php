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
        
          <form action="{{ route('admin.coupon.postadd') }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="form-control-label" for="input-small">Coupon</label>
                
                  <input id="input-small" name="name" value="{{ old('name') }}" class="form-control form-control-sm" placeholder="Coupon name" type="text">
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
                <label class="form-control-label" for="input-small1">Discount</label>
                
                  <input id="input-small1" name="discount" value="{{ old('discount') }}" class="form-control form-control-sm" placeholder="discount" type="number">
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
  <div class="col-md-8">
                    <div class="text-right">
                    <div class="d-md-inline-block mt-1 align-top">
                    <a  class="u_status_single"href="{{ route('admin.couponexcel.list', 'all' ) }}"> <span class="button btn btn-sm btn-primary mt-0" >Download</span></a>

</div>


  <div class="user-mangement-list">

    <div class="total-entries"><span>{{ $coupon->total() }} Entrie(s)</span></div>
    <div class="data-table">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">Coupon</th>
              <th class="text-center">Discount</th>
              <th class="text-center">Valid_till</th>
              <th class="text-center">Status</th>
              <th class="text-center">No of times redeemed</th>

              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>

            @if(count($coupon))
          @foreach($coupon as $cat)

            <tr>
                  <td>{{ $cat->name }}</td>
                  <td>{{ $cat->discount }}</td>
                  <td>{{ 	date('d/m/Y', $cat->valid_till)  }}</td>

                 

 <td align="center">
                    @if($cat->status == 1)
                  Active
                     
                     @else
                        Deactivate
                        @endif
                      </td>
                      <td><a href="{{ route('admin.couponexcel.list',$cat->id)}}">{{ 	 $cat->redeems_count }}</a></td>

                      <td>
                           @if($cat->status == 1)
                  <a title="Deactivate"   style="outline:none;"  href="javascript:void(0);" class="catstatus" data-id="{{ $cat->id }}" data-status="1">
									<span class="n-ico opt-ico"><i class="icon-not-allowed"></i></span></a>
									
                    @else
                   <a title="Activate"  style="outline:none;" class="catstatus" data-id="{{ $cat->id }}" data-status="0" href="javascript:void(0);" >
                                        <span class="opt-ico activate-ico"><i class="icon-unlocked"></i></span></a>
										
                    @endif
                    <span><a href="{{ route('admin.coupon.getedit', $cat->id) }}"><i class="icon-edit"></i></a></span>
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

       {{$coupon->links("pagination::bootstrap-4")}}

  </div>
</div>
</div>

<script src="{{ URL::asset('admin_assets/js/coupon.js') }}"></script>
 @endsection
