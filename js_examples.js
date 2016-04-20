document.addEventListener('DOMContentLoaded', function(){	                        		
	document.getElementById('authorization-btn').click();
});

document.addEventListener('DOMContentLoaded', function(){
	document.getElementById('oneclickelement').onclick = function(){		
		paramsToModal.buyOneClick($(this)); 
	};
});
