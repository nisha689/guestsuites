<?php if(!empty( $metaTitle )): ?>
    <meta name="title" content="<?php echo e($metaTitle); ?>">
    <meta property="og:title" content="<?php echo e($metaTitle); ?>">
    <meta name="twitter:title" content="<?php echo e($metaTitle); ?>">
    <meta itemprop="name" content="<?php echo e($metaTitle); ?>">
<?php endif; ?>
<?php if(!empty( $metaKeyword )): ?>
    <meta name="keywords" content="<?php echo e($metaKeyword); ?>">
<?php endif; ?>
<?php if(!empty( $metaDescription )): ?>
    <meta name="description" content="<?php echo e($metaDescription); ?>">
    <meta property="og:description" content="<?php echo e($metaDescription); ?>">
    <meta name="twitter:description" content="<?php echo e($metaDescription); ?>">
<?php endif; ?>
<?php if(!empty($metaImage)): ?>
    <meta property="og:image" content="<?php echo e($metaImage); ?>">
    <meta itemprop="image" content="<?php echo e($metaImage); ?>">
    <meta name="twitter:image" content="<?php echo e($metaImage); ?>">
<?php endif; ?>