// Get the modal
var modal = document.getElementById('loginButton');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
function dbg(){
			var ajx = new XMLHttpRequest();
					var dtb = new FormData();
					//dtb.append("askLikes",img[1]);//filename sanitise
					//dtb.append("ltype","1");// to be implemented
					ajx.addEventListener('load',function(){
						console.log(this.responseText);
						//var t = JSON.parse(this.responseText);
						//text.innerText = "Likes: " + (t.likes===undefined?0:t.likes);
						//localStorage.setItem('imgstatus', "");//ready for merge
					});
				ajx.open("POST", "http://localhost/camagru/Sources/BackEnd/debug.php");
				ajx.send(dtb);
		}