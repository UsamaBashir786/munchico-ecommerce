<style>
#preloader{position:fixed;top:0;left:0;width:100%;height:100%;background:#fff;z-index:9999;opacity:1;transition:opacity .5s ease;overflow-y:auto;-ms-overflow-style:none;scrollbar-width:none}
#preloader::-webkit-scrollbar{display:none}
.skeleton-shape{background-color:#e0e0e0;position:relative;overflow:hidden;border-radius:4px}
.skeleton-shape::after{content:'';position:absolute;top:0;left:0;width:100%;height:100%;transform:translateX(-100%);background:linear-gradient(90deg,transparent,rgba(255,255,255,.4),transparent);animation:skeleton-shimmer 1.5s infinite}
@keyframes skeleton-shimmer{100%{transform:translateX(100%)}}
.skeleton-loader-container{max-width:1440px;margin:0 auto;padding:0 1rem;box-sizing:border-box}
.skeleton-top-bar{height:25px;width:100%;margin-bottom:8px;margin-top:1rem}
.skeleton-header{display:flex;justify-content:space-between;align-items:center;height:70px;margin-bottom:8px}
.skeleton-logo{width:150px;height:40px}
.skeleton-nav{display:none;gap:15px}
.skeleton-nav-item{width:60px;height:20px}
.skeleton-buttons{display:flex;gap:10px}
.skeleton-button{width:80px;height:35px}
.skeleton-announce-bar{height:40px;width:100%;margin-bottom:20px}
.skeleton-content-layout{display:flex;gap:20px}
.skeleton-aside{display:none;width:22%}
.skeleton-aside-item{width:100%;height:40px;margin-bottom:15px}
.skeleton-main-content{width:100%}
.skeleton-hero{width:100%;height:250px}
.skeleton-section-title{width:200px;height:30px;margin-top:2rem;margin-bottom:1.5rem}
.skeleton-card-row{display:grid;grid-template-columns:repeat(2,1fr);gap:15px}
.skeleton-card{width:100%;height:180px}
.skeleton-full-banner{width:100%;height:120px;margin-top:2rem}
@media (min-width:768px){
.skeleton-loader-container{padding:0 2rem}
.skeleton-nav{display:flex}
.skeleton-aside{display:block}
.skeleton-main-content{width:78%}
.skeleton-hero{height:350px}
.skeleton-card-row{grid-template-columns:repeat(4,1fr)}
.skeleton-section-title{width:250px}
.skeleton-full-banner{height:150px}
}
@media (min-width:1024px){
.skeleton-card-row{grid-template-columns:repeat(5,1fr)}
}
</style>


<div id="preloader">
<div class="skeleton-loader-container">
<div class="skeleton-top-bar skeleton-shape"></div>
<div class="skeleton-header">
<div class="skeleton-logo skeleton-shape"></div>
<div class="skeleton-nav">
<div class="skeleton-nav-item skeleton-shape"></div>
<div class="skeleton-nav-item skeleton-shape"></div>
<div class="skeleton-nav-item skeleton-shape"></div>
<div class="skeleton-nav-item skeleton-shape"></div>
</div>
<div class="skeleton-buttons">
<div class="skeleton-button skeleton-shape"></div>
<div class="skeleton-button skeleton-shape"></div>
</div>
</div>
<div class="skeleton-announce-bar skeleton-shape"></div>
<div class="skeleton-content-layout">
<div class="skeleton-aside">
<div class="skeleton-aside-item skeleton-shape"></div>
<div class="skeleton-aside-item skeleton-shape"></div>
<div class="skeleton-aside-item skeleton-shape"></div>
<div class="skeleton-aside-item skeleton-shape"></div>
<div class="skeleton-aside-item skeleton-shape"></div>
</div>
<div class="skeleton-main-content">
<div class="skeleton-hero skeleton-shape"></div>
</div>
</div>
<div class="skeleton-section-title skeleton-shape"></div>
<div class="skeleton-card-row">
<div class="skeleton-card skeleton-shape"></div>
<div class="skeleton-card skeleton-shape"></div>
<div class="skeleton-card skeleton-shape"></div>
<div class="skeleton-card skeleton-shape"></div>
<div class="skeleton-card skeleton-shape"></div>
</div>
<div class="skeleton-full-banner skeleton-shape"></div>
<div class="skeleton-section-title skeleton-shape"></div>
<div class="skeleton-card-row">
<div class="skeleton-card skeleton-shape"></div>
<div class="skeleton-card skeleton-shape"></div>
<div class="skeleton-card skeleton-shape"></div>
<div class="skeleton-card skeleton-shape"></div>
<div class="skeleton-card skeleton-shape"></div>
</div>
</div>
</div>

<script>
window.addEventListener('load',()=>{const p=document.getElementById('preloader');if(p){p.style.opacity='0';p.addEventListener('transitionend',()=>{p.style.display='none'})}});
</script>
