const $header__burger = document.querySelector('.header__burger')
const $header__menu = document.querySelector('.header__menu')
const $blackout = document.querySelector('.blackout')

$header__burger.addEventListener('click', () => {
   $header__burger.classList.toggle('active')
   $header__menu.classList.toggle('active')
   $blackout.classList.toggle('active')
   // Чтобы заблокировать скролл при открытом меню
   document.querySelector('body').classList.toggle('asset-lock')
})
