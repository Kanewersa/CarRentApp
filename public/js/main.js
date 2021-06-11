let nav = document.getElementById('nav-bar');

document.addEventListener('scroll', function() {
    if (document.documentElement.scrollTop > 940) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});
