

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
                <img src="{{ asset('images/matuttoo.png') }}" alt="logo" >
            </div>
            <div style="padding: 25px;">
            <p style="margin-bottom: 20px;text-align:center;"><b style="font-size:16px;"> You cancelled a class❌


 
</b> </p>
                <h6 style="margin: 0;font-size: 16px;margin-bottom: 20px;">Hi <?php echo ucfirst($data['teacher_name']); ?>,</h6>
                <p style="margin: 0;margin-bottom: 20px;">
                You have cancelled this class:

               

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
                    
                   
                </table>

           
<p style="margin: 0;">The class attendees have been notified. <br> you can re-schedule the class anytime by creating a new class on <a href="https://matutto.com">matutto.com</a></p>
<br>

<p style="text-align:center">
                                                        
                                                        <a href="https://matutto.com/createclass" style="background-color: #f8b739;
                    border: none;
                    color: white;
                    padding: 7px 20px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 16px;
                    cursor: pointer;
                    border-radius: 8px;margin-bottom: 20px;">Create a Class</a>             </p>

                
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





