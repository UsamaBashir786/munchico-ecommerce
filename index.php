<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- ========================================================= -->
  <!-- ⚙️ BASIC CONFIGURATION -->
  <!-- ========================================================= -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <!-- ========================================================= -->
  <!-- 🏠 PAGE TITLE & META INFO -->
  <!-- Essential for SEO and browser tab display -->
  <!-- ========================================================= -->
  <title>HOME – MUNCHICO | Premium Dried Fruits & Nuts Online Store</title>
  <meta name="title" content="HOME – MUNCHICO | Premium Dried Fruits & Nuts Online Store" />
  <meta name="description" content="Shop premium dried fruits, nuts, and snacks at MUNCHICO. Exclusive deals, top quality products, and fast delivery. Your trusted online store for healthy snacking." />
  <meta name="keywords" content="dried fruits, nuts, premium snacks, healthy snacks, MUNCHICO, online store, dried figs, almonds, cashews" />
  <meta name="author" content="MUNCHICO" />
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

  <!-- ========================================================= -->
  <!-- 🌐 OPEN GRAPH (Facebook / LinkedIn Preview) -->
  <!-- Helps control how your site appears when shared -->
  <!-- ========================================================= -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://www.munchico.com/" />
  <meta property="og:site_name" content="MUNCHICO" />
  <meta property="og:title" content="HOME – MUNCHICO | Premium Dried Fruits & Nuts Online Store" />
  <meta property="og:description" content="Shop premium dried fruits, nuts, and snacks at MUNCHICO. Exclusive deals, top quality products, and fast delivery." />
  <meta property="og:image" content="https://www.munchico.com/assets/images/og-image.jpg" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:alt" content="MUNCHICO - Premium Dried Fruits & Nuts" />
  <meta property="og:locale" content="en_US" />

  <!-- ========================================================= -->
  <!-- 🐦 TWITTER CARD META -->
  <!-- For rich link previews on Twitter/X -->
  <!-- ========================================================= -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:url" content="https://www.munchico.com/" />
  <meta name="twitter:title" content="HOME – MUNCHICO | Premium Dried Fruits & Nuts Online Store" />
  <meta name="twitter:description" content="Shop premium dried fruits, nuts, and snacks at MUNCHICO. Exclusive deals, top quality products, and fast delivery." />
  <meta name="twitter:image" content="https://www.munchico.com/assets/images/twitter-card.jpg" />
  <meta name="twitter:image:alt" content="MUNCHICO - Premium Dried Fruits & Nuts" />
  <meta name="twitter:site" content="@munchico" />
  <meta name="twitter:creator" content="@munchico" />

  <!-- ========================================================= -->
  <!-- 🔖 FAVICONS & APP ICONS -->
  <!-- For browser tabs, mobile shortcuts, and PWA -->
  <!-- ========================================================= -->
  <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico" />
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="192x192" href="assets/images/android-chrome-192x192.png" />
  <link rel="icon" type="image/png" sizes="512x512" href="assets/images/android-chrome-512x512.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png" />

  <!-- ========================================================= -->
  <!-- 📱 PWA & WINDOWS META -->
  <!-- Controls how the app behaves on mobile and Windows -->
  <!-- ========================================================= -->
  <link rel="manifest" href="site.webmanifest" />
  <meta name="theme-color" content="#ffffff" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="msapplication-config" content="browserconfig.xml" />

  <!-- ========================================================= -->
  <!-- 🔗 SEO LINKS -->
  <!-- Canonical & language alternate versions -->
  <!-- ========================================================= -->
  <link rel="canonical" href="https://www.munchico.com/" />
  <link rel="alternate" hreflang="en" href="https://www.munchico.com/" />
  <link rel="alternate" hreflang="x-default" href="https://www.munchico.com/" />

  <!-- ========================================================= -->
  <!-- ⚡ PERFORMANCE OPTIMIZATION -->
  <!-- Preconnect & preload for faster loading -->
  <!-- ========================================================= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="dns-prefetch" href="https://www.google-analytics.com" />
  <link rel="preload" href="assets/css/main.css" as="style" />

  <!-- ========================================================= -->
  <!-- 🧩 STRUCTURED DATA (JSON-LD) -->
  <!-- Enhances SEO with schema.org data -->
  <!-- ========================================================= -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "WebSite",
        "name": "MUNCHICO",
        "url": "https://www.munchico.com",
        "description": "Premium dried fruits, nuts, and healthy snacks online store",
        "potentialAction": {
          "@type": "SearchAction",
          "target": "https://www.munchico.com/search?q={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      },
      {
        "@type": "Organization",
        "name": "MUNCHICO",
        "url": "https://www.munchico.com",
        "logo": "https://www.munchico.com/assets/images/logo.png",
        "sameAs": [
          "https://www.facebook.com/munchico",
          "https://www.instagram.com/munchico",
          "https://www.twitter.com/munchico",
          "https://www.linkedin.com/company/munchico"
        ],
        "contactPoint": {
          "@type": "ContactPoint",
          "telephone": "+1-XXX-XXX-XXXX",
          "contactType": "Customer Service",
          "areaServed": "US",
          "availableLanguage": ["English"]
        }
      }
    ]
  }
  </script>

  <!-- ========================================================= -->
  <!-- 🎨 STYLESHEETS -->
  <!-- Core and extra styling files for layout and design -->
  <!-- ========================================================= -->
  <!-- 🌐 Main global styles -->
  <link rel="stylesheet" href="assets/css/main.css" />

  <!-- ✨ Additional custom tweaks and overrides -->
  <link rel="stylesheet" href="assets/css/extra.css" />

  <!-- 👑 Royal CSS Framework (Custom UI components) -->
  <link rel="stylesheet" href="assets/royalcssx/royal.css" />
</head>


<body>
  <!-- ========================================================= -->
  <!-- 🌀 PRELOADER SECTION -->
  <!-- Displays a loading animation before the content appears -->
  <!-- ========================================================= -->
  <?php include 'includes/components/preloader/index.php' ?>

  <!-- ========================================================= -->
  <!-- 🚀 NAVIGATION BAR -->
  <!-- Contains logo, menus, and main navigation links -->
  <!-- ========================================================= -->
  <?php include 'includes/navbar.php' ?>

  <!-- ========================================================= -->
  <!-- 📢 ANNOUNCEMENT BAR -->
  <!-- Displays latest updates or promotions in a marquee style -->
  <!-- ========================================================= -->
  <?php include 'includes/components/announcements/index.php' ?>


  <div class="page-layout">
    <!-- ========================================================= -->
    <!-- 🧭 ASIDE PANEL -->
    <!-- Sidebar navigation or filter section -->
    <!-- ========================================================= -->
    <?php include 'includes/components/aside/index.php'; ?>
    
    <main>
      <!-- ========================================================= -->
      <!-- 🖼️ HERO BANNER -->
      <!-- The main visual section for page intro or highlights -->
      <!-- ========================================================= -->
      <section class="hero-banner" aria-label="Main Banner">

      </section>
      <?php include 'includes/components/hero/index.php' ?>
  
      <!-- ========================================================= -->
      <!-- 🗂️ CATEGORY SECTION -->
      <!-- Displays all available categories of products -->
      <!-- ========================================================= -->
      <?php include 'includes/components/category/index.php'?>
  
      <!-- ========================================================= -->
      <!-- 💎 PREMIUM ITEMS -->
      <!-- Highlights premium or featured products -->
      <!-- ========================================================= -->
      <!-- include 'includes/components/premiumitems/index.php' -->
        
      <!-- ========================================================= -->
      <!-- 🪧 BANNER SECTION -->
      <!-- Secondary promotional or discount banner -->
      <!-- ========================================================= -->
      <?php include 'includes/components/banner/index.php' ?>

      <!-- ========================================================= -->
      <!-- 🛍️ FEATURED PRODUCTS -->
      <!-- Displays top-rated or trending items -->
      <!-- ========================================================= -->
      <!-- include 'includes/components/featureproducts/index.php' -->
          
      <!-- ========================================================= -->
      <!-- 🌰 DRIED FIGS SECTION -->
      <!-- Special section for specific product line (e.g. figs) -->
      <!-- ========================================================= -->
      <?php include 'includes/components/driedfigs/index.php' ?>

      <!-- ========================================================= -->
      <!-- ⚙️ FEATURES SECTION -->
      <!-- Lists key store features like free delivery, secure payment, etc. -->
      <!-- ========================================================= -->
      <?php include 'includes/components/features/index.php' ?>
    </main>
  </div>

  <!-- ========================================================= -->
  <!-- 📱 MOBILE DOCKER -->
  <!-- Mobile navigation bottom dock for quick access -->
  <!-- ========================================================= -->
  <?php include 'includes/mobile-docker.php' ?>

  <!-- ========================================================= -->
  <!-- 🦶 FOOTER SECTION -->
  <!-- Contains contact info, social links, and legal pages -->
  <!-- ========================================================= -->
  <?php include 'includes/footer.php' ?>
  <?php include 'includes/components/top-to-bottom/index.php' ?>
  <!-- ========================================================= -->
  <!-- ⚡ JAVASCRIPT FILES -->
  <!-- Handles dynamic behavior, initialization, and components -->
  <!-- ========================================================= -->
  <script src="assets/js/royal-css-initialization.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/royalcssx/royal.js"></script>
</body>



</html>