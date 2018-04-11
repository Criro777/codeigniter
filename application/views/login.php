<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://bootswatch.com/flatly/bootstrap.min.css">
    <link href="/assets/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link href="/assets/css/style.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <title>TODO App</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        form {
            margin-top: 50px;
        }

        #todoList li {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
<div class="jumbotron">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">Регистрация прошла успешно!
            Войдите под своими данными!
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['errors'])): ?>
        <?php foreach ($_SESSION['errors'] as $error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <div style="text-align: center;" class="login-form"><!--login form-->
        <h2>Вход</h2>
        <form id="account" action="/login" method="post" data-toggle="validator">
            <div class="form-group has-feedback">
                <div id ="email" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input class="form-control" type="email" name="email"  placeholder="E-мэйл" required>
                </div>
                <span class="glyphicon form-control-feedback "></span>
            </div>

            <div id = "password" class="form-group has-feedback">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-paperclip"></i></span>
                    <input class="form-control" type="password" name="password" placeholder="Пароль" required>
                </div>
                <span class="glyphicon form-control-feedback "></span>
            </div>

            <button type="submit" name="login" id="login" class="btn btn-success">Войти</button>
        </form>
        <div class="signup-form">
            <a href="/register" class="btn btn-info">Создать новую учетную запись</a>
        </div>
    </div>
</div>
</div>
</body>
</html>

