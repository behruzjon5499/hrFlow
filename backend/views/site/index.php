<?php

/* @var $this yii\web\View */


?>
<style>


    h3 {
        margin: 0;
        display: inline-block;
        color: ;
    }


    li {
        list-style-type: none;
        border-bottom: 0.5px solid black;
    }

    li:hover {
        list-style-type: none;
        background: #151515;
        border-bottom: 0.5px solid black;
        box-shadow: 0px 0px 4px rgba(0,0,0) inset;
    }

    a {
        text-decoration: none;
        color: #999;
    }


    .center-content {
        width: auto;
        z-index: -1000;
    }


    body {
        minwidth: 100%;
        height: 100%;
        background: ;
    }

    .all-border {
        border: 1px solid transparent;
        width: auto;
        height: 800px;
    }



    .site-info {
        border: 1px solid trans;
        margin: 1em;
        height: auto;
        display: flex;
    }

    body {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;

    }

    .all-quick-info {
        border: 1px solid transparent;
        width: 23%;
        height: auto;
        border-radius: 4px;
        color: #fff;
        background-color: #337ab7;
        border-color: #337ab7;
        margin: 0.5em;
    }

    .info-icon {
        font-size: 70px;
        padding: 10px 20px;
    }

    .info-numbers {
        font-size: 40px;
    }

    .text-right {
        text-align: right;
        margin-top: -90px;
        padding: 10px;
    }

    .info-box-footer {
        padding: 10px 15px;
        background-color: #f5f5f5;
        border-top: 1px solid #ddd;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    .user-href {
        color: #337ab7;
        display: inline-block;
    }

    .pull-right {
        display: none;
    }

    .flex-container {
        border: 1px solid trans;
        padding: 10px;
        display: flex;
    }


    h1{
        font-size: 30px;
        color: #999;
        text-transform: uppercase;
        font-weight: 300;
        text-align: center;
        margin-bottom: 15px;
    }
    table{
        width:100%;
        table-layout: fixed;
    }

    th{
        padding: 20px 15px;
        text-align: left;
        font-weight: 500;
        font-size: 12px;
        color: #777;
        text-transform: uppercase;
        border-bottom: 0.5px solid rgba(0,0,0,0.4);
    }
    td{
        padding: 15px;
        text-align: left;
        vertical-align:middle;
        font-weight: 300;
        font-size: 12px;
        color: #222;
        border-bottom: solid 1px rgba(0,0,0,0.1);
    }


    section{
        margin: 50px;
    }


    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    }
    ::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    }



    textarea {
        display: block;
        min-width: 90%;
        max-width: 90%;
    }


    /*DASHBOARD CONTENT ENDING*/

    body {
        minwidth: 100%;
        height: 100%;
        background: #f2f2f2;
    }

    .all-border {
        border: 1px solid trans;
        width: auto;
        height: 800px;
    }

    .site-info {
        margin: 1em;
        height: AUTO;
        display: flex;
    }

    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    .all-quick-info {
        border: 1px solid;
        width: 50%;
        height: auto;
        border-radius: 2px;
        color: #fff;
        background-color: #337ab7;
        border-color: #337ab7;
        margin: 0.5em;
    }

    .info-icon {
        font-size: 70px;
        padding: 10px 20px;
    }

    .info-numbers {
        font-size: 40px;
    }

    .text-right {
        text-align: right;
        margin-top: -90px;
        padding: 10px;
    }

    .info-box-footer {
        padding: 10px 15px;
        background-color: #f5f5f5;
        border-top: 1px solid #ddd;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    .user-href {
        color: #337ab7;
        display: inline-block;
    }

    .pull-right {
        display: none;
    }

    .flex-container {
        display: flex;
    }

    h1 {
        font-size: 30px;
        color: #999;
        text-transform: uppercase;
        font-weight: 300;
        text-align: center;
        margin-bottom: 15px;
    }

    /*NEW CONTENT HOLDER*/
    .new-content-holder {
        margin: 1em;
        height: min-content;
        display: flex;
    }

    .notifications {
        border: 1px solid #e0e0e0;
        width: max-content;
        width: 35%;
        background: #ddd;
        height: min-content;
        border-radius: 2px;
        box-shadow: 0px 1px 5px #d9d9d9;
        margin-left: 1em;
    }

    h2,
    .action-holder {
        display: inline-block;
        font-size: 15px;
        background: #ddd;
        margin: 0;
        padding: 5px;
        color: #767676;
    }

    .action-holder {
        color: ;
        font-size: 15px;
        float: right;
    }

    .notify-box {
        background: #fff;
        height: ;
        padding: 5px;
        border-radius: 2px;
        overflow: scroll;
        overflow-x: hidden;
    }

    .sender {
        margin: 1em;
        padding: 2px;
        transition: 0.1s;
    }

    .sender:hover {
        margin: 1em;
        padding: 2px;
        background: #f3f3f3;
        border-radius: 3px;
        box-shadow: 0px 1px 2px grey;
    }

    a {
        color: grey;
        text-decoration: none;
        font-size: 12px;
    }

    img {
        border: 2px solid grey;
        border-radius: 8pc;
    }

    .mail-icon {
        float: right;
        color: grey;
        font-size: 30px;
    }

    .fluff-grey {
        background: #f1f1f1;
    }

    .fluff-blue {
        background: #2f61d3;
    }

    .notify-box > span {
        color: grey;
        font-size: 12px;
    }

    @media only screen and (max-width: 900px) {
        .new-content-holder {
            display: flex;
            flex-wrap: wrap;
        }
        .notifications {
            width: 100%;
        }

        .all-quick-info {
            width: 100%;
        }
        .site-info {
            flex-wrap: wrap;
        }
    }

    /*SCROLLBAR CSS*/
    /* width */
    ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: trans;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }



    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: left;
        background-color: #e0e0e0;
        color: grey;
        font-size: 13px;
    }

    td {
        font-size: 12px;
        color: grey;
    }


    .message-server {
        margin: 1em;
        border: 1px solid #dfdf62;
        padding: 8px;
        border-radius: 2px;
        background: #e7d64a;
        box-shadow: 0px 1px 2px grey inset;
        transition: 0.1s;
    }

    .warn-message {
        color: white;
        font-size: 18px;
    }

    .right {
        float: right;
    }

</style>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <div class='all'>

        <div class='center-content'>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

            <div class='all-border'>


                <section>

                    <div class='site-info'>



                        <div style='background: #f0ad4e; border-color: #f0ad4e;' class='all-quick-info'>

                            <div class='info-icon'> <i class="fa">&#xf132;</i></div>

                            <div class='text-right'>
                                <div class='info-numbers'><span><?=$orders?></span></div>
                                <div><?=t("Orders")?></div>
                            </div>

                            <div class='info-box-footer'>

                                <a href='#' class='user-href' style='color: #f0ad4e;'><span class="pull-left">View Details</span>

                                    <span class='pull-right'><i class="fa fa-arrow-circle-right"></i></span></a>

                            </div>

                        </div>

                        <div style='background: #5cb85c; border-color: #5cb85c;' class='all-quick-info'>

                            <div class='info-icon'> <i class="fa fa-envelope"></i></div>

                            <div class='text-right'>
                                <div class='info-numbers'><span><?=$auctions?></span></div>
                                <div><?=t("Auctions")?></div>
                            </div>

                            <div class='info-box-footer'>

                                <a href='#' class='user-href' style='color: #5cb85c;'><span class="pull-left">View Details</span>

                                    <span class='pull-right'><i class="fa fa-arrow-circle-right"></i></span></a>

                            </div>

                        </div>

                        <div style='background: #ff5256; border-color: #ff5256;' class='all-quick-info'>

                            <div class='info-icon'><i class="fa">&#xf05e;</i></div>

                            <div class='text-right'>
                                <div class='info-numbers'><span><?=$tenders?></span></div>
                                <div><?=t("Tenders")?></div>
                            </div>

                            <div class='info-box-footer'>

                                <a href='#' class='user-href' style='color: #ff5256;'><span class="pull-left">View Details</span>

                                    <span class='pull-right'><i class="fa fa-arrow-circle-right"></i></span></a>

                            </div>

                        </div>

                        <div class='all-quick-info'>

                            <div class='info-icon'><i class="fa">&#xf0c0;</i></div>

                            <div class='text-right'>
                                <div class='info-numbers'><span><?=$user?></span></div>
                                <div><?=t("Users")?></div>
                            </div>

                            <div class='info-box-footer'>

                                <a href='#' class='user-href'><span class="pull-left">View Details</span>

                                    <span class='pull-right'><i class="fa fa-arrow-circle-right"></i></span></a>

                            </div>

                        </div>


                    <div class=''>

                    </div>

                </section>

            </div>

        </div>

<?php
$js = <<<JS
        $(document).ready(function() {
            
            function myFunction() {
  var element = document.getElementById("nav");
  element.classList.toggle("second-nav-ul");
}

function size() {
  var element = document.getElementById("all-nav");
  element.classList.toggle("all-nav");
}

var close = document.getElementsByClassName("right");
var i;

for (i = 0; i < close.length; i++) {
  close[i].onclick = function(){
    var div = this.parentElement;
    div.style.opacity = "0";
    setTimeout(function(){ div.style.display = "none"; }, 600);
  }
}
            
       
})

JS;
        $this->registerJs($js);
        
        
        ?>