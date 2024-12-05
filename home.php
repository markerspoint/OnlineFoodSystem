<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rice Meals</title>
    <style>
        body {
            background-color: #171717;
            color: #383636;
        }

        .rice-meals-section {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin-top: 76px;
            margin-bottom: 40px;
        }

        .rice-meals-section h2 {
            color: #ff4d4d;
            margin-bottom: 20px;
        }

        .rice-meals-section p {
            color: #ccc;
        }

        .rice-meals-section .order-button {
            background-color: #ff4d4d;
            border-color: #ff4d4d;
            color: #fff;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            /* Add margin to create space below text */
            display: inline-block;
            margin-left: 400px;
        }

        .rice-meals-section .order-button:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .rice-meals-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }

        /* Carousel background color */
        .carousel {
            background-color: #121212;
            /* Dark background for the carousel */
            border-radius: 10px;
        }

        /* Individual carousel item background color */
        .carousel-item {
            background-color: #333333;
            /* Darker background for each slide */
        }

        /* Heading color inside the carousel */
        .carousel-item h2 {
            color: #e8e8e8;
            margin-left: 20px;
        }

        /* Text color for the description in each slide */
        .carousel-item p {
            color: #ccc;
            /* Light grey text for descriptions */
            margin-left: 20px;
        }

        /* Order button styles */
        .carousel-item .order-button {
            background-color: #ff4d4d;
            /* Red button */
            border-color: #ff4d4d;
            /* Red border */
            color: white;
            transition: background-color 0.3s ease;
        }

        .carousel-item .order-button:hover {
            background-color: #c82333;
            /* Darker red on hover */
            border-color: #bd2130;
            /* Darker red border on hover */
        }


        /* If you want a smooth gradient for the carousel background */
        .carousel-item {
            background: linear-gradient(135deg, #292929, #1c1b1b);
        }
    </style>
</head>

<body>

    <div class="container">
        <div id="riceCarousel" class="carousel slide rice-meals-section" data-bs-ride="carousel"
            data-bs-interval="4000">
            <div class="carousel-inner">
                <!-- First Slide porksilog  -->
                <div class="carousel-item active">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2>Pork Silog</h2>
                            <p>Flavorful marinated pork, garlic fried rice, and a fried egg, a hearty and satisfying
                                Filipino breakfast.</p>
                            <a href="#" class="btn btn-lg order-button">Order now</a>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="cImage/porksilog.png" alt="Rice Meals" class="rice-meals-image">
                        </div>
                    </div>
                </div>
                <!-- Second Slide chicksilog-->
                <div class="carousel-item">
                    <div class="row align-items-center">
                        <div class="col-lg-6 d-flex flex-column justify-content-start">
                            <h2>Chicken Silog</h2>
                            <p>Tender chicken, garlic fried rice, and a fried egg, a comforting Filipino breakfast
                                staple.</p>
                            <a href="#" class="btn btn-lg order-button align-self-start">Order now</a>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="cImage/chicksilog.png" alt="Rice Meals" class="rice-meals-image">
                        </div>
                    </div>
                </div>
                <!-- Third Slide baconsilog -->
                <div class="carousel-item">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2>Bacon Silog</h2>
                            <p>Crispy bacon, garlic fried rice, and a fried egg, a classic Filipino breakfast with a
                                savory crunch.</p>
                            <a href="#" class="btn btn-lg order-button">Order now</a>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="cImage/baconsilog.png" alt="Rice Meals" class="rice-meals-image">
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#riceCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#riceCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

</body>

</html>