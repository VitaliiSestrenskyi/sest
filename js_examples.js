document.addEventListener('DOMContentLoaded', function(){	                        		
	document.getElementById('authorization-btn').click();
});

document.addEventListener('DOMContentLoaded', function(){
	document.getElementById('oneclickelement').onclick = function(){		
		paramsToModal.buyOneClick($(this)); 
	};
});

elemsCollection = document.getElementsByClassName('buy-offers');
for( var i=0; i < elemsCollection.length; i++  ){
  elemsCollection[i].value = "1";
  console.log( elemsCollection[i]  );
}
