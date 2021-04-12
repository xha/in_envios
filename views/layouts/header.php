<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">Mod.</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">
        <div class="col-sm-4 left">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </div>
        <div class="col-sm-8">
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php  
                        if (Yii::$app->user->isGuest) {
                        } else {
                    ?>    
                    <li class="dropdown user user-menu">
                        <?= Html::a(
                            'Logout (Usuario: '.Yii::$app->user->identity->usuario.')',
                            ['/site/logout'],
                            ['data-method' => 'post']
                        ) ?>
                    </li>
                    <?php 
                        };
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
