<?php
\One\Database\Mysql\Connect::setConfig(config('mysql'));
\One\Log::setConfig(config('log'));
\One\Http\Router::setConfig(['path' => _APP_PATH_ . '/Config/router.php']);
\One\Cache\File::setConfig(config('cache.file'));
\One\Cache\Redis::setConfig(config('cache.redis'));
\One\Crypt\Openssl::setConfig(config('crypt'));

// 分布式配置
\App\Cloud\Server::setConfig(config('cloud'));




