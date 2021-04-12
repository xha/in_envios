<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    $this->registerCssFile('@web/css/jquery.loadingModal.css');
    $this->registerJsFile('@web/js/jquery.loadingModal.js');
    app\assets\AppAsset::register($this);
    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        
        <?php $this->head() ?>
    </head>
    <body class="<?= \dmstr\helpers\AdminLteHelper::skinClass() ?> hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php 
        $this->endBody();
        $this->registerJsFile('@web/datatables/datatables.js');
        $this->registerJsFile('@web/datatables/dataTables.checkboxes.js');
    ?>
    </body>
    </html>
    <script type="text/javascript">
        $(document).on('ajaxStart', function () {
            loading_show();
        });

        $(document).on('ajaxStop', function (start) {
            loading_hide();
        });

        function loading_show() {
            $('body').loadingModal({
                text: 'Por favor espere',
                animation: 'circle',
            });
            $('body').loadingModal('show');
        }

        function loading_hide() {
            $('body').loadingModal('hide');
        }

        function presiona(e, funcion) {
            var tecla = (document.all) ? event.keyCode : e.which;
            if (tecla == 13) {
                funcion();
            }
        }
    </script>
    <?php $this->endPage() ?>
<?php } ?>
