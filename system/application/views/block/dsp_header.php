<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Banka</title>
    <link href="http://static.freepik.com/darmowe-zdjecie/banku-budynku-ikony--psd_30-2524.jpg" rel="icon" type="image/png" />

    <script type="text/javascript" src="{base_url('js/jquery-1.5.1.min.js')}"></script>
    <script type="text/javascript" src="{base_url('js/jquery-ui-custom.min.js')}"></script>
    <script type="text/javascript" src="{base_url('js/jquery.scrollTo-1.4.2.js')}"></script>
    <script type="text/javascript" src="{base_url('js/jquery.superbox.min.js')}"></script>
    <script type="text/javascript" src="{base_url('js/jquery.submit-on-change.js')}"></script>
    <script type="text/javascript" src="{base_url('js/jquery.spinbuttons.js')}"></script>
    <script type="text/javascript" src="{base_url('js/jquery.elastic.js')}"></script>
    <script type="text/javascript" src="{base_url('js/jquery.tablesorter.js')}"></script>
    <script type="text/javascript">
        {if $bLogout}
              window.location = "{site_url('cmain/')}";
        {/if}
    </script>

    <style type="text/css">

        ::selection{ background-color: #E13300; color: white; }
        ::moz-selection{ background-color: #E13300; color: white; }
        ::webkit-selection{ background-color: #E13300; color: white; }

        .circle {
            display: block;
            width: 10px;
            height: 10px;
            background: red;
            -moz-border-radius: 40px;
            -webkit-border-radius: 40px;
        }

        body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
        }

        a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
        }

        h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
        }

        code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
        }

        #body{
                margin: 0 15px 0 15px;
        }

        p.footer{
                text-align: right;
                font-size: 11px;
                border-top: 1px solid #D0D0D0;
                line-height: 32px;
                padding: 0 10px 0 10px;
                margin: 20px 0 0 0;
        }

        #container{
                margin: 10px;
                border: 1px solid #D0D0D0;
                -webkit-box-shadow: 0 0 8px #D0D0D0;
        }

        #menu{
            width: 13%;
            position: fixed;
            left: 87%;
            top: 0;
        }

        #menu_header{
            background: blue;
            color: white;
                    border: 2px solid black;
                    -webkit-box-shadow: 0 0 8px #D0D0D0;
        }

        #menu_body{
            display: none;
            background: lightblue;
            padding: 10px;
                    border: 2px solid blue;
                    -webkit-box-shadow: 0 0 8px #D0D0D0;
        }

        #filter{
            width: 13%;
            position: fixed;
            left: 0;
            top: 0;
        }

        #filter_header{
            background: gray;
            color: white;
                    border: 2px solid black;
                    -webkit-box-shadow: 0 0 8px #D0D0D0;
        }

        #filter_body{
            display: none;
            background: lightgrey;
            padding: 10px;
                    border: 2px solid grey;
                    -webkit-box-shadow: 0 0 8px #D0D0D0;
        }
    </style>
</head>
<body>

<div id="container">