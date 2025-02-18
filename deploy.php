<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/Proyecto-Integrador-Jose-Carlos-Ivan/Backend.git');

set('branch', 'develop');

add('shared_files', ['.env']);

// Hosts toca cambiar la ip por la de nuestro servidor, el usuario por el nuestro y la clave por la nuestra y el deploy path
host('23.21.148.130') 
    ->set('remote_user', 'prod-ud4-deployer')
    ->set('identity_file', '~/Descargas/todo/servidor/lemp/lemp.pem')
    ->set('deploy_path', '/var/www/prod-ud4-a4/html');

// Tasks
task('upload:env', function () {
    upload('.env.production', '{{deploy_path}}/shared/.env');
    })->desc('Environment setup');

task('build', function () {
    run('cd {{release_path}} && build');
    });

task('artisan:migrate:fresh:seed', function () {
    run('{{bin/php}} {{release_path}}/artisan migrate:fresh --seed --force');
    })->desc('Ejecutar migrate:fresh con seed');

task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php8.3-fpm restart');
    });

// Hooks
before('deploy:shared', 'upload:env');
before('deploy:symlink', 'artisan:migrate:fresh:seed');
after('deploy', 'reload:php-fpm');
after('deploy:failed', 'deploy:unlock');
