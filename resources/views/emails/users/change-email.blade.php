

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
           <div style="text-align: center;padding: 20px 0; ">
                <img src="{{ asset('images/matuttoo.png') }}" alt="logo" >
            </div>
            <div style="padding: 25px;">
            <p style="margin-bottom: 20px;text-align:center;"><b style="font-size:16px;"> Complete Your Email Address Change ⬇️  

 
 </b> </p>
                <h6 style="margin: 0;font-size: 16px;margin-bottom: 20px;">Hi {{ $user->name }},</h6>
                <p style="margin: 0;margin-bottom: 20px;">
                You have requested to change the email address associated to your Matutto account. You can do so by clicking the button below.

                </p>
               
                <!-- <p><a href="{{ config('variable.FRONTEND_URL') }}/verification/<?php echo $user->verify_token;?>" style="color: #90cbf5;">
                                                            <span style="color: #90cbf5;">Click Here</span>
                                                        </a></p> -->
                                
                                                        <p style="text-align:center">
                                                        
                                                        <a href="{{ config('variable.FRONTEND_URL') }}/verification/<?php echo $user->verify_token;?>" style="background-color: #f8b739;
                    border: none;
                    color: white;
                    padding: 7px 20px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 16px;
                    cursor: pointer;
                    border-radius: 8px;margin-bottom: 20px;">Change Email</a>             </p> 
            </div>
            <div style="padding: 20px 0px;">


                                                        
<p style="margin: 0;">Please note this link expires in 24 hours from receiving this email. If you wish to change your email address after that you must initiate the process again.

</p>
<!-- <p style="margin: 0;"> <a style="color:#7a2a90" href="{{ config('variable.SERVER_URL') }}/reset-password/{{ $user->forgot_password_token}}">{{ config('variable.SERVER_URL') }}/reset-password/{{ $user->forgot_password_token}}</a></p> -->
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
</table></body>
</html>
