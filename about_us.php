<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>About Us</title>
  <style>
    body {
      background-image: url('bg.jpeg');
      background-attachment: fixed; /* Fix the background image */

      background-size: cover;
      font-family: Arial, sans-serif;
      background-color: #F9F9F9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    /* Header Styles */
    header {
      width: 100%;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
    }

    .logo {
            background-image: url('image.png');
            background-size: cover;
            width: 50px; /* Adjust the width as needed */
            height: 50px; /* Adjust the height as needed */
            border-radius: 50%; /* Make the image circular */
            overflow: hidden; /* Hide any content outside the border-radius */
            cursor: pointer;
        }

    .button-container {
      display: flex;
      align-items: center;
    }

    .button {
      padding: 12px 24px;
      background-color: #8b5a2b;
      color: white;
      text-align: center;
      font-size: 18px;
      border-radius: 8px;
      margin-right: 50px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    .aboutusbutton {
      padding: 12px 24px;
      background-color: #4d2c12;
      color: white;
      text-align: center;
      font-size: 18px;
      border-radius: 8px;
      margin-right: 50px;
      text-decoration: none;
      transition: 0.3s ease-in;
    }

    .aboutusbutton:hover {
      opacity: 0.8;
      background-color: #714623;
    }

    /* Content Cards */
    .card-container {
      display: flex;
      justify-content: space-between;
      margin-top: 100px; /* Adjust as needed */
    }

    .card {
      width: 30%;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-title {
      font-size: 24px;
      color: #8b5a2b;
      margin-bottom: 10px;
    }

    .card-description {
      font-size: 16px;
      color: #333;
    }
  </style>
</head>

<body>
  <header>
  <a href="index.php" class="logo"></a> <!-- Add anchor tag here -->
    <div class="button-container">
      <a href="./index.php" class="button">Services</a>
      <a href="./about_us.php" class="aboutusbutton">About Us</a>
      <a href="./contact.html" class="button">Contact Now</a>
      <a href="./profile1.php" class="button">View Profile</a>
      <a href="./logout.php" class="button">Logout</a>
    </div>
  </header>

  <section id="about">
    <h2>About Us</h2>
    <div class="card-container">
      <div class="card">
        <h2 class="card-title">Laundry Services</h2>
        <p class="card-description">Our laundry experts are equipped with the latest technology and techniques to ensure your clothes are cleaned, pressed, and cared for with the utmost attention to detail. From everyday wear to delicate fabrics, we handle it all with care.</p>
      </div>
      <div class="card">
        <h2 class="card-title">Plumbing Services</h2>
        <p class="card-description">From leaky faucets to complex plumbing installations, our team of licensed plumbers is ready to tackle any job, big or small. We prioritize efficiency and precision to ensure your plumbing systems are functioning smoothly.</p>
      </div>
      <div class="card">
        <h2 class="card-title">Carpentry Services</h2>
        <p class="card-description">With years of experience in carpentry, our skilled craftsmen can bring your vision to life. Whether it's custom furniture, home renovations, or woodworking projects, we deliver quality craftsmanship tailored to your needs.</p>
      </div>
    </div>
    <div class="card-container">
      <div class="card">
        <h2 class="card-title">Our Mission</h2>
        <p class="card-description">Our mission is to provide top-quality services with professionalism, reliability, and efficiency. We aim to exceed our customers' expectations and build long-lasting relationships based on trust and satisfaction.</p>
      </div>
      <div class="card">
        <h2 class="card-title">Our Vision</h2>
        <p class="card-description">Our vision is to become the leading provider of household services, known for our exceptional customer satisfaction, innovative solutions, and commitment to excellence. We strive to be the go-to choice for individuals and families seeking reliable and comprehensive assistance for their home maintenance needs.</p>
      </div>
      <div class="card">
        <h2 class="card-title">Our Values</h2>
        <ul class="card-description">
          <li>Experienced professionals in each field</li>
          <li>Quality workmanship and attention to detail</li>
          <li>Timely and reliable service</li>
          <li>Transparent pricing with no hidden fees</li>
          <li>Customer satisfaction guaranteed</li>
        </ul>
      </div>
    </div>
  </section>

</body>

</html>
