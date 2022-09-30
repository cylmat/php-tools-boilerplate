<?php

/**
 *  Deployer
 * @see https://deployer.org
 *
 * Usage:
 * - bin/dep deploy prod --hosts prod:pre:local --roles build,test_role
 * - bin/dep ssh
 * - bin/dep rollback
 */

namespace Deployer;

require 'recipe/common.php';

/**
 * Read .env files
 */
foreach ([__DIR__ . '/../.env', __DIR__ . '/../.env.local', __DIR__ . '/../.env.deploy'] as $env) {
    if (\file_exists($env) && $env = new SplFileObject($env)) {
        foreach ($env as $line) {
            if (preg_match('/^APPLICATION_NAME|VCS_REPOSITORY|REMOTE_HOST|BRANCH_NAME/', $line)) {
                putenv($line);
            }
        }
    }
}

$APPLICATION_NAME = $_ENV['APPLICATION_NAME'] ?? getenv('APPLICATION_NAME') ?? null;
$VCS_REPOSITORY = $_ENV['VCS_REPOSITORY'] ?? getenv('VCS_REPOSITORY') ?? null;
$REMOTE_HOST = $_ENV['REMOTE_HOST'] ?? getenv('REMOTE_HOST') ?? null;
$BRANCH_NAME = $_ENV['BRANCH_NAME'] ?? getenv('BRANCH_NAME') ?? 'main'; // optional

if (!$APPLICATION_NAME || !$VCS_REPOSITORY || !$REMOTE_HOST) {
    throw new \Exception("Impossible to find constants, neither in .env(.local) file nor in environment.");
}

/* MAIN PARAMS */

// Project name //
set('application', $APPLICATION_NAME);
set('branch', $BRANCH_NAME);

// Stage //
set('default_stage', 'prod');
set('deploy_path', '{{target_directory}}{{application}}');
set('repository', $VCS_REPOSITORY);
set('target_directory', '~/{{application}}');
set('user', function () {
    return runLocally('git config --get user.name');
});

// OTHERS //
set('allow_anonymous_stats', false);
set('clear_paths', []);
set('clear_use_sudo', false);
set('cleanup_use_sudo', false);
set('copy_dirs', []);
set('env', []);
set('git_tty', false); // [Optional] Allocate tty for git clone. Default value is false.
set('keep_releases', 10);
set('shared_dirs', ['vendor', 'logs', 'var']);

/* STAGES */

host($REMOTE_HOST)
    //->alias('prod')
    //->hostname($REMOTE_HOST)
    ->set('deploy_path', '~/{{application}}')
    ->set('branch', $BRANCH_NAME)
    //->port(22)
    /*->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no');*/
;

/* CUSTOM TASKS */

task('custom:upload', function () {
    upload(__DIR__ . "/", '{{release_path}}');
});

task('commit:hash', function () {
    run("cd {{release_path}} && echo $(git rev-parse HEAD) > ./public/COMMIT_ID");
});

task('cache:clear', function () {
    $php_bin_path = '/usr/local/php7.4/bin/php';
    run("cd {{release_path}} && rm var/cache/* -rf");
    run("cd {{release_path}} && $php_bin_path bin/console cache:clear");
    run("cd {{release_path}} && $php_bin_path bin/composer dump-autoload");
});

/* RUN TASKS */

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'custom:upload',
    'deploy:shared',
    'deploy:clear_paths',
    'deploy:symlink',
    'commit:hash',
    'cache:clear',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock'); // run after task, can be "before"
fail('deploy:release', 'deploy:unlock');
