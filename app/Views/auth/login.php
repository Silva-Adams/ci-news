<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <title>Login</title>
</head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <h1><?php echo lang('Auth.login_heading');?></h1>
    <p><?php echo lang('Auth.login_subheading');?></p>

    <div id="infoMessage"><?php echo $message ?? '';?></div>

    <div class="col-md-10 mx-auto col-lg-5">
      <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" <?php echo form_open('auth/login');?>

      <p>
        <?php echo form_label(lang('Auth.login_identity_label'), 'identity');?>
        <?php echo form_input($identity ?? []);?>
      </p>

      <p>
        <?php echo form_label(lang('Auth.login_password_label'), 'password');?>
        <?php echo form_input($password ?? "");?>
      </p>

      <p>
        <?php echo form_label(lang('Auth.login_remember_label'), 'remember');?>
        <?php echo form_checkbox('remember', '1', false, 'id="remember"');?>
      </p>


      <p><?php echo form_submit('submit', lang('Auth.login_submit_btn'));?></p>

    <?php echo form_close();?>

    <p><a href="forgot_password" class="btn btn-primary"><?php echo lang('Auth.login_forgot_password');?></a></p>
    </div>
  </body>
</html>
