window.onload = () => {
  const nav = document.querySelector(".burger-links");
  const burger = document.querySelector(".img-profil");

  const navSlide = () => {
    burger.addEventListener("click", () => {
      // Calc right position
      const rect = burger.getBoundingClientRect();
      const domsize = document.documentElement.clientWidth;
      const rightSpacing = domsize - rect.x - rect.width;
      nav.style.right = `${rightSpacing}px`;

      //Toggle Nav
      nav.classList.toggle("nav-active");
    });
  };

  window.onresize = () => {
    const rect = burger.getBoundingClientRect();
    const domsize = document.documentElement.clientWidth;
    const rightSpacing = domsize - rect.x - rect.width;
    nav.style.right = `${rightSpacing}px`;
  };

  document.body.addEventListener("scroll", () => {
    if (nav.classList.contains("nav-active")) nav.classList.remove("nav-active");
  });

  navSlide();
};
