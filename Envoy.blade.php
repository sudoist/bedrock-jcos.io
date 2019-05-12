@servers(['web' => $user.'@'.$host,'localhost' => '127.0.0.1'])

@setup
// Sanity checks
if (empty($host)) {
    exit('ERROR: $host var empty or not defined');
}

if (empty($user)) {
    exit('ERROR: $user var empty or not defined');
}

if (empty($php)) {
    exit('ERROR: $php var empty or not defined');
}

if (empty($code_directory)) {
    exit('ERROR: $code_directory var empty or not defined');
}

// Command or path to invoke PHP
$php = empty($php) ? 'php' : $php;
@endsetup

@story('deployBranch')
    pipeline_task
    server_task
@endstory

@task('pipeline_task', ['on' => 'localhost'])
    echo "* Running deployBranch on the Bitbucket Pipeline server *"
    hostname
{{-- Run tests here later --}}
@endtask

@task('server_task', ['on' => 'web'])
    echo "* Running deployBranch on the remote server *"
    cd {{ $code_directory }}
    @if ($branch)
        git pull origin {{ $branch }}
        composer update
    @endif
@endtask
