<html>
    <head>
        <link rel="stylesheet"
            href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/default.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js"></script>
        <script>hljs.initHighlightingOnLoad();</script>

        <style>
            p {
                padding: .5rem;
                background: #eee;
            }
            .row {
                display: flex;
            }
            .hljs {
                background: white;
            }
            pre {
                margin: 0;
            }
            .editor {
                margin-right: 1rem;
                padding-right: 1rem;
                border-right: 1px solid #ccc;
            }
        </style>
    </head>

    <body>
        <div class="row">
            <div class="editor">
<pre><code class="php"><?=htmlentities(file_get_contents(isset($_GET['debug_dump']) ? 'debug.php' : 'debug_print_r.php'))?>
</code></pre>
            </div>

            <div>
                <p>
                    Some HTML content here<br>
                    <?=isset($_GET['debug_dump']) ? 'debug_dump()' : 'print_r()'?>
                </p>

                <?php include isset($_GET['debug_dump']) ? 'debug.php' : 'debug_print_r.php'?>

                <p>
                    Some other HTML content here
                </p>
            </div>

        </div>
    </body>
</html>
