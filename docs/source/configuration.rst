
Configuration
=============

``debug_log()`` needs to know a ``debug.log`` file location. The file must be already there and writable.

Default file location
---------------------

By default, the function looks for the log file at ``[PROJECT_ROOT]/.afeefa/debug/debug.log``\ , where ``PROJECT_ROOT`` is either:

*
  Web app:

  The function assumes the web app is served from a ``project/public`` directory and sets ``PROJECT_ROOT`` to the parent of the document root:

  .. code-block:: php

     $PROJECT_ROOT = $_SERVER['DOCUMENT_ROOT'] . "/..";

*
  Cli app:

  The function assumes you are running the cli right from the project root.

  .. code-block:: php

     $PROJECT_ROOT = getcwd();

Create the ``debug.log`` file like this:

.. code-block:: bash

   cd project
   mkdir -p .afeefa/debug
   touch .afeefa/debug/debug.log

**Log info helper**

You may check the location where ``debug_log()`` expects to find the log file by calling the ``debug_log_info()`` helper, also in this package.

.. code-block:: php

   debug_log_info();

   -->

   Array
     [sapi] => cli
     [env] => []
         [AFEEFA_DEBUG_LOG_DIR] => not set
     [tested] => debug-dump-log/example/.afeefa/debug/debug.log
     [found] => 1
     [writable] => 1
     [file] => debug-dump-log/example/.afeefa/debug/debug.log

Custom file location
--------------------

You may specify a custom location by setting the ``AFEEFA_DEBUG_LOG_DIR`` env variable. An absolute path is encouraged, otherwise the path is considered to be relative to the document root (web app) respective to the current working directory (cli app).


*
  from PHP:

  .. code-block:: php

     putenv('AFEEFA_DEBUG_LOG_DIR=/home/debug.log');

*
  from Cli:

  .. code-block:: php

     touch debug.log
     export AFEEFA_DEBUG_LOG_DIR=. && php debug_log.php

*
  Setting the variable at server level is of course possible, too.
