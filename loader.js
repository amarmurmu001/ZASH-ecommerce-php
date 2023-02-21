var loader = document.getElementById("preloader");
window.addEventListener("load",function(){
    loader.style.display="none";
})
    
var menu= document.getElementById("menus");
       function menuopen(){
        menu.style.display="block";
        menu.style.marginRight="0px";
       }
 var menu= document.getElementById("menus");
 function menuclose(){
  menu.style.display="none";
  menu.style.marginRight="0px";
 }

// close-btn-start
    
    const closeBtns = document.querySelectorAll('.close-btn');

for (let i = 0; i < closeBtns.length; i++) {
  closeBtns[i].addEventListener('click', function() {
    this.parentElement.style.display = 'none';
  });
}
 
//    close-btn-end
