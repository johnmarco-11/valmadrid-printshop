<?php $pageTitle='Valmadrid Advertising and Digital Print'; require 'includes/header.php';
$featured=$pdo->query('SELECT p.*, c.name category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.is_archived=0 ORDER BY p.sold_count DESC LIMIT 4')->fetchAll(); ?>
<section class="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <img src="assets/images/logo.svg" width="86" class="mb-3" alt="Valmadrid logo">
        <h1 class="brand-name">Valmadrid Advertising and Digital Print</h1>
        <p class="lead mt-3 col-lg-9">Bold, clean, and reliable printing services for shirts, IDs, stickers, tarpaulins, signage, souvenirs, and office documents in San Ildefonso, Bulacan.</p>
        <div class="d-flex flex-wrap gap-2 mt-4"><a href="products.php" class="btn btn-red btn-lg">Shop Printing Services</a><a href="contact.php" class="btn btn-yellow btn-lg">Request a Quote</a></div>
      </div>
    </div>
  </div>
</section>
<section class="section-pad">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-6"><h2 class="display-5 fw-bold">Your local partner for print-ready business materials.</h2><p class="lead">We help students, offices, groups, and small businesses turn designs into quality printed products with simple online ordering and pickup payment options.</p></div>
      <div class="col-lg-6"><div class="promo-strip p-4 rounded-4"><h3 class="fw-bold">Popular services</h3><p class="mb-0">Tarpaulin printing, T-shirt printing, PVC ID, mug printing, vinyl stickers, signage, xerox, A4 and A3 printing.</p></div></div>
    </div>
  </div>
</section>
<section class="section-pad soft-yellow">
  <div class="container"><div class="d-flex justify-content-between align-items-end mb-4"><div><h2 class="fw-bold">Featured Printing Services</h2><p class="mb-0">Upload your design, set quantity, and add instructions.</p></div><a href="products.php" class="btn btn-red">View All</a></div><div class="row g-4">
    <?php foreach($featured as $p): ?><div class="col-md-6 col-lg-3"><div class="card product-card h-100"><img src="<?= e($p['image'] ?: 'assets/images/product-placeholder.svg') ?>" class="product-img" alt="<?= e($p['name']) ?>"><div class="card-body"><span class="badge badge-brand mb-2"><?= e($p['category_name']) ?></span><h5 class="fw-bold"><?= e($p['name']) ?></h5><p class="small text-muted"><?= e($p['description']) ?></p><div class="fw-bold text-danger mb-3"><?= money($p['price']) ?></div><a class="btn btn-red w-100" href="product.php?id=<?= $p['id'] ?>">Customize</a></div></div></div><?php endforeach; ?>
  </div></div>
</section>
<section class="section-pad">
  <div class="container"><h2 class="fw-bold text-center mb-4">Customer Reviews</h2><div class="row g-4"><div class="col-md-4"><p class="p-4 rounded-4 shadow-sm">"Fast tarpaulin printing and very clear colors. Easy pickup."<br><b>- Maria S.</b></p></div><div class="col-md-4"><p class="p-4 rounded-4 shadow-sm">"Our school IDs and laces were neatly printed."<br><b>- Jayson R.</b></p></div><div class="col-md-4"><p class="p-4 rounded-4 shadow-sm">"Beginner-friendly online ordering. I uploaded my sticker file quickly."<br><b>- Ana P.</b></p></div></div></div>
</section>
<section class="section-pad soft-yellow"><div class="container"><div class="row g-4"><div class="col-lg-5"><h2 class="fw-bold">Visit Our Shop</h2><p>Beside Police Station, Poblacion, San Ildefonso, Bulacan</p><p><b>Mobile:</b> 0916-432-8919 / 0991-291-8330<br><b>Email:</b> valmadrid.advertising01@gmail.com</p></div><div class="col-lg-7"><iframe title="Valmadrid map" class="rounded-4 w-100" height="310" loading="lazy" src="https://maps.google.com/maps?q=Poblacion%20San%20Ildefonso%20Bulacan&t=&z=15&ie=UTF8&iwloc=&output=embed"></iframe></div></div></div></section>
<?php require 'includes/footer.php'; ?>