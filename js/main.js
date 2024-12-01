window.addEventListener('scroll', function() {
    scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const navbar = document.querySelector('.navbar');
    navbar.classList.toggle('scrolled', scrollTop > 60);
    navbar.classList.toggle('bg-dark', scrollTop > 60);
});

const navbar_toggler = document.querySelector('.navbar-toggle');
navbar_toggler.addEventListener('click', function (e){
    const navbar = document.querySelector('.navbar');
    if (! navbar.classList.contains('scrolled')) {
        navbar.classList.toggle('bg-dark');
    }
});

const nav_items = document.querySelectorAll('.navbar li a');
nav_items.forEach((nav_item) => {
    nav_item.addEventListener('click', function () {
        $('.collapse').collapse('hide');
    });
});
