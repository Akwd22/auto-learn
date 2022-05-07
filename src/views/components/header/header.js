const navSlide = () => {
    const burger = document.querySelector('.img-profil');
    const nav = document.querySelector('.burger-links');

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

document.body.addEventListener("scroll", () => {
    const nav = document.querySelector('.burger-links');
    nav.classList.remove("nav-active");
})

navSlide();
