<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => 'Основное',
                        'icon' => 'home',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Настройки', 'icon' => 'cogs', 'url' => ['/admin/settings/default/update'],],
                            ['label' => 'Логи', 'icon' => 'list-alt', 'url' => ['/admin/logs_admin/default/index'],],
                        ],
                    ],
                    ['label' => 'Страницы', 'icon' => 'file-text-o', 'url' => ['/admin/page/default/index']],
                    ['label' => 'Пользователи', 'icon' => 'user-o', 'url' => ['/admin/user/default/index']],

                ],
            ]
        ) ?>

    </section>

</aside>
