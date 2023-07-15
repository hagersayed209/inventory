$(document).ready(function() {
	
  const body = $('body');
  const sidebar = $('.sidebar');
  const toggle = $('.toggle');
  const searchBtn = $('.search-box');
  const modeSwitch = $('.toggle-switch');
  const modeText = $('.mode-text');

  toggle.on('click', function() {
    sidebar.toggleClass('close');
  });

  modeSwitch.on('click', function() {
    body.toggleClass('dark');
    if (body.hasClass('dark')) {
      modeText.text('Light mode');
    } else {
      modeText.text('Dark mode');
    }
  });
 $('.text div:not(:first-child)').css("display", "none");
  $('.menu-links li ').click(function(){
    $('li ').removeClass("active");
    $(this).addClass("active");
  $('.text div').hide();
        $($(this).find('a').attr('href')).show();
});
	 
});