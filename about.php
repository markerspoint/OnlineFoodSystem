<!-- REVIEWS -->
<section id="review" style="background-color: #2e2d2d; padding: 50px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div class="text-center" style="margin-bottom: 30px;">
            <h2 style="font-size: 2.5rem; font-weight: bold; color: #fff;">REVIEWS</h2>
            <p style="font-size: 1.1rem; color: #ccc; margin-top: 10px;">
            Bringing the taste of home to your doorstep – where quality and convenience meet!
            </p>
        </div>
        <!-- Items -->
        <div class="row row-cols-lg-3">
            <div class="col">
                <div class="testimonials mt-4" style="border: 1px solid #444; border-radius: 10px; padding: 20px; background-color: #fff; transition: transform 0.3s, box-shadow 0.3s;">
                    <div class="d-flex align-items-center">
                        <img src="avatar.jpg" alt="" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <div class="ms-2 mb-2">
                            <h3 style="font-size: 1.2rem; margin: 0; color: #333;">Client Name</h3>
                            <a href="#" class="text-decoration-none" style="font-size: 0.9rem; color: #007bff;">@client</a>
                        </div>
                    </div>
                    <p style="margin-top: 10px; font-size: 1rem; color: #555;">Lorem ipsum dolor, sit amet consectetur adipisicing.</p>
                </div>
            </div>
            <div class="col">
                <div class="testimonials mt-4" style="border: 1px solid #444; border-radius: 10px; padding: 20px; background-color: #fff; transition: transform 0.3s, box-shadow 0.3s;">
                    <div class="d-flex align-items-center">
                        <img src="avatar.jpg" alt="" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <div class="ms-2 mb-2">
                            <h3 style="font-size: 1.2rem; margin: 0; color: #333;">Client Name</h3>
                            <a href="#" class="text-decoration-none" style="font-size: 0.9rem; color: #007bff;">@client</a>
                        </div>
                    </div>
                    <p style="margin-top: 10px; font-size: 1rem; color: #555;">Lorem ipsum dolor, sit amet consectetur adipisicing.</p>
                </div>
            </div>
            <div class="col">
                <div class="testimonials mt-4" style="border: 1px solid #444; border-radius: 10px; padding: 20px; background-color: #fff; transition: transform 0.3s, box-shadow 0.3s;">
                    <div class="d-flex align-items-center">
                        <img src="avatar.jpg" alt="" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <div class="ms-2 mb-2">
                            <h3 style="font-size: 1.2rem; margin: 0; color: #333;">Client Name</h3>
                            <a href="#" class="text-decoration-none" style="font-size: 0.9rem; color: #007bff;">@client</a>
                        </div>
                    </div>
                    <p style="margin-top: 10px; font-size: 1rem; color: #555;">Lorem ipsum dolor, sit amet consectetur adipisicing.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const testimonials = document.querySelectorAll('.testimonials');
        testimonials.forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 15px rgba(0, 0, 0, 0.2)';
            });
            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
