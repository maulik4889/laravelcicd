<header>
  <div class="header-block">
    <div class="container-fluid">
      <div class="row">
       
        <div class="col-md-4 col-sm-4 col-md-push-4 col-sm-push-4">
          <div class="nav-section">
            <div class="main-user-nav">
              <ul>
                <li>
                  <div class="user-drop-down pointer" data-toggle="collapse" data-target="#useropt"><span class="user-name"><img src="https://matutto.com/backend/images/avatar.96.gif" style="width: 50px; height:50px;" alt="img"> {{ ucfirst(Auth::user()->name) }}</span><span class="caret"></span></div>
                  <div class="user-drop-down-box collapse" id="useropt">
                    <div class="user-opt-menu">
                      <ul>
                        <li><a href="{{ route('admin.getchange.password') }}">Change Password</a></li>
                        <li>
                          <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> Logout</a>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                          </form>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-md-pull-4 col-sm-pull-4">
          <h4 class="page-title">{{ @$title }}</h4>
        </div>
      </div>
    </div>
  </div>
</header>
