
  document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.header-menu-toggle');
    const headerNav = document.querySelector('.header-nav');
    const body = document.body;
    
    menuToggle.addEventListener('click', function() {
      headerNav.classList.toggle('active');
      body.classList.toggle('menu-open');
    });
  });