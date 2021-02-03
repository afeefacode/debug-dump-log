<?php

namespace Afeefa\Component\Debug;

use Webmozart\PathUtil\Path;
use Wujunze\Colors;

class Debug
{
    public static function dump()
    {
        $args = func_get_args();

        if (php_sapi_name() === 'cli') {
            echo "\n";
        } else {
            echo '<pre>';
        }

        $fileInfo = static::getFileInfo('dump');

        echo $fileInfo . "\n";
        echo static::getMessage($args);

        if (php_sapi_name() === 'cli') {
            echo "\n";
        } else {
            echo '</pre>';
        }
    }

    public static function log()
    {
        $args = func_get_args();

        ['file' => $logFile] = static::findLogFile();

        // fail silently, if no logfile found
        // check log config using log_info()
        if (!$logFile) {
            return;
        }

        $fileInfo = static::getFileInfo('log');
        $message = static::getMessage($args);

        file_put_contents($logFile, date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        file_put_contents($logFile, $fileInfo . "\n", FILE_APPEND);
        file_put_contents($logFile, $message . "\n\n", FILE_APPEND);
    }

    public static function log_info()
    {
        static::dump(static::findLogFile());
    }

    private static function getMessage(array $args): string
    {
        $messages = [];
        foreach ($args as $arg) {
            $dump = print_r($arg, true);
            $dump = preg_replace('/[ ]{4}/', '  ', $dump);
            $dump = preg_replace("/\n\s*\(/", '', $dump);
            $dump = preg_replace("/\)\n/", '', $dump);
            $dump = preg_replace('/ => Array/', ' => []', $dump);
            $dump = preg_replace("/.*\*RECURSION\*.*\n/", '', $dump);
            $dump = preg_replace("/^\s+$/m", '', $dump);
            $dump = preg_replace("/\n+/", "\n", $dump);
            $dump = preg_replace("/:.+:private\]/", '-]', $dump);
            $dump = preg_replace("/:protected\]/", '÷]', $dump);
            $dump = preg_replace("/(=> [^\s]+) Object/", '$1', $dump);

            $messages[] = trim($dump) . ' ';
        }
        return implode("\n\n", $messages);
    }

    private static function getFileInfo($operation): string
    {
        $bt = debug_backtrace();

        $caller = $bt[2];
        $callerCaller = $bt[3] ?? $caller;
        $function = $callerCaller['function'];
        if (in_array($function, ['debug_dump', 'debug_log'])) {
            $function = 'main';
        }

        if (php_sapi_name() === 'cli') {
            $file = Path::makeRelative($caller['file'], getcwd());
        } else {
            $file = Path::makeRelative($caller['file'], $_SERVER['DOCUMENT_ROOT']);
        }

        $fileInfo = $file . ':' . $caller['line'] . '#' . $function;

        if ($operation === 'dump') {
            if (php_sapi_name() === 'cli') {
                $colors = new Colors();
                $fileInfo = $colors->getColoredString($fileInfo, 'light_gray');
            } else {
                $fileInfo = '<span style="color:#AAAAAA;">' . $fileInfo . '</span>';
            }
        }

        return $fileInfo;
    }

    private static function findLogFile(): array
    {
        $info = [
            'sapi' => php_sapi_name() === 'cli' ? 'cli' : 'server',
            'env' => [
                'AFEEFA_DEBUG_LOG_DIR' => getenv('AFEEFA_DEBUG_LOG_DIR') ?: 'not set'
            ]
        ];

        $currentDir = getenv('AFEEFA_DEBUG_LOG_DIR');

        if ($currentDir) {
            if (php_sapi_name() === 'cli') {
                $currentDir = Path::makeAbsolute($currentDir, getcwd());
            } else {
                $currentDir = Path::makeAbsolute($currentDir, $_SERVER['DOCUMENT_ROOT']);
            }
        } else {
            if (php_sapi_name() === 'cli') {
                $currentDir = getcwd();
            } else {
                $currentDir = Path::join($_SERVER['DOCUMENT_ROOT'], '..');
            }
            $currentDir = Path::join($currentDir, '.afeefa', 'debug');
        }

        $logFile = Path::join($currentDir, 'debug.log');
        $logFileFound = file_exists($logFile);
        $logFileWritable = $logFileFound && is_writable($logFile);

        $info['sapi'] = php_sapi_name() === 'cli' ? 'cli' : 'server';
        $info['tested'] = $logFile;
        $info['found'] = $logFileFound;
        $info['writable'] = $logFileWritable;
        $info['file'] = $logFileFound ? $logFile : null;

        return $info;
    }
}
