<aside class="aside-sidebar rc-both rc-ease-in rc-delay-rc-delay-150" aria-label="Product Filters and Promotions">
    <section class="filter-section">
        <h3>Categories</h3>
        <ul class="filter-list">
            <li class="filter-item active">
                <img src="assets/img/sample.webp" alt="Gift Box">
                <span>Gift Box</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Almonds">
                <span>Almonds</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Cashew Nuts">
                <span>Cashew Nuts</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Pistachio">
                <span>Pistachio</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Pine Nuts Chilgoza">
                <span>Pine Nuts Chilgoza</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Walnuts">
                <span>Walnuts</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Dried Fig">
                <span>Dried Fig</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Apricot">
                <span>Apricot</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Dates">
                <span>Dates</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Peanuts">
                <span>Peanuts</span>
            </li>
            <li class="filter-item">
                <img src="assets/img/sample.webp" alt="Walnut Kernels">
                <span>Walnut Kernels</span>
            </li>
        </ul>
    </section>

    <div class="sticky-banner-wrapper">
        <div class="aside-banner">
            <img src="assets/img/banner.webp" alt="Big 20% OFF - Only Dry Fruit">
        </div>
    </div>

    <section class="product-section special-products">
        <h2>Special <span class="highlight">Product</span></h2>
        <div class="product-list">
            <article class="product-card-mini">
                <div class="product-image">
                    <img src="assets/img/sample.webp" alt="Kalmi Dates">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Kalmi Dates (Khajoor) 1kg Pack</h3>
                    <div class="product-price">
                        <span class="price-current">Rs.1,000.00</span>
                        <span class="price-old">Rs.1,500.00</span>
                    </div>
                </div>
            </article>
            <article class="product-card-mini">
                <div class="product-image">
                    <img src="assets/img/sample.webp" alt="Dry Arbai Dates">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Dry Arbai Dates:( 1kg Pack )</h3>
                    <div class="product-price">
                        <span class="price-current">Rs.300.00</span>
                        <span class="price-old">Rs.600.00</span>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="product-section trending-products">
        <h2>Trending <span class="highlight">Product</span></h2>
        <div class="product-list">
            <article class="product-card-mini">
                <div class="product-image">
                    <img src="assets/img/sample.webp" alt="Chakwal Pehlwan">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Chakwal Pehlwan Rewari (250g)</h3>
                    <div class="product-price">
                        <span class="price-current">Rs.280.00</span>
                        <span class="price-old">Rs.250.00</span>
                    </div>
                </div>
            </article>
            <article class="product-card-mini">
                <div class="product-image">
                    <img src="assets/img/sample.webp" alt="Chocolate Stones">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Delicious Iranian Stone Chocolate</h3>
                    <div class="product-price">
                        <span class="price-current">Rs.600.00</span>
                        <span class="price-old">Rs.600.00</span>
                    </div>
                </div>
            </article>
            <article class="product-card-mini">
                <div class="product-image">
                    <img src="assets/img/sample.webp" alt="Pan Masla">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Indulge In The Sweet And Aromatic Delight Of Pan Masla</h3>
                    <div class="product-price">
                        <span class="price-current">Rs.120.00</span>
                        <span class="price-old">Rs.200.00</span>
                    </div>
                </div>
            </article>
        </div>
    </section>
</aside>

<style>
.page-layout{display:grid;grid-template-columns:280px 1fr;gap:var(--space-xl);margin:0 auto}
.aside-sidebar{position:sticky;top:var(--space-lg);height:fit-content;max-height:calc(100vh - var(--space-xl));overflow-y:auto;overflow-x:hidden;display:flex;flex-direction:column;gap:var(--space-lg);-ms-overflow-style:none;scrollbar-width:none}
.aside-sidebar::-webkit-scrollbar{width:0;display:none}
.filter-section{background:var(--white);border-radius:var(--radius-lg);padding:var(--space-lg);box-shadow:var(--shadow-sm);border:1px solid var(--gray-200)}
.filter-section h3{font-family:var(--font-primary);font-size:var(--font-size-lg);font-weight:600;color:var(--black);margin-bottom:var(--space-md);padding-bottom:var(--space-sm);border-bottom:2px solid var(--gray-200)}
.filter-list{list-style:none;padding:0;margin:0}
.filter-item{display:flex;align-items:center;gap:var(--space-sm);padding:var(--space-sm) var(--space-xs);cursor:pointer;transition:var(--transition-fast);border-radius:var(--radius-sm)}
.filter-item:hover{background:var(--gray-50);padding-left:var(--space-sm)}
.filter-item img{width:32px;height:32px;object-fit:cover;border-radius:var(--radius-sm);flex-shrink:0}
.filter-item span{font-family:var(--font-secondary);font-size:var(--font-size-sm);color:var(--gray-800);transition:var(--transition-fast)}
.filter-item:hover span{color:var(--primary-color);font-weight:500}
.filter-item.active{background:var(--primary-light);padding-left:var(--space-sm)}
.filter-item.active span{color:var(--primary-dark);font-weight:600}
.aside-banner{border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-md);position:relative;transition:var(--transition-base)}
.aside-banner img{width:100%;height:auto;display:block}
.aside-banner::after{content:'';position:absolute;inset:0;border:2px solid var(--accent-color);border-radius:var(--radius-lg);pointer-events:none;opacity:0;transition:var(--transition-base)}
.aside-banner:hover{transform:translateY(-2px)}
.aside-banner:hover::after{opacity:1}
.product-section{background:var(--white);border-radius:var(--radius-lg);padding:var(--space-lg);box-shadow:var(--shadow-sm);border:1px solid var(--gray-200)}
.product-section h2{font-family:var(--font-primary);font-size:var(--font-size-xl);font-weight:600;color:var(--black);margin-bottom:var(--space-lg)}
.product-section h2 .highlight{color:var(--secondary-color)}
.product-list{display:flex;flex-direction:column;gap:var(--space-md)}
.product-card-mini{display:grid;grid-template-columns:80px 1fr;gap:var(--space-sm);padding:var(--space-sm);border-radius:var(--radius-md);transition:var(--transition-base);cursor:pointer;border:1px solid transparent}
.product-card-mini:hover{background:var(--gray-50);border-color:var(--gray-200);box-shadow:var(--shadow-sm)}
.product-image{width:80px;height:80px;border-radius:var(--radius-md);overflow:hidden;flex-shrink:0}
.product-image img{width:100%;height:100%;object-fit:cover;transition:var(--transition-base)}
.product-card-mini:hover .product-image img{transform:scale(1.1)}
.product-info{display:flex;flex-direction:column;justify-content:center;gap:var(--space-xs)}
.product-name{font-family:var(--font-secondary);font-size:var(--font-size-sm);font-weight:500;color:var(--gray-800);line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.product-price{display:flex;align-items:center;gap:var(--space-xs);flex-wrap:wrap}
.price-current{font-family:var(--font-primary);font-size:var(--font-size-base);font-weight:700;color:var(--primary-color)}
.price-old{font-size:var(--font-size-xs);color:var(--gray-500);text-decoration:line-through}
@media (max-width:1024px){
.page-layout{grid-template-columns:240px 1fr;gap:var(--space-lg)}
.aside-sidebar{max-height:calc(100vh - var(--space-lg))}
}
@media (max-width:768px){
.page-layout{grid-template-columns:1fr;gap:var(--space-md)}
.aside-sidebar{position:static;max-height:none;overflow-y:visible}
}
@media (max-width:480px){
.filter-section,.product-section{padding:var(--space-md)}
.product-card-mini{grid-template-columns:70px 1fr}
.product-image{width:70px;height:70px}
}
</style>

<script>
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
</script>