function onAddEducationGroup() {
    const num = $('#educationGroupNum')[0].value;

    const educationGroupButton = $('#addEducationGroup');
    educationGroupButton.before(`
        <hr>
        <div class="educationGroup-${num}">
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
        <hr>
        <div class="experienceGroup-${num}">
           <p>Период работы: <input class="form-control" type="date" name="xg-${num}-dateFrom" value="2010"/> по <input class="form-control" type="date" name="xg-${num}-dateTo" value="2015"/></p>
            <p>Должность: <input class="form-control" type="text" name="xg-${num}-position" value="Инженер" maxlength="50"/></p>
            <p>Организация: <input class="form-control" type="text" name="xg-${num}-organization" value="АО 'Кек'" maxlength="100"/></p>
            <p>Должностные обязанности и достижения: <textarea class="form-control" type="text" name="xg-${num}-duties" value="" maxlength="400"></textarea></p>
        </div>`);
    $('#experienceGroupNum')[0].value++;
};

function initInputMasks() {
    Inputmask({"mask": "+7 (999) 999-9999"}).mask($("#phone")[0]);
};