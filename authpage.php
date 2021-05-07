
<?php
header('Access-Control-Allow-Origin: *');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script type="text/javascript" src="vendor/components/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="vendor/twbs/bootstrap/min/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/min/css/bootstrap.min.css">
    <script type="text/javascript" src="scripts/login.js"></script>
</head>
<body>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Форма авторизации
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Авторизация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="api/login.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="number" id="phone_number" name="phone_number" class="form-control">
                        <div class="input-group-append">
                            <button onclick="getCode()" class="btn btn-outline-secondary" type="button">Получить код</button>
                        </div>
                        <input type="hidden" id="ucaller_id" name="ucaller_id">

                        <label for="code" class="col-form-label">Последние 4 цифры номера:</label>
                        <input type="number" class="form-control" id="code">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" onclick="login()" class="btn btn-primary">Подтвердить</button>
            </div>
        </div>
    </div>
</div>

<br>
<div>
    <input type="number" id="phone_number_reg" name="phone_number_reg" class="form-control">
    <div class="input-group-append">
        <button onclick="activate()" class="btn btn-outline-secondary" type="button">Активировать подписку (как будто произошла оплата)</button>
    </div>
</div>
</body>
</html>