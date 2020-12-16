<?php return array (
  'app' =>
  array (
    'name' => 'Laravel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost',
    'asset_url' => NULL,
    'timezone' => 'UTC',
    'locale' => 'ar',
    'fallback_locale' => 'ar',
    'faker_locale' => 'en_US',
    'key' => 'base64:5rnRMIYbbQ7psIxV+kWLfzYx5+KvK6NX+sKV9qo+Gkc=',
    'cipher' => 'AES-256-CBC',
    'providers' =>
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
      23 => 'Yajra\\DataTables\\DataTablesServiceProvider',
      24 => 'LaraIzitoast\\LaraIzitoastServiceProvider',
      25 => 'Yajra\\DataTables\\ButtonsServiceProvider',
      26 => 'App\\Providers\\AppServiceProvider',
      27 => 'App\\Providers\\AuthServiceProvider',
      28 => 'App\\Providers\\EventServiceProvider',
      29 => 'App\\Providers\\RouteServiceProvider',
    ),
    'aliases' =>
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
      'DataTables' => 'Yajra\\DataTables\\Facades\\DataTables',
    ),
  ),
  'auth' =>
  array (
    'defaults' =>
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' =>
    array (
      'web' =>
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' =>
      array (
        'driver' => 'token',
        'provider' => 'users',
        'hash' => false,
      ),
    ),
    'providers' =>
    array (
      'users' =>
      array (
        'driver' => 'eloquent',
        'model' => 'App\\User',
      ),
    ),
    'passwords' =>
    array (
      'users' =>
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'broadcasting' =>
  array (
    'default' => 'log',
    'connections' =>
    array (
      'pusher' =>
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' =>
        array (
          'cluster' => 'mt1',
          'encrypted' => true,
        ),
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' =>
      array (
        'driver' => 'log',
      ),
      'null' =>
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' =>
  array (
    'default' => 'file',
    'stores' =>
    array (
      'apc' =>
      array (
        'driver' => 'apc',
      ),
      'array' =>
      array (
        'driver' => 'array',
      ),
      'database' =>
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' =>
      array (
        'driver' => 'file',
        'path' => 'C:\\xampp\\htdocs\\fci-lms\\storage\\framework/cache/data',
      ),
      'memcached' =>
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' =>
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' =>
        array (
        ),
        'servers' =>
        array (
          0 =>
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'cache',
      ),
      'dynamodb' =>
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
    ),
    'prefix' => 'laravel_cache',
  ),
  'database' =>
  array (
    'default' => 'mysql',
    'connections' =>
    array (
      'sqlite' =>
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'fcis-medical',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' =>
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'fcis-medical',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' =>
        array (
        ),
      ),
      'pgsql' =>
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'fcis-medical',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' =>
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'fcis-medical',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' =>
    array (
      'client' => 'predis',
      'options' =>
      array (
        'cluster' => 'predis',
        'prefix' => 'laravel_database_',
      ),
      'default' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 0,
      ),
      'cache' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 1,
      ),
    ),
  ),
  'datatables-buttons' =>
  array (
    'namespace' =>
    array (
      'base' => 'DataTables',
      'model' => '',
    ),
    'pdf_generator' => 'snappy',
    'snappy' =>
    array (
      'options' =>
      array (
        'no-outline' => true,
        'margin-left' => '0',
        'margin-right' => '0',
        'margin-top' => '10mm',
        'margin-bottom' => '10mm',
      ),
      'orientation' => 'landscape',
    ),
    'parameters' =>
    array (
      'dom' => 'Bfrtip',
      'order' =>
      array (
        0 =>
        array (
          0 => 0,
          1 => 'desc',
        ),
      ),
      'buttons' =>
      array (
        0 => 'create',
        1 => 'export',
        2 => 'print',
        3 => 'reset',
        4 => 'reload',
      ),
    ),
    'generator' =>
    array (
      'columns' => 'id,add your columns,created_at,updated_at',
      'buttons' => 'create,export,print,reset,reload',
      'dom' => 'Bfrtip',
    ),
  ),
  'excel' =>
  array (
    'exports' =>
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'csv' =>
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
      'properties' =>
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'imports' =>
    array (
      'read_only' => true,
      'heading_row' =>
      array (
        'formatter' => 'slug',
      ),
      'csv' =>
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
      'properties' =>
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'extension_detector' =>
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' =>
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' =>
    array (
      'driver' => 'memory',
      'batch' =>
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' =>
      array (
        'store' => NULL,
      ),
    ),
    'transactions' =>
    array (
      'handler' => 'db',
    ),
    'temporary_files' =>
    array (
      'local_path' => 'C:\\xampp\\htdocs\\fci-lms\\storage\\framework/laravel-excel',
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
      'force_resync_remote' => NULL,
    ),
  ),
  'filesystems' =>
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' =>
    array (
      'local' =>
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\fci-lms\\storage\\app',
      ),
      'public' =>
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\fci-lms\\storage\\app/public',
        'url' => 'http://localhost/storage',
        'visibility' => 'public',
      ),
      'public_uploads' =>
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\fci-lms\\public\\uploads',
      ),
      's3' =>
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
      ),
    ),
  ),
  'hashing' =>
  array (
    'driver' => 'bcrypt',
    'bcrypt' =>
    array (
      'rounds' => 10,
    ),
    'argon' =>
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'lara-izitoast' =>
  array (
    'titleColor' => '',
    'messageColor' => '',
    'titleSize' => '38',
    'messageSize' => '38',
    'titleLineHeight' => '38',
    'messageLineHeight' => '38',
    'transitionIn' => 'flipInX',
    'transitionOut' => 'flipOutX',
    'zindex' => NULL,
    'closeOnClick' => true,
    'timeout' => 5000,
    'drag' => true,
    'position' => 'bottomRight',
    'progressBar' => true,
  ),
  'laratrust' =>
  array (
    'use_morph_map' => false,
    'use_cache' => true,
    'use_teams' => false,
    'teams_strict_check' => false,
    'user_models' =>
    array (
      'users' => 'App\\User',
    ),
    'models' =>
    array (
      'role' => 'App\\Role',
      'permission' => 'App\\Permission',
      'team' => 'App\\Team',
    ),
    'tables' =>
    array (
      'roles' => 'roles',
      'permissions' => 'permissions',
      'teams' => 'teams',
      'role_user' => 'role_user',
      'permission_user' => 'permission_user',
      'permission_role' => 'permission_role',
    ),
    'foreign_keys' =>
    array (
      'user' => 'user_id',
      'role' => 'role_id',
      'permission' => 'permission_id',
      'team' => 'team_id',
    ),
    'middleware' =>
    array (
      'register' => true,
      'handling' => 'redirect',
      'params' => '403',
    ),
    'magic_can_method_case' => 'kebab_case',
  ),
  'laratrust_seeder' =>
  array (
    'role_structure' =>
    array (
      'super_admin' =>
      array (
        'doctors' => 'c,r,u,d',
        'students' => 'c,r,u,d',
        'subjects' => 'c,r,u,d',
        'levels' => 'c,r,u,d',
        'departments' => 'c,r,u,d',
        'lessons' => 'r',
        'assignments' => 'r',
        'stdassign' => 'r',
        'regist' => 'c,r,u,d',
        'admins' => 'c,r,u,d',
        'users' => 'c,r,u,d',
        'complains' => 'r,u,d',
        'student-problem' => 'r,u,d',
        'doctor-problem' => 'r,u,d',
      ),
      'admin' =>
      array (
        'doctors' => 'c,r,u,d',
        'students' => 'c,r,u,d',
        'subjects' => 'c,r,u,d',
        'levels' => 'c,r,u,d',
        'departments' => 'c,r,u,d',
        'lessons' => 'r',
        'assignments' => 'r',
        'stdassign' => 'r',
        'regist' => 'c,r,u,d',
        'admins' => 'c,r,u,d',
        'users' => 'c,r,u,d',
        'complains' => 'r,u,d',
        'student-problem' => 'r,u,d',
        'doctor-problem' => 'r,u,d',
      ),
      'doctor' =>
      array (
        'subjects' => 'r',
        'lessons' => 'c,r,u,d',
        'assignments' => 'c,r,u,d',
        'stdassign' => 'r',
        'regist' => 'r',
      ),
      'student' =>
      array (
        'subjects' => 'r',
        'lessons' => 'r',
        'assignments' => 'r',
        'stdassign' => 'c',
        'regist' => 'r',
      ),
    ),
    'permissions_map' =>
    array (
      'c' => 'create',
      'r' => 'read',
      'u' => 'update',
      'd' => 'delete',
    ),
  ),
  'laravellocalization' =>
  array (
    'supportedLocales' =>
    array (
      'en' =>
      array (
        'name' => 'English',
        'script' => 'Latn',
        'native' => 'English',
        'regional' => 'en_GB',
      ),
      'ar' =>
      array (
        'name' => 'Arabic',
        'script' => 'Arab',
        'native' => 'العربية',
        'regional' => 'ar_AE',
      ),
    ),
    'useAcceptLanguageHeader' => false,
    'hideDefaultLocaleInURL' => false,
    'localesOrder' =>
    array (
    ),
    'localesMapping' =>
    array (
    ),
    'utf8suffix' => '.UTF-8',
    'urlsIgnored' =>
    array (
      0 => '/skipped',
    ),
  ),
  'logging' =>
  array (
    'default' => 'stack',
    'channels' =>
    array (
      'stack' =>
      array (
        'driver' => 'stack',
        'channels' =>
        array (
          0 => 'daily',
        ),
        'ignore_exceptions' => false,
      ),
      'single' =>
      array (
        'driver' => 'single',
        'path' => 'C:\\xampp\\htdocs\\fci-lms\\storage\\logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' =>
      array (
        'driver' => 'daily',
        'path' => 'C:\\xampp\\htdocs\\fci-lms\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' =>
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ),
      'papertrail' =>
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' =>
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' =>
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' =>
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' =>
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' =>
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
    ),
  ),
  'mail' =>
  array (
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => '587',
    'from' =>
    array (
      'address' => 'mohmedsalah8121997@gmail.com',
      'name' => 'seyouf',
    ),
    'encryption' => 'tls',
    'username' => 'mohmedsalah8121997@gmail.com',
    'password' => 'jpyhfxocqxkrmmpv',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' =>
    array (
      'theme' => 'default',
      'paths' =>
      array (
        0 => 'C:\\xampp\\htdocs\\fci-lms\\resources\\views/vendor/mail',
      ),
    ),
    'log_channel' => NULL,
  ),
  'queue' =>
  array (
    'default' => 'sync',
    'connections' =>
    array (
      'sync' =>
      array (
        'driver' => 'sync',
      ),
      'database' =>
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' =>
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
      ),
      'sqs' =>
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ),
    ),
    'failed' =>
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' =>
  array (
    'mailgun' =>
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' =>
    array (
      'token' => NULL,
    ),
    'ses' =>
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'sparkpost' =>
    array (
      'secret' => NULL,
    ),
    'stripe' =>
    array (
      'model' => 'App\\User',
      'key' => NULL,
      'secret' => NULL,
      'webhook' =>
      array (
        'secret' => NULL,
        'tolerance' => 300,
      ),
    ),
  ),
  'session' =>
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\xampp\\htdocs\\fci-lms\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' =>
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
    'same_site' => NULL,
  ),
  'view' =>
  array (
    'paths' =>
    array (
      0 => 'C:\\xampp\\htdocs\\fci-lms\\resources\\views',
    ),
    'compiled' => 'C:\\xampp\\htdocs\\fci-lms\\storage\\framework\\views',
  ),
  'debug-server' =>
  array (
    'host' => 'tcp://127.0.0.1:9912',
  ),
  'datatables-html' =>
  array (
    'namespace' => 'LaravelDataTables',
    'table' =>
    array (
      'class' => 'table',
      'id' => 'dataTableBuilder',
    ),
    'callback' =>
    array (
      0 => '$',
      1 => '$.',
      2 => 'function',
    ),
    'script' => 'datatables::script',
    'editor' => 'datatables::editor',
  ),
  'datatables' =>
  array (
    'search' =>
    array (
      'smart' => true,
      'multi_term' => true,
      'case_insensitive' => true,
      'use_wildcards' => false,
      'starts_with' => false,
    ),
    'index_column' => 'DT_RowIndex',
    'engines' =>
    array (
      'eloquent' => 'Yajra\\DataTables\\EloquentDataTable',
      'query' => 'Yajra\\DataTables\\QueryDataTable',
      'collection' => 'Yajra\\DataTables\\CollectionDataTable',
      'resource' => 'Yajra\\DataTables\\ApiResourceDataTable',
    ),
    'builders' =>
    array (
    ),
    'nulls_last_sql' => ':column :direction NULLS LAST',
    'error' => NULL,
    'columns' =>
    array (
      'excess' =>
      array (
        0 => 'rn',
        1 => 'row_num',
      ),
      'escape' => '*',
      'raw' =>
      array (
        0 => 'action',
      ),
      'blacklist' =>
      array (
        0 => 'password',
        1 => 'remember_token',
      ),
      'whitelist' => '*',
    ),
    'json' =>
    array (
      'header' =>
      array (
      ),
      'options' => 0,
    ),
  ),
  'trustedproxy' =>
  array (
    'proxies' => NULL,
    'headers' => 30,
  ),
  'tinker' =>
  array (
    'commands' =>
    array (
    ),
    'dont_alias' =>
    array (
      0 => 'App\\Nova',
    ),
  ),
);
