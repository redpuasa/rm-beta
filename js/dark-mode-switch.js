// Global variables
var gridLinesColor = 'rgba(0, 0, 0, 0.1)';
var zeroLineColor = 'rgba(0, 0, 0, 0.2)';

$(document).ready(function () {
  var darkSwitch = document.getElementById("darkSwitch");
  var $main_header = $('.main-header');
  var $main_footer = $('.main-footer');
  var $content_wrapper = $('.content-wrapper');
  var $table_striped = $('.table-striped');

  if (darkSwitch) {
    initTheme();

    darkSwitch.addEventListener("change", function(event) {
      resetTheme();
    });

    function initTheme() {
      var darkThemeSelected = localStorage.getItem("darkSwitch") !== null && localStorage.getItem("darkSwitch") === "dark";
      darkSwitch.checked = darkThemeSelected;
      darkThemeSelected ? document.body.setAttribute("data-theme", "dark") : document.body.removeAttribute("data-theme");
      
      // Set dark mode
      if (darkThemeSelected) {
        $main_header.removeClass('navbar-light').removeClass('navbar-white');
        $main_header.addClass('navbar-dark');
        // $content_wrapper.addClass('bg-dark');
        $main_footer.addClass('bg-dark');
        $table_striped.addClass('table-dark');

        $('body').addClass('dark-mode');

        gridLinesColor = 'rgba(255, 255, 255, 0.1)';
        zeroLineColor = 'rgba(255, 255, 255, 0.2)';
      }
    }

    function resetTheme() {
      if (darkSwitch.checked) {
        document.body.setAttribute("data-theme", "dark");
        localStorage.setItem("darkSwitch", "dark");

        // Set navbar to dark
        $main_header.removeClass('navbar-light').removeClass('navbar-white');
        $main_header.addClass('navbar-dark');
        // $content_wrapper.addClass('bg-dark');
        $main_footer.addClass('bg-dark');
        $table_striped.addClass('table-dark');

        // Set dark mode
        $('body').addClass('dark-mode');

        gridLinesColor = 'rgba(255, 255, 255, 0.1)';
        zeroLineColor = 'rgba(255, 255, 255, 0.2)';
      } else {
        document.body.removeAttribute("data-theme");
        localStorage.removeItem("darkSwitch");
      
        // Set navbar to light
        $main_header.removeClass('navbar-dark');
        $main_header.addClass('navbar-light').addClass('navbar-white');
        // $content_wrapper.removeClass('bg-dark');
        $main_footer.removeClass('bg-dark');
        $table_striped.removeClass('table-dark');
        
        // Remove dark mode
        $('body').removeClass('dark-mode');

        gridLinesColor = 'rgba(0, 0, 0, 0.1)';
        zeroLineColor = 'rgba(0, 0, 0, 0.2)';
      }
    }
  }
});