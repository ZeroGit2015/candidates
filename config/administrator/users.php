<?php

  /**
   * Users model config
   */

  return array(

      'title' => 'Users',
      'single' => 'user',
      'model' => 'App\User',

      'columns' => array(
          'id' => array(
              'title' => 'id',
          ),
          'email' => array(
              'title' => 'Email',
          ),
          'name' => array(
              'title' => 'Ф.И.О.',
          ),
      ),

      'edit_fields' => array(
          'email' => array(
              'title' => 'Email',
              'type' => 'text',
          ),
          'name' => array(
              'title' => 'Ф.И.О.',
              'type' => 'text',
          ),
          'role' => array(
              'title' => 'Роль',
              'type' => 'text',
          ),
          'password' => array(
              'title' => 'Пароль',
              'type' => 'password',
          ),
      ),

  );