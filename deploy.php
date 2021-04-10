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

if (!getenv('VCS_REPOSITORY')) {
    echo 'export VCS_REPOSITORY="http://<vcs>/<vendor>/<repo>.git", must be set.'."\n";
    exit(1);
}

// $REPOSITORY https://user:pass@git-repo.com
$REPOSITORY = getenv('REPOSITORY');
// $REMOTE_HOST user@ssh.host.com
$REMOTE_HOST = getenv('REMOTE_HOST');

// MAIN PARAMS //

// Project name
set('application', 'my_sample_project');

// Callback allowed
set('current_path', function () {
    return run('pwd');
});

// Stage
set('default_stage', 'test');
set('target_directory', '~/');
set('deploy_path', '{{target_directory}}{{application}}'); 

// Project repository //
set('branch', 'main');
set('repository', $REPOSITORY);

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
set('shared_dirs', ['logs', 'var']);

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

/*host('prod')
    ->hostname($REMOTE_HOST)
    ->set('deploy_path', '{{target_directory}}{{application}}');
    ->set('branch', 'production');    
    ->user('name')
    ->port(22)
    ->configFile('~/.ssh/config') //connecting information for hosts
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no');*/

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

        writeln('<comment>Composer validation</comment><info>...</info><error></error>');
        run('composer validate');
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


desc("Manually upload task");
task('local:upload', function () {
    upload(__DIR__ . "/", '{{release_path}}');
});

desc("Simlink host .env");
task('link:env', function () {
    $src_env = '{{deploy_path}}/.env';
    $target_env = "{{release_path}}/.env";
    
    if (test("test -f $src_env")) {
        run("ln -s $src_env $target_env");
    }
});

// Run tasks //
$deploy_upload = ['deploy:update_code', 'local:upload'][1];

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    
    $deploy_upload,
    
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    
    // uncomment if needed
    // 'link:env',
    
    'deploy:unlock',
    'cleanup',
    'success'
]);

/*********
 * Orders
 */

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock'); // run after task, can be "before"
fail('*', 'deploy:unlock');


/**********************
 *  PREFIX PREVIOUS   *
 * Avoid host caching *
 *********************/
before('cleanup', 'prefix_previous');
before('rollback', 'unprefix_previous_rollback');

task('prefix_previous', function () {
    if (!isset(get('releases_list')[1])) return;
    $previous = get('releases_list')[1];
    $path = "{{deploy_path}}/releases";

    if (test("test -d $path/$previous")) {
        if (test("test -d $path/_$previous")) {
            run("rm -rf $path/_$previous");
        }
        run("mv $path/$previous $path/_$previous");
    }
});

task('unprefix_previous_rollback', function () {
    $path = "{{deploy_path}}/releases";

    // unprefix all
    run('cd '.$path.' && for x in $(ls -1 | grep "_"); do mv $x $(echo $x | sed -e "s/_//"); done;');
    if (!isset(get('releases_list')[1])) return;
    $previous = get('releases_list')[1];

    if (test("test -d $path/_$previous")) {
        if (test("test -d $path/$previous")) {
            run("rm -rf $path/$previous");
        }
        run("mv $path/_$previous $path/$previous");
    }
});
