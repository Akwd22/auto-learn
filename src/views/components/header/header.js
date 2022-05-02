const navSlide = () => {
    const burger = document.querySelector('.img-profil');
    const nav = document.querySelector('.burger-links');
    const navLinks = document.querySelectorAll('.burger-links li');

    burger.addEventListener('click', () => {
        // Calc right position
        const rect = burger.getBoundingClientRect();
        const domsize = document.documentElement.clientWidth;
        const rightSpacing = domsize - (rect.x) - rect.width;
        nav.style.right = `${rightSpacing}px`;

        //Toggle Nav
        nav.classList.toggle('nav-active');
    });
}

window.onresize = () => {
    const burger = document.querySelector('.img-profil');
    const nav = document.querySelector('.burger-links');

    const rect = burger.getBoundingClientRect();
    const domsize = document.documentElement.clientWidth;
    const rightSpacing = domsize - (rect.x) - rect.width;
    nav.style.right = `${rightSpacing}px`;
}

navSlide();
