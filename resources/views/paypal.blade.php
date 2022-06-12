<html>
<head>
	<meta charset="utf-8">
	<title>Pay with paypal</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">  
</head>
<body>
	<div class="container">
        <div class="row">    	
            <div class="col-md-8 col-md-offset-2">        	
                
                <div class="" style="margin-top: 60px;">

                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{!! \Session::get('error') !!}</li>
                            </ul>
                        </div>
                    @endif 
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>