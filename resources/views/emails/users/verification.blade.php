
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="padding:0; margin:0; box-sizing: border-box; -webkit-box-sizing: border-box; font-family: arial; font-size: 15px;    line-height: 24px;">
   <table cellpedding="0" celspacing="0" style="max-width: 620px; width:100%; margin: auto; border: 1px solid #ececec;">
       <tr>
           <td>
            <div style="text-align: center;padding: 20px 0;background-color:white ">
                <img src="{{ asset('images/Icon-l.png') }}" alt="logo" width="200">
            </div>
      
            <div style="padding: 25px;">
            <p style="margin-bottom: 20px;"><b style="font-size:16px;"> You're One Step Away! Complete Your Registration ⬇️ ️</b> </p>

                <h6 style="margin: 0;font-size: 16px;margin-bottom: 20px;">Dear {{ $user->email }},</h6>
                <p style="margin: 0;margin-bottom: 20px;">
              Thank you for signing up to Matutto!
                </p>
                <p style="margin: 0;margin-bottom: 20px;">Don’t forget to verify your email address to complete your registration.
</p>

                <p style="text-align:center">
                                                        
                @if( $user->verify_token =='')
                <a href="{{ config('variable.FRONTEND_URL') }}/email-verified/~" 
                                                        style="background-color: #f8b739;
                    border: none;
                    color: white;
                    padding: 7px 20px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 16px;
                    cursor: pointer;
                    border-radius: 8px;margin-bottom: 20px;">Verify Your Email</a>    
                @else
                
                                                        <a href="{{ config('variable.FRONTEND_URL') }}/email-verified/<?php echo $user->verify_token;?>" 
                                                        style="background-color: #f8b739;
                    border: none;
                    color: white;
                    padding: 7px 20px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 16px;
                    cursor: pointer;
                    border-radius: 8px;margin-bottom: 20px;">Verify Your Email</a>       
                    @endif                           
                                                    
                                                    </p>
<div style="padding: 20px 0px;">
                <p style="margin: 0;margin-bottom: 20px;">If you have trouble accessing the above link, you can also copy and paste the following URL in your browser: </p>
                @if( $user->verify_token !='')

                <p style="margin: 0; margin-bottom: 20px;"><a style="color:black" href="{{ config('variable.FRONTEND_URL') }}/email-verified/{{$user->verify_token}}<?php echo $user->verify_token;?>" >{{ config('variable.FRONTEND_URL') }}/email-verified/{{$user->verify_token}}</a></p>
                @else
                <p style="margin: 0; margin-bottom: 20px;"><a style="color:black" href="{{ config('variable.FRONTEND_URL') }}/email-verified/~" >{{ config('variable.FRONTEND_URL') }}/email-verified/~</a></p>
                @endif
                <p style="margin: 0;">We are excited to have you here! 🎉 </p>
            </div>
                
            </div>
            <div style="padding: 20px 25px;border-top: 1px solid #ececec;">
                <p style="margin:0 0 5px;">Thank you</p>
                <p style="margin:0;">The Matutto Team</p>
            </div>
           </td>
       </tr>
   </table>

   <table cellpedding="0" celspacing="0" style="max-width: 620px; width:100%; margin: auto; ">
   <div style="padding: 10px 25px;">

   <p style="font-size:12px;color:grey;  ">Why you are receiving this email: This email relates to your Matutto account and is necessary to deliver our service as per our T&Cs. </p>
</div>
</table>
</body>
</html>