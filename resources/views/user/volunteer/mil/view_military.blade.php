@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 50px 0px;">
        <div class="row mb-4">
            <div class="col-md-4">
                <h3>Список військових</h3>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Волонтерів не знайдено.
        </div>

        <div class="row" id="military-card-container">
            @foreach ($militaries as $military)
            <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header" style="background-color: var(--green-400);">
                            @if(count($military->images) > 0)
                        <img src="{{ asset('storage/' . $military->images[0]->image_url) }}" alt="User Image"  style="width:70px; height:70px; border-radius: 50px;">
                            @else
                        <img src="{{ asset('images/acc.jpg') }}" alt="User Image"  style="width:70px; height:70px; border-radius: 50px; border-radius: 50px;">
                            @endif
                            <div class="card-headers" >
                                <h5 class="card-title" style="color: var(--green-800);">{{ $military->name }}</h5>
                                <h5 class="card-title" style="color: var(--green-800);">{{ $military->surname }}</h5>
                            </div>
                        </div>
                        <div class="card-footer" style="background-color: var(--green-200);">
                            <button class="favorite-btn" type="button" data-id="{{ $military->id }}" style="background: none; border: none; cursor: pointer;">
                                <img
                                    src="{{ auth()->user()->favorites->contains($military->id) ? asset('images/icon/bookmarks/bookmark-filled.svg') : asset('images/icon/bookmarks/bookmark.svg') }}"
                                    alt="Favorite"
                                    class="favorite-icon"
                                    data-outline="{{ asset('images/icon/bookmarks/bookmark.svg') }}"
                                    data-filled="{{ asset('images/icon/bookmarks/bookmark-filled.svg') }}"
                                    style="width: 24px; height: 24px;"
                                >
                            </button>
                            <a href="{{ route('user.volunteer.view_info_military', $military->id) }}" class="btn btn-sm" style="color: var(--green-500);">
                                <i class="fas fa-eye"></i> Переглянути
                            </a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

    <script>

function fetchVolunteers(query) {
    const url = `{{ route('user.volunteer.mil.search') }}?query=${encodeURIComponent(query)}`;
    console.log(url);
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
                    data.volunteers.forEach(military => {
                        const card = document.createElement('div');
                         card.className = 'col-md-3 mb-4';
                         card.innerHTML = `
                            <div class="card h-100">
                                <div class="card-header" style="background-color: var(--green-400);">
                                    <div class="image-scroll-container mb-3" style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
                                    ${military.images.map(image => `
                                        <img src="${'{{ asset('storage/') }}' + '/' + image.image_url}" alt="User Image" class="img-fluid" style="width:70px; height:70px; object-fit: cover; display: inline-block; margin-right: 10px; border-radius: 50px;">
                                    `).join('')}
                                </div>
                                </div>
                             <div class="card-body" style="background-color: var(--green-300); color: var(--green-800);">
                                <h5 class="card-title" style="color: var(--green-800);">${military.name}</h5>
                                    <h5 class="card-title" style="color: var(--green-800);">${military.surname}</h5>
                            </div>
                            <div class="card-footer" style="background-color: var(--green-200);">
                                <a href="/user/volunteer/view_info_military/${military.id}" class="btn btn-sm" style="color: var(--green-500);">
                                    <i class="fas fa-eye"></i> Переглянути
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


        document.addEventListener('DOMContentLoaded', function() {
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
                                    alert('Будь ласка, увійдіть, щоб додати в обрані');
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
    .btn {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn:hover {
        background-color: var(--green-800);
        text-decoration: none;
        transform: scale(1.1);
    }

    .card {
        transition: box-shadow 0.3s ease;
        box-shadow: 0 6px 10px rgba(43, 67, 36, 0.6);
    }

    .card:hover {
        box-shadow: 0px 0px 15px rgba(43, 67, 36, 0.3);
        transform: scale(1.01);
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }
    .card-headers {
        min-height: 93px; /* Фіксована мінімальна висота для card-header */
        max-height: 93px; /* Фіксована максимальна висота для card-header */
        overflow: hidden; /* Обмеження тексту, якщо він виходить за межі */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px 0;
    }

    .card-header{
        display: flex;
        flex-direction: row;
        gap: 15px;
        align-items: center;
    }

    .card-footer{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }


    .card-text {
        margin-bottom: 10px;
    }

    .card-title, .card-subtitle {
        margin-bottom: 10px;
    }

    .h-100 {
        height: 100%;
    }
</style>
