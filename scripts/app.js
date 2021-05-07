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

function onCheckCurrentTime() {
    $('.currentTime').each(function () {
        var group = this.parentElement.parentElement;
        var currentGroupElementNumber = parseInt(group.className.split('-')[1]);
        var elementsNumber = parseInt($('#experienceGroupNum')[0].value);
        var checkedGroup = $('.' + group.className);
        var checkedGroupDateTo = checkedGroup.find('.dateTo')[0];
        if (this.checked) {
            checkedGroupDateTo.disabled = true;
        } else {
            checkedGroupDateTo.disabled = false;
        }
    })
}

function onCheckUserPolicy() {
    $('.userPolicy').each(function () {
        var group = this.parentElement.parentElement;
        var currentGroupElementNumber = parseInt(group.className.split('-')[1]);
        var elementsNumber = parseInt($('#experienceGroupNum')[0].value);
        var checkedGroup = $('.' + group.className);
        var checkedGroupverifPolicy = checkedGroup.find('.verifPolicy')[0];
        if (this.checked) {
            checkedGroupverifPolicy.disabled = false;
        } else {
            checkedGroupverifPolicy.disabled = true;
        }
    })
}

function getCookie(name) {
    function escape(s) { return s.replace(/([.*+?\^$(){}|\[\]\/\\])/g, '\\$1'); }
    var match = document.cookie.match(RegExp('(?:^|;\\s*)' + escape(name) + '=([^;]*)'));
    return match ? match[1] : null;
}

function buildPreview() {
    // Отображает скрытую форму с разметкой превью
    var cmp = $('#preview');
    cmp[0].style.display = 'inline';

    // Устанавливает значение имени из заполненного в конструкторе
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var patronymic = $('#patronymic').val();
    $('#preview_fullname').html(lastname + ' ' + firstname + ' ' +  patronymic);
    var position = $('#position').val();
    $('#preview_position').html(position);
    var employment = $('#employment').val();
    $('#preview_employment').html(employment);
    var schedule = $('#schedule').val();
    $('#preview_schedule').html(schedule);
    var assignment = $('#assignment').val();
    $('#preview_assignment').html(assignment);
    var salary = $('#salary').val();
    var currency = $('#currency').val();
    $('#preview_salary_currency').html(salary + ' ' + currency);
    var phonecode = $('#phonecode').val();
    var phone = $('#phone').val();
    $('#preview_phonecode_phone').html(phonecode + phone);
    var email = $('#email').val();
    $('#preview_email').html(email);
    //Личная информация
    var citizenship = $('#citizenship').val();
    $('#preview_citizenship').html(citizenship);
    var city = $('#city').val();
    $('#preview_city').html(city);
    var crossing = $('#crossing').val();
    $('#preview_crossing').html(crossing);
    var gender = $('#gender').val();
    $('#preview_gender').html(gender);
    var birthdate = $('#birthdate').val();
    $('#preview_birthdate').html(birthdate);
    var maritalStatus = $('#maritalStatus').val();
    $('#preview_maritalStatus').html(maritalStatus);
    //Образование
    var institute = $('#institute').val();
    $('#preview_institute').html(institute);
    var faculty = $('#faculty').val();
    $('#preview_faculty').html(faculty);
    var speciality = $('#speciality').val();
    $('#preview_speciality').html(speciality);
    var dateFrom_education = $('#dateFrom_education').val();
    $('#preview_dateFrom_education').html(dateFrom_education);
    var dateTo_education = $('#dateTo_education').val();
    $('#preview_dateTo_education').html(dateTo_education);
    //Опыт работы
    var dateFrom_experience = $('#dateFrom_experience').val();
    var dateTo_experience = $('#dateTo_experience').val();
    $('#preview_date_experience').html('с' + dateFrom_experience + ' ' + 'по' + ' ' + dateTo_experience);
    var position_exp = $('#position_exp').val();
    $('#preview_position_exp').html(position_exp);  // ? 
    var organization = $('#organization').val();
    $('#preview_organization').html(organization);
    var duties = $('#duties').val();
    $('#preview_duties').html(duties);
    //Курсы и тренинги
    var training = $('#training').val();
    $('#preview_training').html(training);
    var organizationCoach = $('#organizationCoach').val();
    $('#preview_organizationCoach').html(organizationCoach);
    var completion = $('#completion').val();
    $('#preview_completion').html(completion);
    var duration = $('#duration').val();
    $('#preview_duration').html(duration);
    //Дополнительная информация
    var languages = $('#languages').val();
    $('#preview_languages').html(languages);
    var driveInfo = $('#driveInfo').val();
    $('#preview_driveInfo').html(driveInfo);
    var skills = $('#skills').val();
    $('#preview_skills').html(skills);
    var personalQualities = $('#personalQualities').val();
    $('#preview_personalQualities').html(personalQualities);
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
           <p>Период работы: <input class="form-control" type="date" name="xg-${num}-dateFrom" value="2010"/> по <input class="form-control dateTo" type="date" name="xg-${num}-dateTo" value="2015"/></p>
           <div class="form-check">
                        <input type="checkbox" name="g-${num}-currentTime" id="currentTime" class="form-check-input currentTime" onclick="onCheckCurrentTime()">
                        <label class="form-check-label" for="currentTime">По настоящее время</label>
           </div>
           <br>
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
