<?php
namespace Deployer;

require 'recipe/common.php';

/**
 * Deployer
 * https://deployer.org
 * 
 * Config
 * https://deployer.org/docs/configuration.html
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
 * dep config:current
 * dep config:dump
 * dep config:hosts
 * dep deploy (--tag="v0.1") (--revision="5daefb59edbaa75")
 * dep deploy prod --hosts prod:pre:local --roles build,test_role
 * dep my_custom_task
 * dep rollback
 * dep run '<shell_command>'
 * dep ssh (connect to host)
 * 
 * dep help deploy
 */

/*********
 * Params
 */

// MAIN PARAMS //

// Project name
set('application', 'my_sample_project');

set('branch', 'main');

// Callback allowed
set('current_path', function () {
    return run('pwd');
});

// Stage
set('default_stage', 'test');

set('deploy_path', '{{target_directory}}{{application}}'); 

// Project repository
if (!getenv('VCS_REPOSITORY')) {
    echo 'export VCS_REPOSITORY="http://<vcs>/<vendor>/<repo>.git", must be set.'."\n";
    exit(1);
}
set('repository', $_ENV['VCS_REPOSITORY']);

set('target_directory', '/tmp/deployer/');

// User
set('user', function () {
    return runLocally('git config --get user.name');
});

// OTHERS //

set('allow_anonymous_stats', false);

// Deleted paths after release
set('clear_paths', []);

set('clear_use_sudo', false);

set('cleanup_use_sudo', false);

set('composer_action', 'install'); //default install

set('copy_dirs', []);

set('env', [
    'VARIABLE' => 'value',
]);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false); 

// Keeps the last 5 releases by default
set('keep_releases', 5);

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', ['logs','var']);

// Writable dirs by web server 
set('writable_dirs', []);

// chmod, chown, chgrp, default to acl
set('writable_mode', 'acl');
set('writable_use_sudo', false); //default false

/********
 * Hosts sample
 * https://deployer.org/docs/hosts.html
 */

localhost('local')
    ->stage('test')
    ->roles('test_role', 'build_role', 'db');

// host('prod')
//     ->hostname('sample.host')
//     ->set('deploy_path', '/var/www/var/deployer/{{application}}');
//     ->set('branch', 'production');    
//     ->user('name')
//     ->port(22)
//     ->configFile('~/.ssh/config') //connecting information for hosts
//     ->identityFile('~/.ssh/id_rsa')
//     ->forwardAgent(true)
//     ->multiplexing(true)
//     ->addSshOption('UserKnownHostsFile', '/dev/null')
//     ->addSshOption('StrictHostKeyChecking', 'no');

/********
 * Tasks
 * https://deployer.org/docs/tasks.html
 */

// Config task //

desc('My task');
task('my_custom_task', function () {
    $param = get('user');
    if (test('[ -d {{release_path}} ]')) {
        $path = run('readlink {{deploy_path}}/current');
        run("echo $path"); // run shell command

        writeln('<comment>My comment</comment><info>...</info><error></error>');

        // Upload files from $source to $destination on the remote host.
        // upload('build/', '{{release_path}}/public');
        // download('source', 'destination', ['config']);
    }
    on(roles('app'), function ($host) {
        echo 'On task';
    });
    on(Deployer::get()->hosts, function ($host) {
        echo 'On task';
    });
    invoke('deploy:info'); 
})
// filter by stage, roles, hosts
->onStage('test')->onRoles('db')->onHosts('local')
// run on the first host only
->once()->local();

desc("Simple task");
// We can override deployer task (ex: deploy:update_code)
task("phpunit", '
    echo "Exec PhpUnit";
');

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
after('deploy:failed', 'deploy:unlock'); // run after task, can be "before"
fail('deploy:release', 'deploy:unlock');
