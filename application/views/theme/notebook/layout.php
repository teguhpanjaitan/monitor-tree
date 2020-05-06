<!DOCTYPE html>
<html lang="en" class="app">

<head>
  <meta charset="utf-8" />
  <title>Aplikasi Monitoring Tree</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook") ?>/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook/") ?>/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook/") ?>/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook/") ?>/css/font.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook/") ?>/js/calendar/bootstrap_calendar.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook/") ?>/css/app.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook/") ?>/js/datatables/datatables.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook/") ?>/js/datepicker/datepicker.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/custom.css") ?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url("assets/notebook/") ?>/js/select2/select2.css" type="text/css" />
  <!--[if lt IE 9]>
    <script src="<?php echo base_url("assets/notebook/") ?>/js/ie/html5shiv.js"></script>
    <script src="<?php echo base_url("assets/notebook/") ?>/js/ie/respond.min.js"></script>
    <script src="<?php echo base_url("assets/notebook/") ?>/js/ie/excanvas.js"></script>
  <![endif]-->
</head>

<body class="">
  <section class="vbox">
    <?php echo $header ?>
    <section>
      <section class="hbox stretch">
        <?php echo $sidebar ?>
        <section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <?php echo $content ?>
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
        </section>
        <aside class="bg-light lter b-l aside-md hide" id="notes">
          <div class="wrapper">Notification</div>
        </aside>
      </section>
    </section>
  </section>
  <?php echo $footer ?>
</body>

</html>