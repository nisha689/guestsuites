<head>
  <title><?php echo $__env->yieldContent('title', trans('admin.front_title')); ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name='robots' content='index,follow'>
  <meta name="url" content="<?php echo e(url()->current()); ?>">
  <meta name="identifier-URL" content="<?php echo e(url()->current()); ?>">
  <link rel="canonical" href="<?php echo e(url()->current()); ?>">
  <meta property="og:url" content="<?php echo e(url()->current()); ?>">
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="@Kidrend">
  <meta name="twitter:url" content="<?php echo e(url()->current()); ?>">

  <?php echo $__env->make('partials.meta-tags', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <?php echo $__env->yieldContent('meta'); ?>
  <link rel="shortcut icon" href="<?php echo e(url('favicon.ico')); ?>">
  <link rel="stylesheet" href="<?php echo e(url('common/css/bootstrap.min.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" media="all">
  <link rel="stylesheet" href="<?php echo e(url('common/css/font-awesome-all.css')); ?>" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
        crossorigin="anonymous">
 <!-- <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Montserrat:300,400,500,600,700,800" rel="stylesheet">-->
   <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Poppins:400,500,600,700&display=swap"
        rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="<?php echo e(url('common/css/font-awesome.min.css')); ?>">
  <link type="text/css" rel="stylesheet" href="<?php echo e(url('admin/css/style.css')); ?>">
  <link type="text/css" rel="stylesheet" href="<?php echo e(url('common/css/jquery.datetimepicker.css')); ?>">

  <!--valiation-->
  <link type="text/css" rel="stylesheet" href="<?php echo e(url('common/css/parsley.css')); ?>">

 <link type="text/css" rel="stylesheet" href="<?php echo e(url('common/css/datepicker.css')); ?>">
 <link rel="stylesheet" href="<?php echo e(url('common/css/jquery-ui.min.css')); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo e(url('common/css/timepicki.css')); ?>">
 <link rel="stylesheet" href="<?php echo e(url('common/css/jquery.multiselect.css')); ?>">
  <!--common-->
  <link type="text/css" rel="stylesheet" href="<?php echo e(url('common/css/common.css')); ?>">
  <!--<link type="text/css" rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">-->
  <?php echo $__env->yieldContent('stylesheet'); ?>
</head>
