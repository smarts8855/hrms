<!DOCTYPE html>
<html>
<head>
	<title>contact</title>
</head>
<body>
 <div class="form">
          <div id="sendmessage">Your message has been sent. Thank you!</div>
          <div id="errormessage"></div>
            <form method="POST" action="{{url('/contact/mail')}}">
                                {{ csrf_field() }}
                                <div class="col-sm-6 no-padding-left">
                                    <input type="text" class="form-control" id="Name" placeholder="YOUR NAME" name="name"> 
                                </div>
                                <div class="col-sm-6 no-padding-right">
                                    <input type="email" class="form-control" id="Email" placeholder="EMAIL" name="email"> 
                                </div>
                                <div class="col-sm-12 no-padding contact-us-custom-padding">
                                    <input type="text" class="form-control" id="Subject" placeholder="SUBJECT" name="subject"> 
                                </div>
                                <div class="col-sm-12 no-padding contact-us-custom-padding">
                                    <textarea class="form-control" rows="8" id="Message" placeholder="MESSAGE" name="message"></textarea>
                                </div>
                                <div class="col-sm-12 no-padding contact-us-custom-padding">
                                    <input type="submit" value="submit" />
                                </div>
                            </form>          
        </div>
</body>
</html>