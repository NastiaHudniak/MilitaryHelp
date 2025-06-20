@extends('layouts.app')

@include('layouts.header_admin')

@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="card">
            <div class="card-header" style="margin: 0">
                <h2>Редагування фотографій</h2>
            </div>
            <div class="card-body">
                <div class="card-body-image">
                    @foreach($images as $image)
                        <div class="image-scroll-container" style="display: flex; align-items: center;">
                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Product Image" style="width: 120px; height: 120px; object-fit: cover;">
                            <div class="navigation-modal-photo">
                                <form action="{{ route('admin.applications.images.delete', [$application, $image]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button-actions">
                                        <img src="{{ asset('images/icon/delete.svg') }}" style="width: 32px; height: 32px">
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-buttons">
                    <a  href="{{ route('admin.applications.images.create', $application) }}" class="create-button">Додати зображення</a>
                    <div class="label-create">
                        <p>Не хочете додавати зображення? </p>
                        <a id="back-button">Назад</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    document.getElementById('back-button').addEventListener('click', function() {
        window.location.href = "{{ route('admin.applications.index') }}";
    });

    function confirmDelete() {
        return confirm(`Ви точно бажаєте видалити зображення?`);
    }
</script>
<style>
    body {
        overflow-x: hidden;
    }

    * {
        box-sizing: border-box;
    }

    .main-content {
        background-color: var(--main-white);
        display: flex;
        align-items: start;
        justify-content: center;
        padding-top: 20px;
        min-height: 80vh;
        gap: 20px;
    }

    .card {
        width: 100%;
        max-width: 450px;
        border: none !important;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
        background-color: transparent;
    }



    .card-header {
        text-align: center;
        color: var(--black-my);
        font-size: 2rem;
        font-weight: 700;
        background-color: transparent !important;
        border: none !important;
    }

    .button-actions{
        text-decoration: none;
        border: none;
        background-color: transparent;
        padding: 0;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        gap: 24px;
        background-color: var(--yellow-my) !important;
        border-radius: 16px;
        padding: 2rem !important;
        margin: 0;
    }

    @media (max-width: 768px) {
        .card {
            padding: 24px;
        }
    }

    .card-body-image{
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 16px;
    }


    .image-scroll-container{
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .create-button {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 16px;
        transition: all 0.3s ease-in-out;
        background-color: var(--main-green-dark);
        color: var(--main-white);
        border: none;
        padding: 0.83rem;
    }

    .create-button:hover {
        background-color: var(--green-dark);
        transform: scale(1.05);
    }




    .label-create {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        font-size: 0.875rem;
    }

    .label-create p {
        margin: 0;
        color: var(--green-dark);
    }

    .label-create a {
        color: var(--green-light);
        text-decoration: none;
    }
    .label-create a:visited,
    .label-create a:hover,
    .label-create a:focus,
    .label-create a:active {
        color: var(--green-light);
        text-decoration: none;
    }
    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        display: inline-block;
        padding: 10px 20px;
        background-color: var(--main-white);
        color: var(--black-my);
        border-radius: 16px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: background-color 0.3s ease;
        user-select: none;
    }
</style>
