@extends('admin.index')
@section('content')


<div class="dashboard-content padding-sm">

    <div class="dashboard-user-mange-section">




        <div class="user-mangement-list">

        @if (Session::has('flash_message'))
            <div class="alert alert-{!! Session::get('flash_level') !!}">
                {!! Session::get('flash_message') !!}
            </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <a  class=" float-right mb-5"href="{{ route('admin.getdownload',  collect(request()->segments())->last()) }}"> <span class="button btn btn-sm btn-primary mt-0" >Download</span></a>
        <br>

        <select onchange="location = this.value;" class="float-right mb-5">
        <option  value="">Select filter</option>

<option  value="{{route('users.filter','GOOGLE')}}">Filter Users By Google</option>
        <option value="{{route('users.filter','FACEBOOK')}}">Filter Users By Facebook</option>
    </select>

        <form action="" method="get" class="form-inline frm-src">{{ csrf_field() }}
                        <div class="form-group"><input id="myInput" type="text" class="form-control" name="name" value="{{ old('name') }}"  placeholder="Search By Name"></div>
                        <button type="submit" name="submit"  class="btn btn-theme" value="By Name">Search</button>
						<div class="total-entries"><span>{{ $users->total() }} Entrie(s)</span></div>
                        </form>
            <!-- <div class="total-entries"><span>{{ $users->total() }} Entrie(s)</span></div> -->
            <div class="data-table">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                                                <th class="text-center">SignUp Type</th>

                                <th class="text-center">Joined Date <br/><span>(DD/MM/YYYY)</span></th>
                                <!-- <th class="text-center">Average time spent on site</th> -->
                                <th class="text-center">Status</th>
                                <th class="text-center">Last Login</th>

                                <th class="text-center">Actions</th>
                                <th class="text-center">Hide Profile</th>
                                <th class="text-center">Featured Host</th>

                            </tr>
                        </thead>
                        <tbody>

                            @if(count($users))
                            @foreach($users as $a=>$user)

                            <tr>
                                <td class="text-center">{{ ucfirst($user->name) }} </td>
                                <td class="text-center">xxxx@gmail.com</td>
                                <td class="text-center">{{ 	date('d/m/Y', $user->created_at)  }}</td>
                                <!-- <td class="text-center">0</td> -->
                                <td class="text-center">{{ 	$user->signup_type}}</td>

                                <td align="center">
                                    @if($user->status == 1)
                                    Active
                                    @elseif($user->status == 2)
                                    Deactive
                                    @else
                                    Un-verified
                                    @endif
                                </td>
                                <td class="text-center">{{ 	date('d/m/Y', $user->updated_at)  }}</td>

                                <td align="center">


                                     <a title="Delete User"  style="outline:none;" class=""data-target="#modal-delete1-{{ $user->id }}"  data-status="1" data-toggle="modal" href="javascript:void(0);" >
                                        <span class="opt-ico activate-ico">
                                            <i class="icon-delete"></i>

                                        </span>
                                     </a>
                                    @if($user->status == 1)
                                    <a title="Deactivate"   style="outline:none;"  href="javascript:void(0);" class="userstatus" data-id="{{ $user->id }}" data-status="2">
                                        <span class="n-ico opt-ico"><i class="icon-not-allowed"></i></span></a>

                                    @elseif($user->status == 2)
                                    <a title="Activate"  style="outline:none;" class="userstatus" data-id="{{ $user->id }}" data-status="1" href="javascript:void(0);" >
                                        <span class="opt-ico activate-ico"><i class="icon-unlocked"></i></span></a>

                                    @else

                                    @endif

                                    <a title="View" class="view-ico opt-ico"  data-toggle="modal" data-target="#modal-delete-{{ $user->id }}">

                                    <!-- <a title="View" class="view-ico opt-ico" href ="" data-toggle="modal" data-target="#loginModal"> -->
                                <i class="icon-eye"></i></a>

                                  </td>
<td>
    @if($user->hide_profile==1)
                                  <a  class="u_status_single1"href="{{ route('admin.hideprofile', $user->id) }}"> <span class="button btn btn-sm btn-primary mt-0" >Enable</span></a>
                                  @else

                                  <a  class="u_status_single1"href="{{ route('admin.hideprofile', $user->id) }}"> <span class="button btn btn-sm btn-primary mt-0" >Disable</span></a>
                                  @endif

                                 
</td>
<td>
@if($user->featured_count==1)
                                  <a  class="u_status_single1" href="{{ route('admin.removeFromFeatured', $user->id) }}"> <span class="buttonn btn btn-sm btn-primary mt-0" style="width:200px">Remove From Featured</span></a>
                                  @else

                                  <a  class="u_status_single1"  data-toggle="modal" data-target="#modal-featured-{{ $user->id }}"> <span class="buttonn btn btn-sm btn-primary mt-0"  style="width:200px">Mark as Featured</span></a>
                                  @endif
</td>
                            </tr>


                            <div class="modal fade" id="modal-featured-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModal">Add Subject Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            @if (Session::has('flash_message'))
            <div class="alert alert-{!! Session::get('flash_level') !!}">
                {!! Session::get('flash_message') !!}
            </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
                <form method="POST" action="{{ route('admin.markAsFeatured') }}" method="post" enctype="multipart/form-data">
                    @csrf



                    <div class="form-group row">
                        <label for="subject" class="col-md-4 col-form-label text-md-right">Subject</label>

                        <div class="col-md-6">
                            <input id="subject" type="text" name="subject_name" required >
                            <input  type="hidden" name="user_id"   value="{{$users[$a]->id}}">



                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




                            <div class="modal fade" id="modal-delete-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModal">Please enter password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            @if (Session::has('flash_message'))
            <div class="alert alert-{!! Session::get('flash_level') !!}">
                {!! Session::get('flash_message') !!}
            </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
                <form method="POST" action="{{ route('admin.confirmPassword') }}" method="post" enctype="multipart/form-data">
                    @csrf



                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password"name="password" required autocomplete="current-password">
                            <input  type="hidden"name="id" required autocomplete="current-password" value="{{$users[$a]->id}}">



                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







<div class="modal fade" id="modal-delete1-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModal">Please enter password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            @if (Session::has('flash_message'))
            <div class="alert alert-{!! Session::get('flash_level') !!}">
                {!! Session::get('flash_message') !!}
            </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
                <form method="POST" action="{{ route('admin.confirmPasswordForDelete') }}" method="post" enctype="multipart/form-data">
                    @csrf



                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password"name="password" required autocomplete="current-password">
                            <input  type="hidden"name="id" required autocomplete="current-password" value="{{$users[$a]->id}}">



                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="15">No Result(s) Found</td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>


                {{$users->links("pagination::bootstrap-4")}}


        </div>
    </div>
</div>








<script src="{{ URL::asset('admin_assets/js/users.js') }}"></script>
@endsection
