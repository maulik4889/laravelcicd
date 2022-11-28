@extends('admin.index')
@section('content')


<div class="dashboard-content padding-sm">

    <div class="dashboard-user-mange-section">
        <div class="header-block">
            <div class="row">
                <div class="col-md-4">
                    <div class="sort-input-field margin-bottom-2x">
                    
                    </div>
                </div>



                <div class="col-md-8">
                    <div class="text-right">
                    <div class="d-md-inline-block mt-1 align-top">
                    <a  class="u_status_single"href="{{ route('admin.deletedUsers') }}"> <span class="button btn btn-sm btn-primary mt-0" >Download</span></a>

</div>
                    </div>
                </div>
            </div>
        </div>

  

        <div class="user-mangement-list">
            <div class="total-entries"><span>{{ $deleted_users->total() }} Entrie(s)</span></div>
            <div class="data-table">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Reason to deleted</th>
                                <th class="text-center">Deleted At</th>
                            


                                
                            </tr>
                        </thead>
                        <tbody>

                            @if(count($deleted_users))
                            @foreach($deleted_users as $deleted)

                            <tr>
                            <td class="text-center">   {{$deleted->name}}</td>
                                <td class="text-center">{{ $deleted->reason}}</td>
                            <td class="text-center">{{ 	date('d/m/Y', $deleted->created_at)  }}</td>
                           
                           
                               
                               

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


                {{$deleted_users->links("pagination::bootstrap-4")}}

        </div>
    </div>
</div>

@endsection
