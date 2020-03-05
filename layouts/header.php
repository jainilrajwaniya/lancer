<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Lancer IFTA</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="css/common/AdminLTE.min.css">

        <!--<link rel="stylesheet" href="/css/common/skin-blue.min.css">-->
        <link rel="stylesheet" href="css/common/skin-purple.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
        <!--toastr min css-->
        <link rel="stylesheet" href="css/toastr.min.css">

        <!--main css-->
        <link rel="stylesheet" href="css/main.css">

        <!--Pafe specific css-->

        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <style type="text/css">
            .text-warning { color: red;}
            .jumbotron {
                background-color: white;    
            }
            .jumbotron img {
                float: left;
                width: 350px;
                height: 100px;
                background: #555;
            }
            .jumbotron h2 {
                padding-right: 40px;
                font-size: 55px;
                color: #004080;
            }
            .container {
                background-color: #cce6ff;
            }

            .box-header {
                text-align: center;
            }
            /*.bg-cover { background-image: url('./images/logo.jpg')}*/
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            
            label.error {
                color: red;
            }
        </style>
        <script type="text/javascript">
            var baseUrl = "<?= $baseUrl ?>";
        </script>
    </head>

    <body class="">
        <div class="spinner" style="display:none;"></div>
        <div class="jumbotron text-right bg-cover">
            <img src="./images/logo.jpg" alt="logo" />
            <h2 style='padding-right: 40px;'>Insured Mileage Report</h2>
            <!--<p>Resize this responsive page to see the effect!</p>-->
        </div>
