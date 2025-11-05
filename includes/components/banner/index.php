<section class="banner-section rc-both rc-ease-in rc-delay-rc-delay-150" aria-label="Promotional Banner">
    <div class="container">
        <div class="promotional-banner"></div>
        <div class="text-center mt-xl">
            <button class="banner-shop-btn">SHOP NOW</button>
        </div>
    </div>
</section>


<style>
.banner-section{padding:var(--space-xl) 0;background:var(--gray-50)}
.promotional-banner{position:relative;width:100%;height:300px;border-radius:var(--radius-xl);overflow:hidden;background-image:url('assets/img/landscape.webp');background-size:cover;background-position:center;background-repeat:no-repeat;box-shadow:var(--shadow-xxl);display:flex;align-items:center;justify-content:center}
.promotional-banner::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;z-index:1}
.banner-shop-btn{position:relative;display:inline-block;margin:auto;text-align:center;z-index:2;background:linear-gradient(135deg,#7CB342,#558B2F);color:var(--white);border:none;padding:14px 44px;border-radius:50px;font-weight:700;font-size:12px;cursor:pointer;transition:all var(--transition-base);box-shadow:0 10px 30px rgba(124,179,66,0.4);text-transform:uppercase;letter-spacing:1.5px}
.banner-shop-btn:hover{transform:translateY(-3px) scale(1.05);box-shadow:0 15px 40px rgba(124,179,66,0.6);background:linear-gradient(135deg,#558B2F,#33691E)}
.banner-shop-btn:active{transform:translateY(-1px) scale(1.02)}
@media (max-width:768px){
.promotional-banner{height:350px}
.banner-shop-btn{padding:14px 36px;font-size:16px}
}
@media (max-width:480px){
.promotional-banner{height:250px;border-radius:12px}
.banner-shop-btn{padding:12px 30px;font-size:14px}
}
</style>