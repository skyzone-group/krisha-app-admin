<?php

return [
    'userManagement' => [
        'title'          => 'Управление пользователями',
        'title_singular' => 'Управление',
    ],
    'permission'     => [
        'title'          => 'Управление разрешениями',
        'title_singular' => 'Разрешение',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Комментарий',
            'name'              => 'Название',
            'roles'             => 'Роли',
            'permissions'       => 'Разрешения',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role'           => [
        'title'          => 'Управление ролями',
        'title_singular' => 'Роль',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'roles'             => 'Роли',
            'title'             => 'Комментарий',
            'name'              => 'Название',
            'title_helper'       => ' ',
            'permissions'        => 'Разрешение рола',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user'           => [
        'title'          => 'Пользователи',
        'title_singular' => 'Пользователь',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Имя',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Пароль',
            'password_helper'          => ' ',
            'roles'                    => 'Роли',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
        ],
    ],
    'region'           => [
        'title'          => 'Регионы',
        'title_singular' => 'Регионы',
        'fields'         => [
            'id'            => 'ID',
            'name'          => 'Название',
            'country_name_ru' => 'Название страны',
        ],
    ],
    'district'           => [
        'title'          => 'Районы',
        'title_singular' => 'Районы',
        'fields'         => [
            'id'                => 'ID',
            'name'              => 'Название',
            'region_name_ru'    => 'Название региона',
            'district_name_ru'  => 'Название района',
        ],
    ],
    'quarter'           => [
        'title'          => 'Кварталы',
        'title_singular' => 'Кварталы',
        'fields'         => [
            'id'                => 'ID',
            'name'              => 'Название',
            'district_name_ru'  => 'Название района',
            'quarter_name_ru'   => 'Название квартал',
        ],
    ],
    'item'           => [
        'title'          => 'Items',
        'title_singular' => 'Items',
        'fields'         => [
            'id'            => 'ID',
            'name'          => 'Название',
        ],
    ],
    'key'           => [
        'title'          => 'Keys',
        'title_singular' => 'Keys',
        'fields'         => [
            'id'                    => 'ID',
            'name'                  => 'Название',
            'category_key_name'     => 'Нед.. типы',
            'key_name'              => 'Key for mobile API',
            'type'                  => 'type => sinle | multiple',
            'single'                => 'Single',
            'multiple'              => 'Multiple',
            'comment'               => 'Комментарий',
            'items'                 => 'Items',
            'change_items_order'    => 'Изменить положение параметров',
            'params'                => 'Параметры',
        ],
    ],
    'story'           => [
        'title'          => 'Story',
        'title_singular' => 'Story',
        'fields'         => [
            'id'            => 'ID',
            'name'          => 'Название',
        ],
    ],
    'story-category'           => [
        'title'          => 'story-category',
        'title_singular' => 'story-category',
        'fields'         => [
            'id'            => 'ID',
            'title'          => 'Название',
            'photo' => 'PHOTO'
        ],
    ],
    'story-item'           => [
        'title'          => 'story-item',
        'title_singular' => 'story-item',
        'fields'         => [
            'id'            => 'ID',
            'story_category_id'            => 'story_category_id',
            'title'             => 'title',
            'subtitle'          => 'subtitle',
            'file' => 'file (photo or video)',
            'estate_id' => 'estate_id',
            'link' => 'link'
        ],
    ],
    'sidebar-jk'           => [
        'title'          => 'JK & Застройщик',
        'title_singular' => 'JK & Застройщик',
        'fields'         => [
            'id'            => 'ID',
            'name'          => 'Название',
        ],
    ],
    'developer'           => [
        'title'          => 'Застройщик',
        'title_singular' => 'Застройщик',
        'fields'         => [
            'id'            => 'ID',
            'name'          => 'Название',
        ],
    ],

];
