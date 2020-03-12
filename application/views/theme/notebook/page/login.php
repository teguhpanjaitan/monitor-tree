<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
  <meta charset="utf-8" />
  <title>Aplikasi Monitoring Tree</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook") ?>/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook") ?>/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook") ?>/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook") ?>/css/font.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/notebook") ?>/css/app.css" type="text/css" />
  <!--[if lt IE 9]>
    <script src="<?php echo base_url("assets/notebook") ?>/js/ie/html5shiv.js"></script>
    <script src="<?php echo base_url("assets/notebook") ?>/js/ie/respond.min.js"></script>
    <script src="<?php echo base_url("assets/notebook") ?>/js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body class="">
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xxl">
      <section class="panel panel-default bg-white m-t-lg">
        <header class="panel-heading text-center">
          <strong>Silahkan log in</strong>
        </header>
        <form action="<?php echo get_href("login/check_credential") ?>" class="panel-body wrapper-lg" method="post">
          <div class="form-group">
            <label class="control-label">Username</label>
            <input type="text" name="username" id="username" placeholder="Masukkan username anda" class="form-control input-lg" required>
          </div>
          <div class="form-group">
            <label class="control-label">Password</label>
            <input type="password" name="password" id="password" placeholder="Masukkan password anda" class="form-control input-lg" required>
          </div>
			<div class="form-group">
				<?php
					$dt = $this->input->get("dt");
					if(!empty($dt))
					{
						$tmp = urldecode($dt);
						$tmp = base64_decode($tmp);
						$tmp = json_decode($tmp);
						//var_dump($tmp);
						if(isset($tmp->message))
							echo "<span style='color:red'>".$tmp->message."</span>";
					}
				?>
			</div>
		  <input type="hidden" name="param" value="login">
          <button type="submit" name="submit" class="btn btn-primary">Log in</button>
        </form>
      </section>
    </div>
  </section>
	<!-- footer -->
	<!--<footer id="footer">
		<div class="text-center padder">
			<p>
				<small>Web app framework base on Bootstrap<br>&copy; 2013</small>
			</p>
		</div>
	</footer>-->
	<!-- / footer -->
	<script src="<?php echo base_url("assets/notebook") ?>/js/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url("assets/notebook") ?>/js/bootstrap.js"></script>
	<!-- App -->
	<script src="<?php echo base_url("assets/notebook") ?>/js/app.js"></script> 
	<script src="<?php echo base_url("assets/notebook") ?>/js/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url("assets/notebook") ?>/js/app.plugin.js"></script>
	<script>
	</script>	
</body>
</html>