<!DOCTYPE html>
<?php include('head.html');?>
<link rel="stylesheet" media="screen" href="bootstrap3.css" />
    script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="zxcvbn.js"></script>
    <script type="text/javascript" src="pwstrength.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            "use strict";
            var options = {};
            options.ui = {
                container: "#pwd-container",
                viewports: {
                    progress: ".pwstrength_viewport_progress",
                    verdict: ".pwstrength_viewport_verdict"
                }
            };
            options.common = {
                onLoad: function () {
                    $('#messages').text('Escriba su clave');
                },
                zxcvbn: true,
                zxcvbnTerms: ['samurai', 'shogun', 'bushido', 'daisho', 'seppuku'],
                userInputs: ['#year', '#familyname']
            };
            $(':password').pwstrength(options);
        });
    </script>

</head>
<body>
    <div class="container">
        <h1>Bootstrap 3 Password Strength Meter Example - zxcvbn</h1>
        <form role="form"  style="margin-bottom: 20px;" data-toggle="validator">
            <div class="row" id="pwd-container">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="InputPassword">Password</label>
                        <input type="password" class="form-control" id="InputPassword" placeholder="Password">
                    </div>
                </div>
    <div class="alert alert-info">
        <strong>Consejos Útiles:</strong><br />* Utilice ambos caracteres, mayúsculas y minúsculas<br />* Incluya al menos un símbolo (# $ ! % &amp; etc...)<br />* No utilice palabras del diccionario
</div>
                <div class="col-sm-12 col-sm-offset-0 my-help-text">
                    <span class="pwstrength_viewport_progress"></span> <span class="pwstrength_viewport_verdict"></span>
                </div>
            </div>
            <div class="row">
                <div id="messages" class="col-sm-12"></div>
            </div>
		    <div id="confirmacion" class="form-group col-sm-12 has-feedback">
		        <input type="password" class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" placeholder="Confirme clave" data-match="#InputPassword" data-match-error="Ups!!!... las claves no son iguales" placeholder="Confirmar clave" required>
		        <div class="help-block with-errors"></div>
			</div>
        </form>
jchbar@cantv.net
</body>
</html>

