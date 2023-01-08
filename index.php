<?php   include_once 'header.php';
?>

<div class="container">
     <div class="row justify-content-center">
        <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
                <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                <li><a href="#" class="nav-link px-2 text-white">About</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
                </form>

                <div class="text-end">
                <button type="button" class="btn btn-outline-light me-2">Login</button>
                <button type="button" class="btn btn-info">Sign-up</button>
                </div>
            </div>
        </div>
        </header>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div id="carouselExampleCaptions" class="carousel slide" data-interval="1000" data-ride="carousel" data-cycle="true">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner ">
                    <div class="carousel-item active">
                    <img src="resources/img/0.webp" class="d-block w-100 imgmovemiddle">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>SZÁGULDÁS</h2>
                        <p class="text-uppercase bg-secondary">Válassza ki a kedvenc autóját hatalmas kínálatunkból és béreljen tőlünk!</p>
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="resources/img/1.webp" class="d-block w-100 imgmovemaximal">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>PORSCHE</h3>
                        <p class="text-uppercase">Kiváló minőségű szolgáltatás, 98%-os ügyfél elégedettség ★★★★</p>
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="resources/img/2.webp" class="d-block w-100 imgmoveminimal">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>SZERELEM</h3>
                        <p class="text-uppercase">Magyarország legjobb árajánlataival várjuk Önt!</p>
                    </div>
                    </div>
                </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
            <div class="col-md-6 px-0">
                <h1 class="display-4 fst-italic">Üdvözli Önt a NewSnaky Cars Kft.!</h1>
                <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what’s most interesting in this post’s contents.</p>
                <p class="lead mb-0"><a href="#" class="text-white fw-bold">Continue reading...</a></p>
            </div>
        </div>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>