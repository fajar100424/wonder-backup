<?php
require('functions.php');
ob_start();
session_start();
?>
<html>
    <head>
        <title>Landing Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" href="asset/stylebutton.css">
        <link rel="icon" type="image/x-icon" href="asset/1.png" />
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    </head>
    <body>
        <section class="content-section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="judul">
                            <header>
                            <h1><span><img src="asset/handshake.png" alt="" style="margin-bottom: 15px;"></span>WELCOME TO</h1>
                            <p style="font-size: 16px;">WORKOVER NECESSARY DOCUMENT EVIDENCE REVIEW (WONDER)</p>
                            </header>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="button">
                            <a href="login page/index.php"><img src="asset/programmer.png" alt="">Login Administrator</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="button">
                            <a href="login page/index.php"><img src="asset/people.png" alt="">Login Uploader</a>    
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="button">
                            <a href="login page/index.php"><img src="asset/write.png" alt="">Login Reviewer</a>    
                        </div>
                    </div>
                </div> 
                <footer>
                    <div class="row" style="margin-top: 50px;">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="judul">
                                <span>
                                    <img src="asset/1.png" alt="" style="width: 70; background-color:transparent;">
                                    <p style="display: inline;"> Copyright &copy; WONDER by PEP</p>
                                </span>
                            </div> 
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                </footer>
            </div>
            
        </section>
        <div class="area" >
            <ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
            </ul>
        </div >
         
    </body>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
</html>