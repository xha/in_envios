<aside class="main-sidebar">

    <section class="sidebar">
        <?php
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'icon' => 'circle-o', 'url' => ['../web/site/login']];
                $menuItems[] = ['label' => 'Recuperar Usuario', 'icon' => 'unlock', 'url' => ['../web/site/recuperar']];
            } else {
                $menuItems[] = ['label' => 'Configuración', 'icon' => 'circle-o', 'url' => '#',
                                    'items' => [
                                        ['label' => 'Registro', 'icon' => 'check', 'url' => ['../web/site/register']],
                                        ['label' => 'Accion', 'icon' => 'check', 'url' => ['../web/accion']],
                                        ['label' => 'Rol', 'icon' => 'check', 'url' => ['../web/rol']],
                                        ['label' => 'Rol - Accion', 'icon' => 'check', 'url' => ['../web/rol-accion']],
                                        ['label' => 'Recuperar Usuario', 'icon' => 'check', 'url' => ['../web/site/recuperar']],
                                        ['label' => 'Activar Usuario', 'icon' => 'check', 'url' => ['../web/site/activar']],
                                        ['label' => 'Cambiar Clave', 'icon' => 'check', 'url' => ['../web/site/cambiar']],
                                ],];
                $menuItems[] = ['label' => 'Tablas Básicas', 'icon' => 'folder-o', 'url' => '#',
                                    'items' => [
                                        ['label' => 'Conceptos', 'icon' => 'check', 'url' => ['../web/conceptos']],
                                        ['label' => 'Bancos', 'icon' => 'check', 'url' => ['../web/bancos']],
                                        ['label' => 'Cuentas Bancarias', 'icon' => 'check', 'url' => ['../web/cuentas-bancarias']],
                                ],];
                $menuItems[] = ['label' => 'Enviar correo', 'icon' => 'envelope', 'url' => ['../web/site']];
                $menuItems[] = ['label' => 'Reporte', 'icon' => 'file', 'url' => '#',
                                    'items' => [
                                        ['label' => 'Correos enviados', 'icon' => 'check', 'url' => ['site/reporte-enviados']],
                                        ['label' => 'Clientes sin correo', 'icon' => 'check', 'url' => ['site/reporte-correos']],
                                ],];
            }
        ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $menuItems,
            ]
        ) ?>

    </section>

</aside>
