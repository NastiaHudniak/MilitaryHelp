@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 40px 0px;">
        <div class="row">
            <div class="col-md-5" style="display: flex;  flex-direction: column;  align-items: flex-start;  justify-content: flex-start;">
                <h3>Інформація про військового</h3>
                <div class="info" style="color: var(--green-500); font-size: 24px;">
                @if ($userImage)
                                    @if(str_contains($userImage->image_url,'images/acc.jpg'))
                                        <img src="{{  url('/').'/'.$userImage->image_url }}" alt="User Image" style="width: 90px; height: 90px; border-radius: 50px;">
                                    @else
                                        <img src="{{ asset('storage/' . $userImage->image_url) }}" alt="User Image" style="width: 90px; height: 90px;border-radius: 50px;">
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

            <div class="col-md-7" style="display: flex;  flex-direction: column;  align-items: flex-start;  justify-content: space-between;">
                <h3>Інформація про заявку</h3>
                <div class="card">
                                <div class="card-header" style="background-color: var(--green-400);">
                                    <h5 class="card-title" style="color: var(--green-800);">{{ $application->title }}</h5>
                                    <h6 class="card-subtitle" style="color: #556155;">{{ $application->category->name }}</h6>
                                </div>
                                <div class="card-body d-flex flex-column" style="background-color: var(--green-300); color: var(--green-800);">
                                <div class="image-scroll-container mb-3" style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
        @foreach ($application->images as $image)
            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Зображення заявки" class="img-fluid" style="max-height: 150px; object-fit: cover; display: inline-block; margin-right: 10px;">
        @endforeach
    </div>
                                <p class="card-text flex-grow-1">{{ $application->description }}</p>
                                    <p class="card-text">
                                        <strong>Статус:</strong>
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
                            </div>

                        <h4>Залишити коментар</h4>
                <form action="{{ route('user.volunteer.confirm_application.confirm', $application->id) }}" method="POST" style="width: 100%; display: flex;  flex-direction: column;" >
                    @csrf
                    <label for="comment">Коментар</label>
                    <input style="width: 100%;" type="text" name="comment" class="form-control" value="{{ $application->comment === 'немає' ? '' : $application->comment }}">
                    <div class="butt" style="  padding-top: 10px; display: flex;  flex-direction: row;  align-items: flex-and;  justify-content: space-between; ">
                        <button type="submit" class="btn btn-warning" style="background-color: var(--yellow-500);">Підтвердити заявку</button>
                        <a href="{{ route('user.volunteer.mil.view_military') }}" class="btn btn-outline " style="color: var(--green-500);border-color: var(--green-500);">Повернутись назад</a>

                    </div>


                </form>
            </div>
        </div>


    </div>
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

    .info {
        width: 100%;
        padding: 20px;
        text-align: center;
        background-color: var(--yellow-200);
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .card {
        height: 65%;
        width: 100%;
        margin-bottom: 10px;
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
