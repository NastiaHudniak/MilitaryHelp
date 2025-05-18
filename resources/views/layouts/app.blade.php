<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/alerts.css') }}" rel="stylesheet">

    <style>
        .alert {
            opacity: 1;
            transition: opacity 1s ease-out;
            text-align: center;
        }
        .alert.fade-out {
            opacity: 0;
        }
    </style>
</head>
<body style="background-color: var(--green-200); font-family: 'Jura', sans-serif;">
@if (session('success'))
    <div class="alert-success-custom" id="success-alert">
        <div class="alert-success-custom-text-block">
            <p class="alert-success-custom-text">{{ session('success') }}</p>
            <button class="alert-ok-btn" onclick="document.getElementById('success-alert').style.display='none'">OK</button>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="alert-danger-custom" id="error-alert">
        <div class="alert-danger-custom-text-block">
            <p class="alert-danger-custom-text">{{ session('error') }}</p>
            <button class="alert-ok-btn" onclick="document.getElementById('error-alert').style.display='none'">OK</button>
        </div>
    </div>
@endif


<div class="container" style="max-width: 1800px; margin: 0px; padding: 0px 0px;">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function() {
            var successAlert = document.getElementById('success-alert');
            var errorAlert = document.getElementById('error-alert');

            if (successAlert) {
                successAlert.classList.add('fade-out');
            }

            if (errorAlert) {
                errorAlert.classList.add('fade-out');
            }
            setTimeout(function() {
                if (successAlert) {
                    successAlert.remove();
                }

                if (errorAlert) {
                    errorAlert.remove();
                }
            }, 1000);
        }, 3000);
    });
</script>
</body>
</html>
