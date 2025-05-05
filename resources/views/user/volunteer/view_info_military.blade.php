@extends('layouts.app')
@include('layouts.header_volunteer_notsearch')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 50px 0px;">
        <div class="row">
            <!-- Left block: Military personnel information -->
            <div class="col-md-5" style="display: flex;  flex-direction: column;  align-items: flex-start;  justify-content: flex-start;">
                <h3>Інформація про військового</h3>
                <div class="info" style="color: var(--green-500); font-size: 24px;">
                @if ($userImage)
                                    @if(str_contains($userImage->image_url,'images/acc.jpg'))
                                        <img src="{{  url('/').'/'.$userImage->image_url }}" alt="User Image" style="width: 30%; height: auto; border-radius: 50px;">
                                    @else
                                        <img src="{{ asset('storage/' . $userImage->image_url) }}" alt="User Image" style="width: 30%; height: auto; border-radius: 50px;">
                                    @endif
                                @else
                                    <p>No image available.</p>
                                @endif
                    <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Логін:</strong> {{$millitary->login }}</p>
                    <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Прізвище:</strong> {{$millitary->surname }}</p>
                    <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Ім'я:</strong> {{$millitary->name }}</p>
                    <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Електронна пошта:</strong> {{$millitary->email }}</p>
                    <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Телефон:</strong> {{$millitary->phone }}</p>
                    <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Адреса:</strong> {{$millitary->address }}</p>
                </div> 
            </div>

            <!-- Right block: Military applications -->
            <div class="col-md-7    ">
                <h3>Заявки військового</h3>
                <div class="row">
                    @foreach ($applications as $application)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                            <div class="card-header" style="background-color: var(--green-400);">
                            <h5 class="card-title" style="color: var(--green-800);">{{ $application->title }}</h5>
                            <h6 class="card-subtitle" style="color: #556155;">{{ $application->category->name }}</h6>
                        </div>
                        <div class="card-body d-flex flex-column" style="background-color: var(--green-300); color: var(--green-800);">
                        <div class="image-scroll-container mb-3" style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
        @foreach ($application->images as $image)
            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Зображення заявки" class="img-fluid" style="max-height: 150px; object-fit: cover; display: inline-block; margin-right: 10px; border-radius: 50px;">
        @endforeach
    </div>
                         
                        <p class="card-text flex-grow-1">{{ $application->description }}</p>
                            <p class="card-text">
                                <strong style="color: #000000;">Статус:</strong>
                                <span class="
        @if ($application->status === 'створено') text-primary
        @elseif ($application->status === 'прийнято') text-success
        @elseif ($application->status === 'відхилено') text-danger
        @endif
    ">
        {{ $application->status }}
    </span>
                            </p>
                        </div>
                        <div class="card-footer" style="background-color: var(--green-200);">
                            <a href="javascript:void(0);" class="btn btn-sm"  data-toggle="modal" data-target="#applicationModal{{ $application->id }}" style="background-color: var(--yellow-500);" >
                                <i class="fas fa-ellipsis-v" style="font-size: 15px;"></i> Переглянути більше
                            </a>
                            <a href="{{ route('user.volunteer.confirm_application', ['id' => $application->id]) }}" class="btn btn-sm" style="background-color: var(--yellow-500);">
                                <span class="lets-icons--done-ring-round"></span>
                            </a>
                        </div>
                            </div>
                        </div>

            
                    @endforeach

                    @foreach ($applications as $application)
                <div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1" aria-labelledby="applicationModalLabel{{ $application->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: var(--green-400);">
                                <h5 class="modal-title" id="applicationModalLabel{{ $application->id }}">Інформація про заявку</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="background-color: var(--green-300); color: var(--green-800);">
                                <h5>{{ $application->title }}</h5>
                                <p><strong>Категорія:</strong> {{ $application->category->name }}</p>
                                <p><strong>Опис:</strong> {{ $application->description }}</p>
                                <p><strong>Статус:</strong> {{ $application->status }}</p>
                                <p><strong>Коментар:</strong> {{ $application->comment }}</p>
                                <p><strong>Волонтер:</strong> {{ $application->volunteer->name ?? 'Немає' }}</p>
                                <p><strong>Військовий:</strong> {{ $application->millitary->name ?? 'Немає' }}</p>
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
        </div>
    </div>
    @include('layouts.footer_volunteer')
@endsection

<style>
    .btn {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    
    .info {
        width: 100%; /* Розмір блоку */
        padding: 20px;
        text-align: center;
        background-color: var(--yellow-200);
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: flex-start; /* Вирівнює іконки та текст по центру по вертикалі */
        gap: 20px; /* Проміжок між іконкою та текстом */
        transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
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

    .card-header {
        min-height: 93px;
        max-height: 93px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
    }

    
.image-scroll-container::-webkit-scrollbar {
    height: 8px; 
}

.image-scroll-container::-webkit-scrollbar-track {
    background: #f1f1f1; 
}

.image-scroll-container::-webkit-scrollbar-thumb {
    background: var(--green-500); 
    border-radius: 10px; 
}

.image-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #45a049; 
}

.image-scroll-container img {
    height: 150px;
    width: auto;
    object-fit: cover; 
    display: inline-block;
    margin-right: 10px;
}
</style>
