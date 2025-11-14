document.addEventListener("DOMContentLoaded",function(){const items=document.querySelectorAll(".filter-item");items.forEach((item,idx)=>{item.addEventListener("click",function(){items.forEach(i=>i.classList.remove("active"));this.classList.add("active");const cat=this.querySelector("span").textContent;console.log("Selected category:",cat)});item.setAttribute("tabindex","0");item.addEventListener("keydown",function(e){if(e.key==="Enter"||e.key===" "){e.preventDefault();this.click()}if(e.key==="ArrowDown"){e.preventDefault();const next=items[idx+1];if(next)next.focus()}if(e.key==="ArrowUp"){e.preventDefault();const prev=items[idx-1];if(prev)prev.focus()}})})});
// Add margin to filter section on scroll
const filterSection = document.querySelector('.filter-section');

window.addEventListener('scroll', function() {
    const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
    
    // Adjust the scroll threshold (300px) and margin value as you want
    if (scrollPosition > 160) {
        filterSection.style.marginTop = '90px'; // Change margin value as needed
        filterSection.style.transition = 'margin-top 0.3s ease';
    } else {
        filterSection.style.marginTop = '0';
    }
});