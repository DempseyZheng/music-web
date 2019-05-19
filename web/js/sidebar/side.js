// $("#menu-toggle").click(function(e) {
//     console.log('togg');
//     e.preventDefault();
//     $("#wrapper").toggleClass("toggled");
// });
// $("#menu-toggle-2").click(function(e) {
//     console.log('togg');
//     e.preventDefault();
//     $("#wrapper").toggleClass("toggled-2");
//     $('#menu ul').hide();
// });

function initMenu() {
    $('#menuSideBar ul').hide();
    $('#menuSideBar ul').children('.current').parent().show();
    //$('#menu ul:first').show();
    $('#menuSideBar li a').click(
        function() {
            var checkElement = $(this).next();
            if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                return false;
            }
            if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                $('#menuSideBar ul:visible').slideUp('normal');
                checkElement.slideDown('normal');
                return false;
            }
        }
    );
}
$(document).ready(function() {

    initMenu();
});
