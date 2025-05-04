
let form = document.getElementById('delete-form');

function deleteExam(id) {
    form.action = '/teacher/delete/' + id;
    form.submit();
}



document.getElementById('pen').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('profileImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
