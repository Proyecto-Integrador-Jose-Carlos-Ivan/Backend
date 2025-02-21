<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://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@github.com/Proyecto-Integrador-Jose-Carlos-Ivan/Backend.git');

set('branch', 'develop');

add('shared_files', ['.env']);

// Hosts toca cambiar la ip por la de nuestro servidor, el usuario por el nuestro y la clave por la nuestra y el deploy path
host('3.220.165.74')
    ->set('remote_user', 'deployer')
    ->set('identity_file', '/home/jose/Descargas/Clave-Proyecto.pem')
    ->set('deploy_path', '/var/www/Backend');

// Tasks
task('upload:env', function () {
    upload('.env.production', '{{deploy_path}}/shared/.env');
})->desc('Environment setup');

task('build', function () {
    run('cd {{release_path}} && npm install');
    run('cd {{release_path}} && npm run build');
});

task('artisan:migrate:fresh:seed', function () {
    run('{{bin/php}} {{release_path}}/artisan migrate:fresh --seed --force');
})->desc('Ejecutar migrate:fresh con seed');

task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php8.3-fpm restart');
});

task('deploy:vendors', function () {
    run('cd {{release_path}} && composer install --optimize-autoloader');
});

task('generate:swagger', function () {
    run('{{bin/php}} {{release_path}}/artisan l5-swagger:generate');
})->desc('Generate Swagger documentation');

// task('artisan:queue:work', function () {
//     run('{{bin/php}} {{release_path}}/artisan queue:work');
//  })->desc('Ejecutar queue:work');

// task('artisan:queue:restart', function () {
//     run('{{php}} {{release_path}}/artisan queue:work');
// })->desc('Restart queue workers');

task('artisan:queue:work', function () {
    run('{{bin/php}} {{release_path}}/artisan queue:listen');
})->desc('Ejecutar queue:work en segundo plano');

// Hooks
before('deploy:shared', 'upload:env');
before('deploy:symlink', 'artisan:migrate:fresh:seed');
// before('deploy:writable', 'deploy:install_acl');
before('deploy:symlink', 'deploy:vendors');
before('deploy:symlink', 'build');
// after('reload:php-fpm', 'artisan:queue:work');
after('deploy', 'artisan:queue:work');
// after('deploy', 'artisan:queue:work');
after('deploy', 'generate:swagger');


after('deploy', 'reload:php-fpm');
after('deploy:failed', 'deploy:unlock');