<!DOCTYPE html>
<html lang="es">
<head>
    <?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <title>
        <?php echo $this->fetch('title'); ?>
    </title>
    <?php
    echo $this->Html->meta('icon', '/img/anillo.ico');
    echo $this->Html->css('../js/lib/bootstrap/css/bootstrap.css');
    echo $this->Html->css('../js/lib/bootstrap/css/bootstrap-theme.css');
    echo $this->Html->css('../js/lib/sweetalert/dist/sweetalert2.min.css');
    echo $this->Html->css('../js/lib/stacktable/css/stacktable.css');
    echo $this->Html->css('../js/lib/jquery-ui-1.10.4/themes/base/minified/jquery-ui.min.css');
    echo $this->Html->css('borrar.css');
    echo $this->Html->css('generales.css');
    echo $this->Html->css('tabs.css');
    echo $this->Html->css('estilos.css');
    echo $this->Html->css('alerts.css');
    echo $this->Html->script('../js/lib/jquery/jquery-3.3.1.min.js');
    echo $this->Html->script('../js/lib/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js');
    echo $this->Html->script('../js/lib/bootstrap/js/bootstrap.js');
    echo $this->Html->script('../js/lib/sweetalert/dist/sweetalert2.min.js');
    echo $this->Html->script('../js/lib/stacktable/js/stacktable.js');
    echo $this->Html->script('../js/lib/stacktable/js/tableresponsive.js');
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
        <div class="options"><a href="mailto:getmarried9418@gmail.com" class="fas fa-envelope"></a><span>getmarried9418@gmail.com</span>
        </div>
        <div class="options">
            <a href="https://www.facebook.com/Getmarried-289660978234985/" title="Facebook" target="_blank"> <i
                    class="fab fa-facebook-square facebook fondoblanco"></i> </a>
            <a href="https://www.instagram.com/married.get/?hl=es" title="Instagram" target="_blank"> <i
                    class="fab fa-instagram instagram"></i> </a>
            <a href="https://twitter.com/Getmarried9418" title="Twitter" target="_blank"> <i
                    class="fab fa-twitter twitter"></i> </a>
            <a href="https://api.whatsapp.com/send?phone=34677895220" title="WhatsApp" target="_blank"> <i
                    class="fab fa-whatsapp"></i> </a>
        </div>
    </footer>
</div>
</body>
</html>
