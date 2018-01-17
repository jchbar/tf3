<!DOCTYPE html>
<html>

<head>
    <title>Bootstrap-session-timeout - Countdown Timer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Bootstrap-session-timeout</h1>
        <h2>Countdown Timer</h2>
        <hr>
        <p>Shows the warning dialog with countdown bar after 3 seconds. If user takes no action (interacts with the page in any way), browser is redirected to redirUrl. On any user action (mouse, keyboard or touch) the timeout timer as well as the countdown timer are reset (visible if you don't close the warning dialog). </p>
        <p>Note: you can also combine the countdown bar with a <a href="countdown-timer.html">countdown timer message</a>.</p>

        <pre>
            $.sessionTimeout({
                keepAliveUrl: 'keep-alive.html',
                logoutUrl: 'login.html',
                redirUrl: 'locked.html',
                warnAfter: 3000,
                redirAfter: 10000,
                countdownBar: true,
            });
        </pre>

        <a class="btn btn-primary" href="../index.html" role="button">Back to Demo Index</a>

    </div>
    <script src="bootstrap/js/jquery3.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootstrap-session-timeout.js"></script>

    <script>
    $.sessionTimeout({
        keepAliveUrl: 'keep-alive.html',
        logoutUrl: 'login.html',
        redirUrl: 'locked.html',
//        warnAfter: ((1*60)*1000),  // segundos 15 
//        redirAfter: ((15+(1*60))*1000), // 
                warnAfter: 3000,
                redirAfter: 10000,
        countdownBar: true,
        countdownMessage: 'Redireccionando en {timer} segundos...'
    });
    </script>
</body>

</html>
