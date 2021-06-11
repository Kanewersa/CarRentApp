let alert = document.getElementById('alert');

if (alert) {
    alert.addEventListener('click', function () {
       alert.classList.add('hidden');
    });

    setTimeout(function () {
        alert.classList.add('hidden');
    }, 10000);
}
