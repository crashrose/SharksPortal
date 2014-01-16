// Original from Angie Radtke 2009 // 
/* Responsive */

function auf(key) {
	var el = document.id(key);

	if (el.style.display == 'none') {
		el.setStyle('display', 'block');
		el.setProperty('aria-expanded', 'true');

		el.slide('hide').slide('in');
		el.getParent().setProperty('class', 'slide');
		eltern = el.getParent().getParent();
		elternh = eltern.getElement('h3');
		elternh.addClass('high');
		elternbild = eltern.getElement('img');
		// elternbild.focus();
		el.focus();
		elternbild.setProperties( {
			alt : altopen,
			src : bildzu
		});
			
	} else {
		el.setStyle('display', 'none');
		el.setProperty('aria-expanded', 'false');

		el.removeClass('open');
		
		eltern = el.getParent().getParent();
		elternh = eltern.getElement('h3');
		elternh.removeClass('high');
		elternbild = eltern.getElement('img');
		// alert(bildauf);
		elternbild.setProperties( {
			alt : altclose,
			src : bildauf
		});
		elternbild.focus();
	} 
}



/* Suckerfish */

sfHover = function() {
	var sfEls = document.getElementById("navigation").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover); 
