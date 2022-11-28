
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
                <img src="{{ asset('images/Icon-l.png') }}" alt="logo" width="200">
            </div>
            <div style="padding: 25px;">
                <h6 style="margin: 0;font-size: 16px;margin-bottom: 20px;">Hi  <?php echo ucfirst($data['name']); ?>,</h6>
                <p style="margin: 0;margin-bottom: 20px;">
                <?php echo ucfirst($data['email']); ?> </br>
                <?php echo ucfirst($data['message']); ?>                </p>
               
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