

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
            <p style="margin-bottom: 20px;text-align:center;"><b style="font-size:16px;"> Congrats! You Have A New Class Booking 🎊


 
</b> </p>
                <h6 style="margin: 0;font-size: 16px;margin-bottom: 20px;">Hi <?php echo ucfirst($data['teacher_name']); ?>,</h6>
                <p style="margin: 0;margin-bottom: 20px;">
                This email is to confirm  <b><?php echo ucfirst($data['name']); ?></b> has successfully booked a class with you. Please find below the details of the session:
               

                </p>
                <table cellpedding="0" cellspacing="0" style="margin: 0 0 15px; width: 80%;">
                    <tr>
                    <td style="width:40%">
                            <p style="margin: 0 0 5px;"><u>Class</u>: </p>
                        </td>
                     
                        <td>
                            <p style="margin: 0 0 5px;    padding-left: 15px;"><?php echo ucfirst($data['class_name']); ?></p>
                        </td>
                    </tr>
                    <tr>
                    <td style="width:40%">
                            <p style="margin: 0 0 5px;"><u>Class Date</u>:</p>
                        </td>
                    
                        <td>
                            <p style="margin: 0 0 5px;    padding-left: 15px;"><?php echo date('d/m/Y', $data['date']);   ?> </p>
                        </td>
                    </tr>
                    <tr>
                    <td style="width:40%">
                            <p style="margin: 0 0 5px;"><u>Class Time</u>:</p>
                        </td>
                      
                        <td>
                            <p style="margin: 0 0 5px;    padding-left: 15px;"><?php echo $data['time_in_string']; ?> &nbsp; <?php echo $data['zone'];?></p>
                        </td>
</tr>
                    <tr>
                    <td style="width:40%">
                            <p style="margin: 0 0 5px;"><u>Earnings from booking</u> :</p>
                        </td>
                     
                        <td>
                        @if($data['currency'] == 'USD' && $data['cost'] !=0)

                            <p style="margin: 0 0 5px;    padding-left: 15px;">$<?php echo ucfirst($data['cost']); ?></p>
                            @endif
                            @if($data['currency'] == 'GBP' && $data['cost'] !=0)

                            <p style="margin: 0 0 5px;    padding-left: 15px;">£<?php echo ucfirst($data['cost']); ?></p>
                            @endif
                            @if($data['currency'] == 'EUR' && $data['cost'] !=0)

                            <p style="margin: 0 0 5px;    padding-left: 15px;">&euro;<?php echo ucfirst($data['cost']); ?> </p>
                            @endif
                            @if( $data['cost'] ==0)

<p style="margin: 0 0 5px;    padding-left: 15px;">Free Trial </p>
@endif

                        </td>
                    </tr>
                    <tr>
                    <td style="width:40%">
                            <p style="margin: 0 0 5px;"><u>Join class here</u>:</p>
                        </td>
                      
                        <td>
                          <a href="<?php echo ucfirst($data['start_url']); ?>"> <?php echo \Illuminate\Support\Str::limit($data['start_url'], 60, '...'); ?></p></a>
                        </td>
                    </tr>
                </table>

                @if($data['region']=='Europe')
                <p style="margin: 0;">Your 💰 will be available for release 7 days after the class is hosted on the scheduled date. After that, you can release your earnings on your profile under Classes > Your Earnings.

</p>
@else
<p style="margin: 0;">Matutto is not able to process payments in your country right now (but we are working hard to change this!). <br><b>Make sure to agree on a payment method with the user who booked your class.</b></p>
@endif
<p style="margin: 0;margin-top:10px">Thanks for hosting a class with us! 🥰

</p>
<!-- @if($data['subs'] == 0)

<div style="background-color:yellow;margin-left:25px;margin-right:25px;margin-top:20px;">
<p style="margin: 0;"><b>Host Classes Without Commission 🤑</b></p>

<p style="text-align:center">Serious about teaching online? For only £63 per year you can host unlimited classes without any commission</p>
<p style="text-align:center">
                                                        
                                                        <a href="https://matutto.com/plans" style="background-color: #f8b739;
                    border: none;
                    color: white;
                    padding: 7px 20px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 16px;
                    cursor: pointer;
                    border-radius: 8px;margin-bottom: 20px;">Go Premium</a>             </p>
                    </div>
                    @endif -->

                
            </div>
            <div style="padding: 20px 25px;border-top: 1px solid #ececec;">
                <p style="margin:0 0 5px;">Thank You,
</p>
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

