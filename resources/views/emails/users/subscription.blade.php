
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

            <div style="padding: 25px;"> <p style="margin-bottom: 20px;text-align:center;"><b style="font-size:16px;">            Welcome to Matutto Premium For Hosts! 🔑


 
</b> </p>
                <h6 style="margin: 0;font-size: 16px;margin-bottom: 20px;">Hi  <?php echo ucfirst($data['name']); ?>,</h6>
                @if($data['plan']=='monthly') 
                <p style="margin: 0;margin-bottom: 20px;">
                Thank you for subscribing to Matutto’s Premium Monthly plan for Hosts 🏆 You can now Host unlimited classes without paying any commission. 


                </p>
                <p style="margin: 0;margin-bottom: 20px;">
                A direct debit has been set up for the value of @if($data['currency']=='gbp') £
 @endif 
 @if($data['currency']=='eur') &euro;
 @endif<?php echo ucfirst($data['amount']); ?>                  , which will come out of your selected bank account on the <?php echo ucfirst($data['date']); ?>  of every month.


                             </p>
                             <p style="margin: 0;margin-bottom: 20px;">
                             You can cancel your subscription at any time on matutto.com under Profile Settings > My Plan.

                            

                             </p>
                             
                             @endif
                             @if($data['plan']=='yearly') 
                <p style="margin: 0;margin-bottom: 20px;">
                Thank you for subscribing to Matutto’s Premium Plan for Hosts 🏆 You can now Host unlimited classes without paying any commission. 


                </p>
                <p style="margin: 0;margin-bottom: 20px;">
                Your Premium Account is active for a full year, with an expiration date of <?php echo ucfirst($data['date1']); ?>

                             </p>
                            
                             @endif
               
                <p></p>
                                                        <div >
                <p style="margin: 0;"><a style="color:#7a2a90" ></a></p>
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
</table></body>
</html>