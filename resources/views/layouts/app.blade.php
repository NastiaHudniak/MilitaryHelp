<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Military Help')</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/alerts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js" defer></script>



</head>
<body style="font-family: 'Open Sans';">
{{--@if (session('success'))--}}
{{--    <div class="alert-success-custom" id="success-alert">--}}
{{--        <div class="alert-success-custom-text-block">--}}
{{--            <p class="alert-success-custom-text">{{ session('success') }}</p>--}}
{{--            <button class="alert-ok-btn" onclick="document.getElementById('success-alert').style.display='none'">OK</button>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}

<div class="container" style="max-width: 1800px; margin: 0px; padding: 0px 0px;">
    @yield('content')

    <!-- Лоадер -->
{{--    <div class="loader-overlay" id="loader" style="display: none;">--}}
{{--        <div class="loader"></div>--}}
{{--    </div>--}}

    <div id="global-loader" class="loader-hidden">
        <div class="loader-spinner"></div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');

        if (successAlert || errorAlert) {
            setTimeout(() => {
                if (successAlert) {
                    successAlert.classList.add('fade-out');
                    setTimeout(() => successAlert.remove(), 1000);
                }

                if (errorAlert) {
                    errorAlert.classList.add('fade-out');
                    setTimeout(() => errorAlert.remove(), 1000);
                }
            }, 3000);
        }
    });

    // function showLoader(show) {
    //     document.getElementById('loader').style.display = show ? 'flex' : 'none';
    // }

    let loaderTimeout;

    function showLoaderWithDelay() {
        loaderTimeout = setTimeout(() => {
            document.getElementById('global-loader')?.classList.remove('loader-hidden');
        }, 100);
    }

    function hideLoader() {
        clearTimeout(loaderTimeout);
        document.getElementById('global-loader')?.classList.add('loader-hidden');
    }

    window.addEventListener('beforeunload', () => {
        showLoaderWithDelay();
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function () {
                showLoaderWithDelay();
            });
        });
    });

    window.addEventListener('load', () => {
        hideLoader();
    });


    function showToast(message, type = 'success') {
        const icons = {
            success: "{{ asset('images/icon/alerts/done.svg') }}",
            warning: "{{ asset('images/icon/warning.svg') }}",
            info: "{{ asset('images/icon/info.svg') }}",
            error: "{{ asset('images/icon/cansel.svg') }}"
        };

        const icon = icons[type] || 'ℹ️';

        Toastify({
            node: createCustomToast(icon, message, type),
            duration: 5000,
            gravity: "top",
            position: "left",
            stopOnFocus: true,
            close: false,
            style: {
                background: "none",
                boxShadow: "none"
            },
            offset: {
                x: 0,
                y: 0
            }
        }).showToast();
    }

    function createCustomToast(iconSrc, message, type) {
        const toast = document.createElement('div');
        toast.className = `custom-toast toast-${type}`;

        toast.innerHTML = `
         <div class="toast-text-block">
            <div class="toast-message">
                <img src="${iconSrc}" alt="icon" width="24" height="24">
                <span>${message}</span>
            </div>
            <button class="toast-close">OK</button>
        </div>
    `;

        toast.querySelector('.toast-close').addEventListener('click', () => {
            toast.parentElement?.remove();
        });

        return toast;
    }


    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
        showToast(@json(session('success')), 'success');
        @endif

        @if (session('warning'))
        showToast(@json(session('warning')), 'warning');
        @endif

        @if (session('error'))
        showToast(@json(session('error')), 'error');
        @endif
    });

</script>
</body>
</html>
