@extends('admin.index')
@section('content')

<div class="dashboard-content">

<div class="dashboard-user-dtl-section">

  <div class="row">
    <div class="col-md-4">
	<div class="margin-bottom-3x">
	<a class="back-btn" data-ui-sref="dashboard-user-management" href="{{ URL::previous() }}"><span class="ico"><i class="icon-arrow-left"></i></span>Back </a>
	</div>
      <div class="usr-pic-dtl">

          <img src="{{ $image }}" style="height:200px" alt="img"/>
     
      </div>
    </div>
    <div class="col-md-4">
      <div class="profile-block">
        <div class="user-profile-dtl">
          <uib-tabset justified="true">
            <uib-tab index="0" heading="Overview">
              <div class="profile-block__container">
                <div class="profile-block__content">
                  <div class="profile-block__content__row">
                    <div class="usr-name">
                      <h3>{{ ucfirst($user->name) }}</h3>
                    </div>
                     
                  </div>
                  <div class="profile-block__content__row">
                    <div class="usr-dtl">
                      <ul>
                       
                        <li>
                          <span class="fw300 label-name"><b>Email Id:</b>&nbsp;</span><span class="fw400">@if($user->email){{ $user->email }}@else - @endif</span></li>
                          <li>
                          <span class="fw300 label-name"><b>Nationality:</b>&nbsp;</span><span class="fw400">@if($user->nationality){{ $user->nationality }}@else - @endif</span></li>
                          <li>
                          <span class="fw300 label-name"><b>Reason to move:</b>&nbsp;</span><span class="fw400">@if($user->moving_reason){{ $user->moving_reason }}@else - @endif</span></li>
                        <li><span class="fw300 label-name"><b>Joined date:</b>&nbsp;</span><span class="fw400">@if($user->created_at){{ date('d/m/y',$user->created_at) }}@else - @endif</span></li>
                        <li><span class="fw300 label-name"><b>Status:</b>&nbsp;</span><span class="fw400">  @if($user->status == 1)
                                    Active
                                    @elseif($user->status == 2)
                                    Deactive
                                    @else
                                    Un-verified
                                    @endif</span></li>
                                    
                      

                         
                        <!-- <li><span class="fw300 label-name">Number of challenges completed :</span><span class="fw400">{{ $user->complete_challenge_count }}</span></li>

                        <li><span class="fw300 label-name">Number of challenges created :</span><span class="fw400">{{ $user->created_challenge_count }}</span></li>

                        <li><span class="fw300 label-name">Number of friends :</span><span class="fw400">{{ $user->friends_count }}</span></li> -->
                     
                      </ul>
                    </div>
                  </div>
               
                </div>

              </div>
            </uib-tab>
            <uib-tab index="1" heading="About">
              <div class="profile-block__container">
                <div class="profile-block__content">

                </div>
              </div>
            </uib-tab>

          </uib-tabset>
        </div>
      </div>
    </div>
    
  </div>
</div>
</div>
      <script src="{{ URL::asset('js/users.js') }}"></script>
      @endsection
