<?php

namespace Deployer;

require 'recipe/common.php';

// Config

set('repository', 'https://github.com/cylmat/phpconfig.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('my_host_ovh')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/symfony');

// Hooks

after('deploy:failed', 'deploy:unlock');
