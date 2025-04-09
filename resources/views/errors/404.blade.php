<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    <section>
        <div class="container">
           <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="section-404 text-center">
                    <h1 class="error">404</h1>
                    <div class="page">Ooops!!! The page you are looking for is not found</div>
                    <a class="back-home" href="{{route('/')}}">Back to home</a>
                </div>    
            </div>
           </div>    
        </div>
    </section>

  
    <style>
        /*======================
    404 page
=======================*/




        .section-404 {
            padding: 4rem 2rem;
        }

        .section-404 .error {
            font-size: 150px;
            color: #008B62;
            text-shadow:
                1px 1px 1px #00593E,
                2px 2px 1px #00593E,
                3px 3px 1px #00593E,
                4px 4px 1px #00593E,
                5px 5px 1px #00593E,
                6px 6px 1px #00593E,
                7px 7px 1px #00593E,
                8px 8px 1px #00593E,
                25px 25px 8px rgba(0, 0, 0, 0.2);
        }

        .page {
            margin: 0 0 2rem 0;
            font-size: 20px;
            font-weight: 600;
            color: #444;
        }

        .back-home {
            display: inline-block;
            border: 2px solid #222;
            color: #222;
            text-transform: uppercase;
            font-weight: 600;
            padding: 10px 23px;
            transition: all 0.2s linear;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
            font-size: 13px;
            text-decoration: none !important;
        }

        .back-home:hover {
            background: #222;
            color: #ddd;
        }
    </style>
</body>

</html>