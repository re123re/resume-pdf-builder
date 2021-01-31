function onAddEducationGroup() {
    const num = $('#educationGroupNum')[0].value;

    const educationGroupButton = $('#addEducationGroup');
    educationGroupButton.before(`
        <hr>
        <div class="educationGroup-${num}">
            <p>Учебное заведение: <input type="text" name="eg-${num}-institute" value="МГУ" /></p>
            <p>Факультет: <input type="text" name="eg-${num}-faculty" value="Информационных технологий" /></p>
            <p>Специальность: <input type="text" name="eg-${num}-speciality" value="Монтаж слаботочных систем" /></p>
            <p>Дата начала: <input type="number" name="eg-${num}-dateFrom" value="2004" /></p>
            <p>Дата окончания: <input type="number" name="eg-${num}-dateTo" value="2009" /></p>
        </div>`);
    $('#educationGroupNum')[0].value++;
};

function onAddExperienceGroup() {
    const num = $('#experienceGroupNum')[0].value;

    const experienceGroupButton = $('#addExperienceGroup');
    experienceGroupButton.before(`
        <hr>
        <div class="experienceGroup-${num}">
           <p>Период работы: <input type="date" name="xg-${num}-dateFrom" value="2010" /> по <input type="date" name="xg-${num}-dateTo" value="2015" /></p>
            <p>Должность: <input type="text" name="xg-${num}-position" value="Инженер" /></p>
            <p>Организация: <input type="text" name="xg-${num}-organization" value="АО 'Кек'" /></p>
            <p>Должностные обязанности и достижения: <input type="text" name="xg-${num}-duties" value="" /></p>
        </div>`);
    $('#experienceGroupNum')[0].value++;
};