
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
            @if($data['type']=='send') 

            @if($data['request_count'] == 0)

<p style="margin-bottom: 20px;text-align:center;"><b style="font-size:16px;"> You Got A New Class Request! 📥



</b> </p>
@else
<p style="margin-bottom: 20px;text-align:center;"><b style="font-size:16px;"> You have a new message! 📥

</b> </p>
@endif
@endif
@if($data['type']=='reply') 
<p style="margin-bottom: 20px;text-align:center;"><b style="font-size:16px;"> You have a new message! 📥

</b> </p>
@endif

                <h6 style="margin: 0;font-size: 16px;margin-bottom: 20px;">Hi  <?php echo ucfirst($data['name']); ?>,</h6>
                @if($data['type']=='send') 
 @if($data['request_count'] == 0)
                <p style="margin: 0;margin-bottom: 20px;">

 You received a new class request. You can reply to the User with a message or create a custom class for them. 
</p><br>
@else
<p style="margin: 0;margin-bottom: 20px;">

You received a new message. 
</p><br>
@endif

@endif
                @if($data['type']=='reply') 

                <p style="margin: 0;margin-bottom: 20px;">

                Your recent class request has been answered by the host:
                <br>


                                                        
</p>



@endif
          
                <p style="margin-bottom: 20px;text-align:center; margin:30px; padding:20px ;border: 1px solid #D3D3D3;" ><?php echo ucfirst($data['query']); ?>
 
 </p>
 @if($data['type']=='send') 
 <p style="text-align:center">
<a href="https://matutto.com/messages" style="background-image: linear-gradient(to right,#ff4b00 0,#ffac00 100%);
                    border: none;
                    color: white;
                    padding: 12px 25px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 17px;
                    cursor: pointer;
                    margin-right:20px;
                    border-radius: 8px;margin-bottom: 20px;">Message</a>  
                                                        
                                                        <a href="https://matutto.com/createclass" style="background-image: linear-gradient(to right,#ff4b00 0,#ffac00 100%);
                    border: none;
                    color: white;
                    padding: 12px 25px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 17px;
                    cursor: pointer;
                    border-radius: 8px;margin-bottom: 20px;">Create A Class For This User </a>             </p>
       <p style="margin: 0;margin-bottom: 20px;margin-top:20px;">
                <a href="https://matutto.com/login"> Log in</a> to your Matutto Host account and go to <span style="color:grey">Requests</span> to accept it or reject it.
              </p>
              @endif
              @if($data['type']=='reply') 

              <p style="margin: 0;margin-bottom: 20px;">
                <a href="https://matutto.com/login"> Log in</a> to your Matutto User account to continue the conversation.

</p>
                <p style="margin: 0;margin-bottom: 20px;text-align:center">

                <a href="https://matutto.com/messages" class="text-center" style="background-image: linear-gradient(to right,#ff4b00 0,#ffac00 100%);
                    border: none;
                    color: white;
                    padding: 12px 25px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 17px;
                    cursor: pointer;
                    margin-right:20px;
                    border-radius: 8px;">Reply</a>  
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