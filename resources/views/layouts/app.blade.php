<html>

<head>
    <title>Contact Crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        label.error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        input.error {
            border-color: red;
            background-color: #ffe6e6;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="{{ asset('js/contacts.js') }}"></script>
</body>

</html>