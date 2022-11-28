

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
           
            <p style="margin-bottom: 20px;text-align:center;"><b style="font-size:16px;">  How was your class with {{$data['host_name']}}?
 
 </b> </p>
                <h6 style="margin: 0;font-size: 16px;margin-bottom: 20px;">Hi  <?php echo ucfirst($data['name']); ?>,</h6>
                <p style="margin: 0;margin-bottom: 20px;">
            Thank you for attending  a class on Matutto. Don't forget to leave the Host a review so other Users can benefit from your experience.
              </p>
               
                <p style="margin: 0;margin-bottom: 20px;">
                <b >How to write a review:</b><br>1. &nbsp;
<a href="https://matutto.com/login">Login</a> &nbsp;to your Matutto  account<br>
2. &nbsp;Go to 'Classes', and click on 'View All Completed' <br>
3. &nbsp;Click on  "Write a Review", give the Host 1-5 stars and comment on your class experience<br>
</p>
                                                        <div >
                <p style="margin: 0;">Additionally, we would really appreciate if you could take 5 minutes to <a href="https://docs.google.com/forms/d/e/1FAIpQLSenubyIH7B9aXqy0FSH9MFHGuLmo9gB9c_oit86D62PkLtvSg/viewform?usp=sf_link">review your experience using Matutto</a></p>
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
