<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>オーソネットワーク予約管理システム</title>
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="<?php echo e(asset('')); ?>public/backend/ortho/common/css/import.css" rel="stylesheet">
</head>
<body class="body-login">
  <!-- Header -->
    <header>
      <div class="container-fluid">
        <div class="row">
          <h1><img src="<?php echo e(asset('')); ?>public/backend/ortho/common/image/logo.png" /></h1>
        </div>
      </div>
    </header>
  <!-- End Header -->
  <!-- content login -->
    <section id="login">
      <div class="container">
        <div class="content-login">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <h1>ログイン</h1>
            <?php echo Form::open(array('route' => 'ortho.login', 'method' => 'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

              <div class="form-group">
                <label class="col-xs-12 col-md-4 control-label" for=" u_login">ログインID</label>
                <div class="col-xs-12 col-md-6">
                  <input type="text" class="form-control" id="iputid" name="u_login" value="<?php echo e(old('u_login')); ?>" >
                  <div class="help-block with-errors"><ul class="list-unstyled"><li><?php if($errors->first('u_login')): ?> <?php echo $errors->first('u_login'); ?> <?php endif; ?></li></ul></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-xs-12 col-md-4 control-label" for="password" >パスワード</label>
                <div class="col-xs-12 col-md-6">
                  <input type="password" class="form-control" id="password" name="password" value="" >
                  <div class="help-block with-errors"><ul class="list-unstyled"><li><?php if($errors->first('password')): ?> <?php echo $errors->first('password'); ?> <?php endif; ?></li></ul></div>
                  <?php if(Session::has('error')): ?>
                    <div class="alert alert-info"><?php echo e(Session::get('error')); ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-4"></div>
                <div class="col-xs-12 col-md-6">
                  <button type="submit" class="btn btn-login" name="login" value="login">ログイン</button>
                </div>
              </div>

            <?php echo Form::close(); ?>

          </div>
        </div>
      </div>
    </section>
  <!-- End content login -->
</body>
</html>