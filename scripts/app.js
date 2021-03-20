function onEducationRemoveClick(num) {
    // contract
    $(`.educationGroup-${num}`).remove();
    console.log(num);
}

function onExperienceRemoveClick(num) {
    // contract
    $(`.experienceGroup-${num}`).remove();
    console.log(num);
}

function onCoursesRemoveClick(num) {
    // contract
    $(`.coursesGroup-${num}`).remove();
    console.log(num);
}

$(document).ready(function () {


    function onAddEducationGroup() {
        const num = $('#educationGroupNum')[0].value;

        const educationGroupButton = $('#addEducationGroup');
        educationGroupButton.before(`
        <div class="educationGroup-${num}">
            <hr>
            <nav class="navbar navbar-expand-md">
                <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <button type="button" class="btn btn-danger" onclick="onEducationRemoveClick(${num})">Удалить</button>
                        </li>
                    </ul>
                </div>
             </nav>
            <p>Учебное заведение: <input class="form-control" type="text" name="eg-${num}-institute" value="МГУ" maxlength="100"/></p>
            <p>Факультет: <input class="form-control" type="text" name="eg-${num}-faculty" value="Информационных технологий" maxlength="100"/></p>
            <p>Специальность: <input class="form-control" type="text" name="eg-${num}-speciality" value="Монтаж слаботочных систем" maxlength="100"/></p>
            <p>Дата начала: <input class="form-control" type="number" name="eg-${num}-dateFrom" value="2004" maxlength="4"/></p>
            <p>Дата окончания: <input class="form-control" type="number" name="eg-${num}-dateTo" value="2009" maxlength="4"/></p>
        </div>`);
        $('#educationGroupNum')[0].value++;
    };

    function onAddExperienceGroup() {
        const num = $('#experienceGroupNum')[0].value;

        const experienceGroupButton = $('#addExperienceGroup');
        experienceGroupButton.before(`
        <div class="experienceGroup-${num}">
              <hr>
              <nav class="navbar navbar-expand-md">
                <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <button type="button" class="btn btn-danger" onclick="onExperienceRemoveClick(${num})">Удалить</button>
                        </li>
                    </ul>
                </div>
             </nav>
           <p>Период работы: <input class="form-control" type="date" name="xg-${num}-dateFrom" value="2010"/> по <input class="form-control" type="date" name="xg-${num}-dateTo" value="2015"/></p>
            <p>Должность: <input class="form-control" type="text" name="xg-${num}-position" value="Инженер" maxlength="50"/></p>
            <p>Организация: <input class="form-control" type="text" name="xg-${num}-organization" value="АО 'Кек'" maxlength="100"/></p>
            <p>Должностные обязанности и достижения: <textarea class="form-control" type="text" name="xg-${num}-duties" value="" maxlength="400"></textarea></p>
        </div>`);
        $('#experienceGroupNum')[0].value++;
    };

    function onAddCoursesGroup() {
        const num = $('#coursesGroupNum')[0].value;

        const coursesGroupButton = $('#addCoursesGroup');
        coursesGroupButton.before(`
        <div class="coursesGroup-${num}">
              <hr>
              <nav class="navbar navbar-expand-md">
                <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <button type="button" class="btn btn-danger" onclick="onCoursesRemoveClick(${num})">Удалить</button>
                        </li>
                    </ul>
                </div>
             </nav>
            <p>Название курса: <input class="form-control" type="text" maxlength="100" name="cg-0-${num}-training" placeholder="Коучинг для HR руководителей"/></p>
            <p>Наименование организации: <input class="form-control" type="text" maxlength="100" name="cg-0-${num}-organizationCoach" placeholder="Учебный центр им.Боумана"/></p>
            <p>Год окончания: <input class="form-control" type="text" maxlength="100" name="cg-0-${num}-completion" placeholder="2020"/></p>
            <p>Продолжительность: <input class="form-control" type="text" maxlength="100" name="cg-0-${num}-duration" placeholder="260 часов"/></p>
        </div>`);
        $('#coursesGroupNum')[0].value++;
    };

    function initInputMasks() {
        Inputmask({"mask": "(999) 999-9999"}).mask($("#phone")[0]);
    };

    document.getElementById("educationGroupNum").value = 1;
    document.getElementById("experienceGroupNum").value = 1;
    document.getElementById("coursesGroupNum").value = 1;

    document.getElementById("addEducationGroup").onclick = () => onAddEducationGroup();
    document.getElementById("addExperienceGroup").onclick = () => onAddExperienceGroup();
    document.getElementById("addCoursesGroup").onclick = () => onAddCoursesGroup();

    initInputMasks();

    initCroppie();

    function initCroppie() {
        var $uploadCrop;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });

                }

                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('.upload-demo').croppie({
            viewport: {
                width: 220,
                height: 220,
            },
            enableExif: true
        });

        $('.upload').on('change', function () { readFile(this); });
        $('.upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                popupResult({
                    src: resp
                });
            });
        });

        $('.apply').on('click', function () {
            $uploadCrop.croppie('result', {
                type: 'base64',
                size: {width:220, height:220},
                format: 'jpeg'
            }).then(function (resp) {
                $('.user-photo').prop('src', resp);
                $('.user-photo-input').val(resp);
            });
        });
    }
});
