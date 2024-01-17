<script type="text/javascript">
$('#myButton1').click(function(){
      $('#myButton1').hide();
      $('.load').addClass('loading');
       
        (function () { 
        $('.load').removeClass('loading');
        $('#myButton1').show();
      });
    });
    
    
//Right Click Inspect Elemen
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});

document.onkeydown = function(e) {
  if(event.keyCode == 123) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
     return false;
  }
}


var ClickCount = 0;
function countClicks() {
	var clickLimit = 1; //Max number of clicks
	if(ClickCount>=clickLimit) {
		return false;
	}
	else
	{
		ClickCount++;
		return true;
	}
}

</script>