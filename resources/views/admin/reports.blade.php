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

<option  value="{{ route('admin.reports','1') }}"> January</option>
        <option value="{{ route('admin.reports',2)}}">Febuary</option>
        <option  value="{{ route('admin.reports',3) }}">March</option>
        <option value="{{ route('admin.reports', 4 )}}">April</option>
        <option  value="{{ route('admin.reports', 5 )}}">May</option>
        <option value="{{ route('admin.reports', 6 )}}">June</option>
        <option  value="{{ route('admin.reports',7 )}}">July</option>
        <option value="{{ route('admin.reports', 8)}}">August</option>
        <option  value="{{ route('admin.reports', 9) }}">September</option>
        <option value="{{ route('admin.reports', 10 ) }}">October</option>
        <option  value="{{ route('admin.reports', 11) }}">November</option>
        <option value="{{ route('admin.reports', 12) }}">December</option>
    </select>
    @endif
                    </div>
                </div>
                </form>



                <div class="col-md-8">
                    <div class="text-right">
                    <div class="d-md-inline-block mt-1 align-top">
                    <a  class="u_status_single"href="{{ route('admin.dailyreport', collect(request()->segments())->last() ) }}"> <span class="button btn btn-sm btn-primary mt-0" >Download</span></a>

</div>
                    </div>
                </div>
            </div>
        </div>

  

        <div class="user-mangement-list">
            <div class="total-entries"><span>{{ $reports->total() }} Entrie(s)</span></div>
            <div class="data-table">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Class Subject</th>
                                <th class="text-center">Class Name</span></th>
                                <th class="text-center">Host Name</th>
                                <th class="text-center">User Name</th>

                                <th class="text-center">Class Price</th>

                                <th class="text-center">Currency</th>
                                <th class="text-center">Class Type</span></th>
                                <th class="text-center">Class Date</th>

                                <th class="text-center">Class Time</th>

                                <th class="text-center">Status</th>
                                <th class="text-center">duration</th>

                                
                            </tr>
                        </thead>
                        <tbody>

                            @if(count($reports))
                            @foreach($reports as $report)

                            <tr>
                           
                            <td class="text-center">   {{$report->subject_name}}</td>
                            <td class="text-center">  {{ $report->class_name}}</td>
                            <td class="text-center"> @if($report->teacher != null){{ $report->teacher->name }}@else Matutto Host @endif</td>
                                <td class="text-center">   @if($report->user !=null){{ $report->user->name }}@else Matutto User @endif </td>
                                <td class="text-center">   {{$report->cost}}</td>
                                <td class="text-center">   {{$report->currency}}</td>
                                @if($report->type==1)
                                <td class="text-center">Face to face</td>
                                @endif

                                @if($report->type==2)
                                <td class="text-center">Online</td>
                                @endif



                             
                                <td class="text-center">{{ 	date('d/m/Y', $report->from_timing)  }}</td>
                                <td class="text-center">{{ 	date('h:i A', $report->from_timing)  }}</td>
                                <td class="text-center">{{$report->status}}</td>
                                <td class="text-center">{{($report->duration_hour*60*60 + $report->duration_minutes*60)/60}}</td>



                               

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


                {{$reports->links("pagination::bootstrap-4")}}

        </div>
    </div>
</div>

@endsection
