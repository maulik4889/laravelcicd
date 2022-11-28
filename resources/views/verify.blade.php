@extends('webmaster')

@section('content')
<div class="container text-center" >
           <div class="row">
        <div class="col-md-12">
        <div style="text-align: center;padding: 10px 0; ">
                <img src="{{ asset('images/logo0_old.png') }}" alt="logo">
            </div>
        <div class="successwrap">
    <div class="header">
      <div class="icon-crossmmark">
      <h3 style="color:#4d4d4d">  <img src="{{ asset('images/success.png') }}" height="35" width="35">&nbsp;Email Verified</h3>
      </div>
    </div>
    <div class="th-body">
    	<h4><b>Congratulations<b></h4>

      <h4> 	Your Matutto account is ready 🥳</h4>
      <h4> 			You can now login with your email and password.
</h4>

    </div>
    <div class="th-body">
      <p><a href="https://matutto.com/login" style=" background-image: linear-gradient(to right, #ff4b00 0%, #ffac00 100%);
                   min-width: 350px;
    min-height: 50px;
    line-height: 50px;
    padding: 0px 25px;
    border-radius: 4px;
    border: 1px solid #FF5700;
    font-size: 20px;
    color: #fff;
    display: inline-block;
    text-align: center;
    text-transform: capitalize;
    font-weight: 400;
    transition: 0.8s;">Login</a>  </p>
    </div>
    <div class="th-body">
      <img src="{{ asset('images/verify.jpg') }}" style="width:900px">
</div>
  </div>

         </div>
    </div>
</div>
@endsection



