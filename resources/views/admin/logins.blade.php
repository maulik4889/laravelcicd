@extends('admin.index')
@section('content')


<div class="dashboard-content padding-sm">

    <div class="dashboard-user-mange-section">
        <div class="header-block">
            <div class="row">
                <div class="col-md-4">
                    <div class="sort-input-field margin-bottom-2x">
                    @if( collect(request()->segments())->last()  !='weekly')                    <select onchange="location = this.value;" class="float-right mb-5">
        <option  value="">Select filter</option>

<option  value="{{ route('admin.logins','1') }}"> January</option>
        <option value="{{ route('admin.logins',2)}}">Febuary</option>
        <option  value="{{ route('admin.logins',3) }}">March</option>
        <option value="{{ route('admin.logins', 4 )}}">April</option>
        <option  value="{{ route('admin.logins', 5 )}}">May</option>
        <option value="{{ route('admin.logins', 6 )}}">June</option>
        <option  value="{{ route('admin.logins',7 )}}">July</option>
        <option value="{{ route('admin.logins', 8)}}">August</option>
        <option  value="{{ route('admin.logins', 9) }}">September</option>
        <option value="{{ route('admin.logins', 10 ) }}">October</option>
        <option  value="{{ route('admin.logins', 11) }}">November</option>
        <option value="{{ route('admin.logins', 12) }}">December</option>
    </select>
    @endif
                    </div>
                </div>



                <div class="col-md-8">
                    <div class="text-right">
                    <div class="d-md-inline-block mt-1 align-top">
                    <a  class="u_status_single"href="{{ route('admin.dailylogins', collect(request()->segments())->last() ) }}"> <span class="button btn btn-sm btn-primary mt-0" >Download</span></a>

</div>
                    </div>
                </div>
            </div>
        </div>

  

        <div class="user-mangement-list">
            <div class="total-entries"><span>{{ $logins->total() }} Entrie(s)</span></div>
            <div class="data-table">
                <div class="table-responsive">
                    <table class="table table-bordered">

                   
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Role</span></th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Gender</th>

                                <th class="text-center">Status</th>

                                <th class="text-center">Joined Date</th>
                             

                                <th class="text-center">Last Login</th>

                            

                                
                            </tr>
                        </thead>
                        <tbody>

                            @if(count($logins))
                            @foreach($logins as $login)

                            <tr>
                           
                            <td class="text-center">   {{$login->name}}</td>

                            @if($login->role_id==2)
                                <td class="text-center">Host</td>
                                @endif

                                @if($login->role_id==3)
                                <td class="text-center">User</td>
                                @endif
                                <td class="text-center">   {{$login->email}}</td>
                                <td class="text-center">   {{$login->gender}}</td>
                                @if($login->status==1)
                                <td class="text-center">Verified</td>
                                @endif

                                @if($login->status==0)
                                <td class="text-center">Unverified</td>
                             
                                @endif
                                <td class="text-center">{{ 	date('d/m/Y', $login->created_at)  }}</td>
                                
                                <td class="text-center"> {{  date('d/m/Y', $login->updated_at)}}</td>

                          
                            


                             



                               

                            </tr>
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


                {{$logins->links("pagination::bootstrap-4")}}

        </div>
    </div>
</div>

@endsection
