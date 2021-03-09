<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'my_sample_project');
set('application_directory', '/tmp/deployer/');

// Project repository
// export DEPLOYER_REPOSITORY=<http://my_repository>
if (!isset($_ENV['DEPLOYER_REPOSITORY'])) {
    exit(1);
}

set('repository', $_ENV['DEPLOYER_REPOSITORY']);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server 
set('writable_dirs', []);
set('allow_anonymous_stats', false);

/** 
 * Hosts
 */

# host('http://sample.host')
#    ->set('deploy_path', '/var/www/var/deployer/{{application}}');    
set('deploy_path', '{{application_directory}}{{application}}');  

/**
 * Tasks
 */

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
