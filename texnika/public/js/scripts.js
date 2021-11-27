/*!
    * Start Bootstrap - SB Admin v6.0.2 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    (function($) {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
})(jQuery);

const customSelects = document.querySelectorAll("select");
const deleteBtn = document.getElementById('delete')
const choices = new Choices('select',
{
  searchEnabled: false,
  removeItemButton: true,
  itemSelectText: '',
});
for (let i = 0; i < customSelects.length; i++)
{
  customSelects[i].addEventListener('addItem', function(event)
  {
    if (event.detail.value)
    {
      let parent = this.parentNode.parentNode
      parent.classList.add('valid')
      parent.classList.remove('invalid')
    }
    else
    {
      let parent = this.parentNode.parentNode
      parent.classList.add('invalid')
      parent.classList.remove('valid')
    }
  }, false);
}
deleteBtn.addEventListener("click", function(e)
{
  e.preventDefault()
  const deleteAll = document.querySelectorAll('.choices__button')
  for (let i = 0; i < deleteAll.length; i++)
  {
    deleteAll[i].click();
  }
});

function showadvanced(){
    $('.advance-search').toggleClass('d-none');
    $('.result-count').toggleClass('d-none');
}


var contenttype = $('#contenttype').val();

$('.' + contenttype).addClass('active');


if (contenttype == "deadline") {
    $('.' + contenttype).addClass('active-bell');
}


$(".discounts").on("click", function() {
    $(".discount-items").toggleClass('d-none');
    $(".discounts i").toggleClass('fa-caret-right');
    $(".discounts i").toggleClass('fa-caret-down');
});
$(".expences").on("click", function() {
    $(".expences-items").toggleClass('d-none');
    $(".expences i").toggleClass('fa-caret-right');
    $(".expences i").toggleClass('fa-caret-down');
});
$(".products_all").on("click", function() {
    $(".product-items").toggleClass('d-none');
    $(".products_all i").toggleClass('fa-caret-right');
    $(".products_all i").toggleClass('fa-caret-down');
});

$(".button-power").on("click", function() {
    $('#exampleModal2').modal('show');
});