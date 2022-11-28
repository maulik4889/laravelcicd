@extends('admin.index')
@section('content')
 <!-- Page Content  -->




<div class="dashboard-content containerClass">
<div class="dashboard-t-info">
  <div class="row row-10">
  
    <div class="col-lg-4 mb-3" >
     
     <div class="card bg-dark text-white h-100">
       <div class="card-body bg-dark">
         <h6 class="text-uppercase">
           <a class="link-color" href="{{ route('admin.logins','today') }}"> Logins Today </a>
         </h6>
         <h1 class="display-4 link-child">{{$today_logins }}</h1>
       </div>
     </div>  
   </div>
   <div class="col-lg-4 mb-3" >
     
     <div class="card bg-dark text-white h-100">
       <div class="card-body bg-dark">
         <h6 class="text-uppercase">
           <a class="link-color" href="{{ route('admin.logins','weekly') }}"> Logins Weekly </a>
         </h6>
         <h1 class="display-4 link-child">{{$weekly_logins }}</h1>
       </div>
     </div>  
   </div>
   <div class="col-lg-4 mb-3" >
     
     <div class="card bg-dark text-white h-100">
       <div class="card-body bg-dark">
         <h6 class="text-uppercase">
           <a class="link-color" href="{{ route('admin.logins','monthly') }}"> Login of the month</a>
         </h6>
         <h1 class="display-4 link-child">{{$monthly_logins}}</h1>
       </div>
     </div>  
   </div>
   
    <!-- <div class="col-lg-4">
      <div class="dashboard-t-box c-1 text-center">
        <h3>{{ $total_visitors }}</h3>
        <h4><span class="ico m-0"><i class="icon-user"></i></span> Total Visitors</h4>
      </div>
    </div> -->
    <div class="col-lg-4 mb-3">
     

      <div class="card bg-dark text-white h-100">
        <div class="card-body bg-dark">
          <h6 class="text-uppercase">
            <a href="{{ route('admin.newUsers','today') }}" class="link-color"> New users today</a>
          </h6>
          <h1 class="display-4 link-child">{{ $today_visitors }}</h1>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-3">

      <div class="card bg-dark text-white h-100">
        <div class="card-body bg-dark">
          <h6 class="text-uppercase">
            <a href="{{ route('admin.newUsers','weekly') }}" class="link-color" > New users this week</a>
          </h6>
          <h1 class="display-4 link-child">{{ $weekly_visitors }}</h1>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-3">
  
      <div class="card bg-dark text-white h-100">
        <div class="card-body bg-dark">
          <h6 class="text-uppercase">
            <a href="{{ route('admin.newUsers','monthly') }}" class="link-color"> New users this month</a>
          </h6>
          <h1 class="display-4 link-child">{{ $monthly_visitors }}</h1>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-3">
      <div class="card bg-dark text-white h-100">
        <div class="card-body bg-dark">
          <h6 class="text-uppercase">
            <a href="{{ route('admin.newUsers','yearly') }}" class="link-color"> New users this year</a>
          </h6>
          <h1 class="display-4 link-child">{{ $yearly_visitors }}</h1>
        </div>
      </div>
    </div>
   
  
    <div class="col-lg-4 mb-3">
  
    <div class="card bg-dark text-white h-100">
        <div class="card-body bg-dark">
          <h6 class="text-uppercase">
            <a href="{{ route('admin.deletedUsersList') }}" class="link-color" >Deleted Users</a>
          </h6>
          <h1 class="display-4 link-child">{{ $deleted_users }}</h1>
        </div>
      </div>
  </div>

 
</div>

@endsection
