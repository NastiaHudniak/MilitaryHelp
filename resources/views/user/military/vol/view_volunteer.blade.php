@extends('layouts.app')
@include('layouts.header_military')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 50px 0px;">
        <div class="row mb-4">
            <div class="col-md-4">
                <h3>Список волонтерів</h3>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Волонтерів не знайдено.
        </div>

        <div class="row" id="volunteer-card-container">
            @foreach ($volunteers as $volunteer)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header" style="background-color: var(--green-400);">
                            @if(count($volunteer->images) > 0)
                        <img src="{{ asset('storage/' . $volunteer->images[0]->image_url) }}" alt="User Image"  style="width:70px; height:70px;  border-radius: 50px;">
                            @else
                        <img src="{{ asset('images/acc.jpg') }}" alt="User Image"  style="width:70px; height:70px;  border-radius: 50px;">
                            @endif
                            <div class="card-headers" >
                                <h5 class="card-title" style="color: var(--green-800);">{{ $volunteer->name }}</h5>
                                <h5 class="card-title" style="color: var(--green-800);">{{ $volunteer->surname }}</h5>
                            </div>
                        </div>
                        <div class="card-footer" style="background-color: var(--green-200);">
                            <a href="javascript:void(0);" class="btn btn-sm"  data-toggle="modal" data-target="#applicationModal{{ $volunteer->id }}" style="background-color: var(--yellow-500);" >
                                <i class="fas fa-ellipsis-v" style="font-size: 15px;"></i> Переглянути більше
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
                @foreach ($volunteers as $volunteer)
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
    document.getElementById('search').addEventListener('input', function() {
    const query = document.getElementById('search').value;
    fetchVolunteers(query);
});

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


</script>

@include('layouts.footer_military')
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
