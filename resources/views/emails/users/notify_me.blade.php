


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
                <b style="margin: 0;margin-bottom: 20px ;  padding-top: 25px;
 ">
A new person signed up to receive notifications when Hosts are listed for the following category:

                </b>
                <table cellpedding="0" cellspacing="0" style="margin: 0 0 15px; width: 80%;padding-top: 25px">
                    <tr>
                        <td>
                            <p style="margin: 0 0 5px;">Search Term </p>
                        </td>
                        <td>
                            <p style="margin: 0 0 5px;">: </p>
                        </td>
                        <td>
                            <p style="margin: 0 0 5px;    padding-left: 15px;"><?php echo ucfirst($data['name']); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0 0 5px;">Date </p>
                        </td>
                        <td>
                            <p style="margin: 0 0 5px;">: </p>
                        </td>
                        <td>
                            <p style="margin: 0 0 5px;    padding-left: 15px;"><?php echo ucfirst($data['date']); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0 0 5px;">Time</p>
                        </td>
                        <td>
                            <p style="margin: 0 0 5px;">: </p>
                        </td>
                        <td>
                            <p style="margin: 0 0 5px;    padding-left: 15px;"><?php echo ucfirst($data['time']); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0 0 5px;">Email Address</p>
                        </td>
                        <td>
                            <p style="margin: 0 0 5px;">: </p>
                        </td>
                        <td>
                            <p style="margin: 0 0 5px;    padding-left: 15px;"><?php echo $data['email'] ?></p>
                        </td>
                    </tr>
                  
                 
                </table>
                <!-- <p style="margin: 0;">Your earrings will be processed and released 7 days after
                    the class date. It may take an extra 2 to 3 working days to
                    reach your account, depending on your bank.</p> -->
                
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

