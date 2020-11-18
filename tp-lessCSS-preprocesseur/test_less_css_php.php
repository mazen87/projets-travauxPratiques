<?php
    require_once 'lib/lessphp/lessc.inc.php';

    $less = new lessc();
    $less->compileFile("lib/test.less","lib/test.css");
    //var_dump($less);

    ?>

    <html>
        <head>
            <link rel="stylesheet" href="lib/test.css">
            <link rel="stylesheet/less" type="text/css" href="lib/test.less" />
           
            <script src="lib/less-JS/less.js"></script>
            
        </head>
        <body>
            <div>
            <h1 class="gris-1">TEST</h1>
            <h2 class="gris-2">TEST</h2>
            <h3 class="gris-3">TEST</h3>
            <h4 class="gris-4">TEST</h4>
            <h5 class="gris-5">TEST</h5>
            </div>
        </body>
    </html>