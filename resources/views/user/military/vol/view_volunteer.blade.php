@extends('layouts.app')
@include('layouts.header_military')

@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="volunteer-block" id="volunteer-card-container">
            @foreach ($volunteers as $volunteer)
                <div class="card-volunteer">
                    <div class="card-foto">
                        @if(count($volunteer->images) > 0)
                            <img src="{{ asset('storage/' . $volunteer->images[0]->image_url) }}" alt="User Image"  style="border-radius: 500px;">
                        @else
                            <img src="{{ asset('images/acc.jpg') }}" alt="User Image"  style=" border-radius: 50px;">
                        @endif
                    </div>
                    <div class="card-header-app">
                        <h5 class="card-title-app">{{ $volunteer->name }} {{ $volunteer->surname }}</h5>
                        <div class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="star">
                                    @if($volunteer->average_rating >= $i)
                                        <!-- Повністю заповнена зірочка -->
                                        <div class="full"></div>
                                    @elseif($volunteer->average_rating >= $i - 0.5 && $volunteer->average_rating < $i)
                                        <!-- Половинно заповнена зірочка -->
                                        <div class="half"></div>
                                    @else
                                        <!-- Порожня зірочка -->
                                        <div class="empty"></div>
                                    @endif
                                </div>
                            @endfor
                            <p>{{ number_format($volunteer->average_rating, 1) }}</p>
                        </div>
                    </div>
                    <div class="buttons-blocks">
                        <button class="favorite-btn" type="button" data-id="{{ $volunteer->id }}">
                            <img src="{{ auth()->user()->favorites->contains($volunteer->id) ? asset('images/icon/bookmarks/bookmark-filled.svg') : asset('images/icon/bookmarks/bookmark.svg') }}"
                                 alt="Favorite"
                                 class="favorite-icon"
                                 data-outline="{{ asset('images/icon/bookmarks/bookmark.svg') }}"
                                 data-filled="{{ asset('images/icon/bookmarks/bookmark-filled.svg') }}">
                        </button>
                        <a href="javascript:void(0);" class="button-view-info" data-toggle="modal" data-target="#applicationModal{{ $volunteer->id }}">
                            Детальніше
                            <img src="{{ asset('images/icon/info.svg') }}">
                        </a>
                    </div>
                </div>
            @endforeach
                @foreach ($volunteers as $volunteer)
                    <div class="modal" id="applicationModal{{ $volunteer->id }}" tabindex="-1" aria-labelledby="applicationModalLabel{{ $volunteer->id }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style="top: 10%; left: 30%;">
                        <div class="modal-info-block">
                            <div class="modal-status-close">
                                <div class="modal-title" id="applicationModalLabel{{ $volunteer->id }}">
                                    <p class="info-title">{{ $volunteer->name }} {{ $volunteer->surname }}</p>
                                </div>
                                <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">
                                    <img src="{{ asset('images/icon/cancell.svg') }}">
                                </button>
                            </div>
                            <div class="modal-foto-text">
                                <div class="modal-foto">
                                    @if(count($volunteer->images) > 0)
                                        <img src="{{ asset('storage/' . $volunteer->images[0]->image_url) }}" alt="User Image"  style="border-radius: 500px;">
                                    @else
                                        <img src="{{ asset('images/acc.jpg') }}" alt="User Image"  style=" border-radius: 50px;">
                                    @endif
                                </div>
                                <div class="modal-description">
                                    <p class="info-description">{{ $volunteer->email }}</p>
                                    <p class="info-description">{{ $volunteer->phone }}</p>
                                    <p class="info-description">{{ $volunteer->address }}</p>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="star">
                                            @if($volunteer->average_rating >= $i)
                                                <!-- Повністю заповнена зірочка -->
                                                <div class="full"></div>
                                            @elseif($volunteer->average_rating >= $i - 0.5 && $volunteer->average_rating < $i)
                                                <!-- Половинно заповнена зірочка -->
                                                <div class="half"></div>
                                            @else
                                                <!-- Порожня зірочка -->
                                                <div class="empty"></div>
                                            @endif
                                        </div>
                                    @endfor
                                    <p>{{ number_format($volunteer->average_rating, 1) }}</p>
                                </div>
                                <button class="favorite-btn" type="button" data-id="{{ $volunteer->id }}">
                                    <img src="{{ auth()->user()->favorites->contains($volunteer->id) ? asset('images/icon/bookmarks/bookmark-filled.svg') : asset('images/icon/bookmarks/bookmark.svg') }}"
                                         alt="Favorite"
                                         class="favorite-icon"
                                         data-outline="{{ asset('images/icon/bookmarks/bookmark.svg') }}"
                                         data-filled="{{ asset('images/icon/bookmarks/bookmark-filled.svg') }}">
                                </button>
                            </div>
                        </div>
                    </div>



                    <div class="modal fade" id="applicationModal{{ $volunteer->id }}" tabindex="-1" aria-labelledby="applicationModalLabel{{ $volunteer->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header" style="background-color: var(--green-400);">
                                    <h5 class="modal-title" id="applicationModalLabel{{ $volunteer->id }}">Інформація про волонтера</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="background-color: var(--green-300); color: var(--green-800);">
                                    <h5>{{ $volunteer->name }} {{ $volunteer->surname }} </h5>
                                    <p><strong>Email:</strong> {{ $volunteer->email }}</p>
                                    <p><strong>Телефон:</strong> {{ $volunteer->phone }}</p>
                                    <p><strong>Адреса:</strong> {{ $volunteer->address }}</p>
                                </div>
                                <div class="modal-footer" style="background-color: var(--green-200);">
                                    <button type="button" class="btn btn" style="background-color: var(--yellow-500);" data-dismiss="modal">Закрити</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

        </div>
    </div>

<script>


function fetchVolunteers(query) {
    const url = `{{ route('user.military.vol.search') }}?query=${encodeURIComponent(query)}`;
    console.log(url);  // Для налагодження
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const cardContainer = document.getElementById('volunteer-card-container');
            const noResults = document.getElementById('no-results');
            cardContainer.innerHTML = '';

            if (data.volunteers.length === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
                data.volunteers.forEach(volunteer => {
                    const card = document.createElement('div');
                    card.className = 'col-md-3 mb-4';
                    card.innerHTML = `
                        <div class="card h-100">
                            <div class="card-header" style="background-color: var(--green-400);">
                                   <div class="image-scroll-container mb-3" style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
                                    ${volunteer.images.map(image => `
                                        <img src="${'{{ asset('storage/') }}' + '/' + image.image_url}" alt="User Image" class="img-fluid" style="width:70px; height:70px; object-fit: cover; display: inline-block; margin-right: 10px; border-radius: 50px;">
                                    `).join('')}
                                </div>
                            <div class="card-headers">
                                    <h5 class="card-title" style="color: var(--green-800);">${volunteer.name}</h5>
                                    <h5 class="card-title" style="color: var(--green-800);">${volunteer.surname}</h5>
                                </div>
                            </div>
                            <div class="card-footer" style="background-color: var(--green-200);">
                                <a href="javascript:void(0);" class="btn btn-sm" data-toggle="modal" data-target="#applicationModal${volunteer.id}" style="background-color: var(--yellow-500);">
                                    <i class="fas fa-ellipsis-v" style="font-size: 15px;"></i> Переглянути більше
                                </a>
                            </div>
                        </div>
                    `;
                    cardContainer.appendChild(card);
                });
            }
        })
        .catch(error => console.error('Error:', error));
}


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.favorite-btn .favorite-icon').forEach(function (icon) {
        icon.addEventListener('click', function (e) {
            e.stopPropagation();

            const btn = icon.closest('.favorite-btn');
            const userId = btn.dataset.id;
            const outlineSrc = icon.dataset.outline;
            const filledSrc = icon.dataset.filled;

            fetch(`/users/${userId}/favorite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            alert('Спочатку увійдіть, щоб додати до обраного!');
                            return;
                        }
                        throw new Error('Помилка мережі');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data) return;

                    if (data.status === 'added') {
                        icon.setAttribute('src', filledSrc);
                        btn.classList.add('favorited');
                    } else if (data.status === 'removed') {
                        icon.setAttribute('src', outlineSrc);
                        btn.classList.remove('favorited');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Сталася помилка.');
                });
        });
    });
});



</script>

@include('layouts.footer')
@endsection

<style>

    body {
        overflow-x: hidden;
    }

    * {
        box-sizing: border-box;
    }

    .main-content {
        background-color: var(--main-white);
        max-width: 100%;
        margin: 0 auto;
    }

    .volunteer-block{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 36px;
        padding: 64px 80px;
    }

    @media (max-width: 768px) {

        .volunteer-block{
            gap: 12px;
            padding: 24px;
        }
    }


    .card-volunteer{
        width: calc(25% - 27px);
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-direction: column;
        padding: 16px;
        gap: 24px;
        background-color: var(--yellow-my);
        border-radius: 16px;
    }

    .card-foto{
        padding: 0;
    }
    .card-foto img{
        padding: 0;
        width: 120px;
        height: 120px;
    }

    .card-header-app{
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-direction: column;
        gap: 0;
        background-color: transparent; !important;
        border: none; !important;

    }

    .card-title-app {
        color: var(--black-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .star-rating{
        display: flex;
        flex-direction: row;
        gap: 4px;
        align-items: center;
        justify-content: center;
        color: var(--green-dark);
        font-size: 18px;
        font-weight: 400;
        word-wrap: break-word;
        margin: 0;
    }

    .star-rating p{
        margin: 0;
    }

    .star {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 3px;
        position: relative;
        background: transparent;
    }

    .star .full {
        border: 2px solid var(--orange-my);
        background-color: var(--orange-my);
        width: 100%;
        height: 100%;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        border-radius: 4px;
        box-shadow: 0 0 0 2px var(--orange-my);
    }

    .star .half {
        border: 2px solid var(--orange-my);
        background: linear-gradient(90deg, var(--orange-my) 50%, var(--blue-my) 50%);
        width: 100%;
        height: 100%;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        border-radius: 4px;
        box-shadow: 0 0 0 2px var(--orange-my);
    }

    .star .empty {
        background-color: var(--blue-my);
        border: 2px solid var(--orange-my);
        width: 100%;
        height: 100%;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        border-radius: 4px;
        box-shadow: 0 0 0 2px var(--orange-my);
    }





    .buttons-blocks{
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0;
        background-color: transparent;
        border: none;
    }

    .button-view-info{
        display: flex;
        align-items: center;
        justify-content: center;
        width: auto;
        height: fit-content;
        background-color: var(--yellow-my);
        border-radius: 16px;
        border: 1px var(--main-green-dark) solid;
        color: var(--main-green-dark);
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 130%;
        padding: 6px 16px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .favorite-btn {
        background: none;
        border: none;
        padding: 0;
        margin: 0;
        outline: none;
        cursor: pointer;
        appearance: none;
    }

    .favorite-btn:focus,
    .favorite-btn:active {
        outline: none;
        box-shadow: none;
    }

    .favorite-icon {
        width: 32px;
        height: 32px;
        display: block;
    }






    .modal-status-close{
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        padding: 0;
        margin: 0;

    }

    .modal-info-block{
        width: 40%;
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 24px;
        border-radius: 16px;
        padding: 24px;
        background-color: var(--main-white);
    }


    .close-button{
        padding: 0;
        margin: 0;
        background-color: transparent;
        border: none;
    }

    .modal-foto-text{
        display: flex;
        justify-content: start;
        flex-direction: row;
        gap: 32px;
    }

    .modal-foto{
        padding: 0;
    }
    .modal-foto img{
        padding: 0;
        width: 180px;
        height: 180px;
    }



    .modal-title, .modal-description{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 8px;

    }

    .info-title{
        color: var(--black-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .info-description{
        color: var(--green-dark);
        font-size: 18px;
        font-weight: 400;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .modal-foto{
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-direction: row;
        gap: 16px;
    }


    .modal-footer{
        width: 100%;
        display: flex;
        align-items: start;
        justify-content: start;
        flex-direction: row;
        gap: 16px;
    }

    @media (max-width: 768px) {

        .card-volunteer{
            width: calc(50% - 12px);
            gap: 12px;
        }

        .card-title-app {
            font-size: 16px;
        }


        .buttons-blocks{
            display: flex;
            flex-direction: column;
            align-items: start;
            gap: 8px;
        }

        .modal {
            top: 5% !important;
            left: 5% !important;
            right: 5% !important;
            width: 90% !important;
            margin: 0 auto;
            padding: 0;
        }

        .modal-info-block {
            width: 100% !important;
            max-height: 90vh;
            overflow-y: auto;
            padding: 16px;
            box-sizing: border-box;
        }

        .modal-foto img{
            padding: 0;
            width: 110px;
            height: 110px;
        }

        .modal-status-close{
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            padding: 0;
            margin: 0;

        }



        .modal-title, .modal-description{
            display: flex;
            justify-content: start;
            flex-direction: column;
            gap: 0;

        }

        .info-title{
            font-size: 18px;
        }

        .info-description{
            font-size: 14px;
        }


        .modal-footer{
            width: 100%;
            display: flex;
            align-items: start;
            justify-content: space-between !important;
            flex-direction: row;
            gap: 16px;
        }

    }





</style>
