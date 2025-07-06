<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KateringApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #1f2937, #111827);
            color: #fff;
        }

        header {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: transparent;
        }

        header h1 {
            font-size: 24px;
            color: #22c55e;
        }

        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #fff;
            font-weight: 500;
        }

        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 80px 100px;
        }

        .hero-text {
            max-width: 50%;
        }

        .hero-text h1 {
            font-size: 48px;
            color: #a3e635;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .hero-text .btn {
            padding: 14px 28px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            margin-right: 20px;
            border-radius: 8px;
        }

        .btn-order {
            background-color: #22c55e;
            color: white;
        }

        .btn-login {
            background-color: #3b82f6;
            color: white;
        }

        .hero-img img {
            width: 400px;
            border-radius: 20px;
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                padding: 40px;
            }

            .hero-text, .hero-img {
                max-width: 100%;
                text-align: center;
            }

            .hero-img img {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>KateringApp</h1>
        <nav>
            <a href="{{ route('order.form') }}">Pesan Sekarang</a>
            <a href="{{ route('login') }}">Login Admin</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h1>Apa Kamu Lapar? <br><strong>Tunggu Apalagi!</strong></h1>
            <p>Yuk mulai pesan makanan sekarang dan nikmati makananmu tanpa repot.</p>
            <a href="{{ route('order.form') }}" class="btn btn-order">Pesan Sekarang</a>
        </div>
        <div class="hero-img">
            <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092" alt="Delicious Food">
        </div>
    </section>
</body>
</html>
