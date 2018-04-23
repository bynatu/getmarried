<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, user-scalable=no"/>
    <title>
        <?php echo $this->fetch('title'); ?>
    </title>
    <?php
    echo $this->Html->meta('icon', '/img/anillo.ico', array('type' => 'icon'));
    echo $this->Html->css('../js/lib/bootstrap/css/bootstrap.css');
    echo $this->Html->css('../js/lib/bootstrap/css/bootstrap-theme.css');
    echo $this->Html->css('../js/lib/sweetalert/dist/sweetalert2.min.css');
    echo $this->Html->css('../js/lib/jquery-ui-1.10.4/themes/base/minified/jquery-ui.min.css');
    echo $this->Html->css('estilos.css');
    echo $this->Html->css('alerts.css');
    echo $this->Html->script('../js/lib/jquery/jquery-3.3.1.min.js');
    echo $this->Html->script('../js/lib/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js');
    echo $this->Html->script('../js/lib/bootstrap/js/bootstrap.js');
    echo $this->Html->script('../js/lib/sweetalert/dist/sweetalert2.min.js');
    echo $this->Html->script('../js/fecha.js');
    echo $this->Html->script('../js/fecha.js');
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js"
            integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl"
            crossorigin="anonymous"></script>
            <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div id="container">
    <header>
        <?php echo $this->element('Comun/menu'); ?>
    </header>
    <div id="content">

        <?php echo $this->Flash->render(); ?>

        <?php echo $this->fetch('content'); ?>
    </div>
    <footer>
        <div class="options"><a href="tel:+34-677-895-220" class="fas fa-phone-volume"></a><span>677895220</span></div>
        <div class="options"><a href="mailto:quetecasas@gmail.com" class="fas fa-envelope"></a><span>quetecasas@gmail.com</span>
        </div>
    </footer>
</div>
</body>
</html>
