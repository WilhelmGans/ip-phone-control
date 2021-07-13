<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
    require $_SERVER['DOCUMENT_ROOT'].'/generate/dbphonesFunctions.php';
    $dataPhones = getDataPhones();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>Phone</title>
        <!-- MDB icon -->
        <link rel="icon" href="libs/img/icon.ico" type="image/x-icon" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
        <!-- Google Fonts Roboto -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
        <link rel="stylesheet" href="libs/css/style.css">
        <!-- MDB -->
        <link rel="stylesheet" href="libs/css/mdb.min.css" />
        <script type="text/javascript" src="libs/js/knockout-3.5.1.js"></script>
        <script type="text/javascript" src="script/ping.js" defer></script>
    </head>
    <body>
    <!-- Start your project here-->
    <div class="container-fluid p-1 p-lg-5">
        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="card m-2 p-3">
                    <div class="card-title h5 text-center">
                        Ввод информации
                    </div>
                    <div class="card-body">
                        <div class="form-outline mt-3">
                            <input type="text" class="form-control" id="ipInput" required />
                            <label class="form-label" for="ipInput">IP адрес телефона</label>
                        </div>
                        <div class="form-outline  mt-3">
                            <input type="text" class="form-control" id="numberInput" />
                            <label class="form-label" for="numberInput">Номер телефона</label>
                        </div>
                        <div class="form-outline  mt-3">
                            <input type="text" class="form-control" id="lineInput" />
                            <label class="form-label" for="numberInput">Номер SIP линии телефона</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card m-2 p-3">
                    <div class="card-title h5 text-center">
                        Статус телефона
                    </div>
                    <div class="card-body">
                        <ul data-bind="foreach:servers">
                            <li> <a href="#" data-bind="text:name,attr:{href: 'http://'+name}"></a> <span data-bind="text:status,css:status"></span>
                        
                            </li>
                        </ul>    
                    </div>
                </div>
                <div class="card m-2 p-3">
                    <div class="card-title h5 text-center">
                        Требуемые операции
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center">
                        <button type="button" class="btn btn-success mt-2" id="call" onclick="getData('1','F_HANDFREE')" value="1">Звонок на телефон</button>
                        <button type="button" class="btn btn-success mt-2" id="volup" onclick="getData('0','VOLUME_UP')" value="0">Увеличить громкость</button>
                        <button type="button" class="btn btn-success mt-2" id="dndoff" onclick="getData('0','DNDOff')" value="0">Выключить режим «Не беспокоить»</button>
                    </div>
                </div>
                <div class="card m-2 p-3">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <button type="button" class="btn btn-danger mt-2" id="reboot" onclick="getData('0','Reboot')" value="0">Перезагрузка телефона</button></br>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script type="text/javascript">
            let user = "<?php  echo $dataPhones['loginPhones'];?>";
            let password = "<?php echo $dataPhones['passwordPhones'];?>";
        </script>
        <script type="text/javascript" src="libs/js/mdb.min.js" defer></script>
        <script type="text/javascript" src="script/array.js" defer></script>
        <script type="text/javascript" src="script/processing.js" defer></script>
        
    </body>
</html>