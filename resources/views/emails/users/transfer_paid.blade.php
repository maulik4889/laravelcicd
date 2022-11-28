



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
            <p style="margin-bottom: 20px;text-align:center"><b style="font-size:16px;"> New Class Earnings Are On Their Way  💸 
</b> </p>

                <h6 style="margin: 0;font-size: 16px;margin-bottom: 20px;">Hi  <?php echo ucfirst($data['name']); ?>,</h6>
               
                
             @if($data['currency'] == 'USD')

<p style="margin: 0;margin-bottom: 20px;">
              
We are pleased to confirm that $<?php echo ucfirst($data['amount']); ?> have been released to your linked bank account 💰 You can see full details of your earnings on Matutto.com under Classes > Your Earnings.

             </p>
@endif
@if($data['currency'] == 'GBP')

<p style="margin: 0;margin-bottom: 20px;">
              

                
                We are pleased to confirm that £<?php echo ucfirst($data['amount']); ?> have been released to your linked bank account 💰 You can see full details of your earnings on Matutto.com under Classes > Your Earnings.
             </p>
@endif
@if($data['currency'] == 'EUR')

<p style="margin: 0;margin-bottom: 20px;">


We are pleased to confirm that &euro;  <?php echo ucfirst($data['amount']); ?>  have been released to your linked bank account 💰 You can see full details of your earnings on Matutto.com under Classes > Your Earnings.

             </p>@endif
                <p></p>
                                                        <div >
                                                        <p style="text-align:center">
                                                        
                                                        <a href="{{ config('variable.FRONTEND_URL') }}/login" style="background-color: #f8b739;
                    border: none;
                    color: white;
                    padding: 7px 20px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 16px;
                    cursor: pointer;
                    border-radius: 8px;margin-bottom: 20px;">Login Now</a>             </p>
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


