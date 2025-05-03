
let form = document.getElementById('delete-form');

function deleteExam(id) {
    form.action = '/teacher/delete/' + id;
    form.submit();
}
