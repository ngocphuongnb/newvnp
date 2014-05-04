<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>User Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{#DATA_DIR#}library/bootstrap/normalize.min.css" />
        <link rel="stylesheet" type="text/css" href="{#DATA_DIR#}library/bootstrap/bootstrap-theme.min.css" />
        <link rel="stylesheet" type="text/css" href="{#DATA_DIR#}library/bootstrap/Forms/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="{#DATA_DIR#}library/bootstrap/Buttons/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="{#CDN_SERVER#}/{#APPLICATION_DIR}/template/css/style.css" />
    </head>
    
    <body>
    	<div class="container">
        	<div class="row col-xs-4" id="LoginForm">
                <form name="UserLogin" method="post" action="{$loginAction}" class="form-horizontal" role="form">
                	<div class="form-group">
                        <label class="col-sm-2" for="Username">Username</label>
                        <input name="username" type="text" class="form-control" id="Username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2" for="Password">Password</label>
                        <input name="password" type="password" class="form-control" id="Password" placeholder="Password">
                    </div>
                    <div style="text-align:center">
                    	<input type="submit" class="btn btn-primary" value="Submit"/>
                  	</div>
                </form>
          	</div>
      	</div>
    </body>
</html>