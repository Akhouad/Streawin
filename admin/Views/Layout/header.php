<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administration - Streawin</title>

    <link href="<?php echo getFileURL('admin/Public' . DS . 'css' . DS . 'bootstrap.min.css') ?>" rel="stylesheet">


    <script type="text/javascript" src="<?php echo getFileURL('admin/Public' . DS . 'js' . DS . 'jquery.js') ?>"></script>
    <script type="text/javascript" src="<?php echo getFileURL('admin/Public' . DS . 'js' . DS . 'app.js') ?>"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

        
    <style type="text/css">
        .container{width:90%;}
    </style>
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo getLink("",[],true) ?>">Administration</a>
          <a class="navbar-brand" target="_blank" href="<?php echo getLink("",[]) ?>">Website</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse" style="float:right;">
          <ul class="nav navbar-nav" style="width:100%">
        <?php if($p != "login") : ?>
            <li><a href="<?php echo getLink("home",[], true) ?>">Home</a></li>
            <li><a href="<?php echo getLink("add-series",[], true) ?>">Add series</a></li>
            <li><a href="<?php echo getLink("add-media",[], true) ?>">Add media</a></li>
            <li><a href="<?php echo getLink("messages",[],true) ?>">Messages</a></li>
            <?php if(isset($_SESSION["auth"]) && $_SESSION["auth"]->level == "admin"): ?>
              <li><a href="<?php echo getLink("logout",[],true) ?>" class="btn btn-link">
                <span class="glyphicon glyphicon-remove"></span>
              </a></li>
            <?php endif; ?>
        <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style="margin-top:80px;">