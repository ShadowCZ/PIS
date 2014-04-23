<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Banka</title>
    <link href="http://static.freepik.com/darmowe-zdjecie/banku-budynku-ikony--psd_30-2524.jpg" rel="icon" type="image/png" />

    <link rel="stylesheet" href="http://localhost/PIS/static/css/bootstrap.css" type="text/css">

    <script type="text/javascript" src="http://localhost/PIS/static/js/jquery-2.1.0.js"></script>
    <script type="text/javascript" src="http://localhost/PIS/static/js/bootstrap.js"></script>
    <script type="text/javascript">
        {if $bLogout}
              window.location = "{site_url('cmain/')}";
        {/if}
        jQuery(document).ready(function($) {
              $(".clickableRow").click(function() {
                    window.document.location = $(this).attr("href");
              });
        });
    </script>
        
    <style>
        /*content {
            margin-bottom: 30px;
        }*/

        space {
            height: 10px;
            margin: 10px;
        }

        .clickableRow {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container app">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <nav class="navbar navbar-default" role="navigation">
                
                
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <h3>
                                Důvěryhodná banka
                            </h3>
                        </li>
                    </ul>
                    {if {$sActiveUserName}}
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <h3> {$sActiveUserName} </h3>
                            </li>
                             <li>
                                {anchor uri="cmain/logout/" label="Odhlášení"}
                            </li>
                        </ul>
                    {/if}
                </div>
                
            </nav>
