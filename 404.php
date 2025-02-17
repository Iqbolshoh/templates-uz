<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
</head>

<style>
    :root {
        --background-color: #f4f4f4;
        --default-color: #444444;
        --accent-color: #e96b56;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background-color: var(--background-color);
        color: var(--default-color);
        font-size: 16px;
    }

    .error-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        text-align: center;
        animation: fadeIn 1s ease-out;
    }

    .error-content {
        background: var(--background-color);
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        animation: fadeInUp 1s ease-out;
    }

    .error-code {
        font-size: 8em;
        color: var(--accent-color);
        margin-bottom: 20px;
        animation: scaleUp 1s ease-out;
    }

    .error-message {
        font-size: 1.5em;
        color: var(--default-color);
        margin-bottom: 20px;
        animation: fadeInUpText 1s ease-out;
    }

    .back-home {
        display: inline-block;
        padding: 10px 20px;
        background: var(--accent-color);
        color: var(--background-color);
        text-decoration: none;
        border-radius: 5px;
        font-weight: 600;
        transition: background .3s, transform .3s, box-shadow .3s;
        animation: bounce 2s ease-in-out infinite;
    }

    .back-home:hover {
        background: rgb(237, 122, 101);
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleUp {
        from {
            transform: scale(0.5);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes fadeInUpText {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-7px);
        }
    }
</style>

<body>

    <main class="error-container">
        <div class="error-content">
            <h1 class="error-code">404</h1>
            <p class="error-message">Oops! Page not found.</p>
            <a href="https://templates.uz/" class="back-home">Go to Home</a>
        </div>
    </main>

</body>

</html>