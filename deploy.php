<?php
namespace Deployer;

require 'recipe/common.php';

/**
 * Deployer
 * https://deployer.org
 */
/* 
 * Will create on host:
 *   releases/ contains releases dirs,
 *   share/    contains shared files and dirs,
 *   current/  symlink to current release.
 */

/**
 * CLI usage
 *
 * dep deploy
 * dep rollback
 * dep run '<shell_command>'
 * dep ssh (connect to host)
 * 
 * dep help deploy
 */

/*********
 * Params
 */

// Project name
set('application', 'my_sample_project');
set('target_directory', '/tmp/deployer/');

// Project repository
// export DEPLOYER_REPOSITORY=<http://my_repository>
if (!isset($_ENV['DEPLOYER_REPOSITORY'])) {
    echo 'export DEPLOYER_REPOSITORY="http://<vsc>/<vendor>/<repo>.git" must be set.'."\n";
    exit(1);
}

set('repository', $_ENV['DEPLOYER_REPOSITORY']);

// keeps the last 5 releases by default
set('keep_releases', 5);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server 
set('writable_dirs', []);
set('allow_anonymous_stats', false);

/********
 * Hosts
 */

# host('http://sample.host')
#    ->set('deploy_path', '/var/www/var/deployer/{{application}}');    
set('deploy_path', '{{target_directory}}{{application}}');  

/********
 * Tasks
 */

// Config task //

/*task('my_task', function () {
    $param = get('my_param');
});*/

// Run tasks //

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

/*********
 * Orders
 */

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
after('cleanup', 'success');
