<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card-application">
        <div class="card-foto">
            <div class="image-scroll-container" style="overflow-x: auto; white-space: nowrap; margin: 0">
                @if($application->images->isEmpty())
                    <!-- Заглушка: картинка або текст -->
                    <div class="no-image-placeholder" style="height: 130px; width: 100%; display: flex; justify-content: center; align-items: center; background: var(--yellow-my); color: var(--green-dark); font-size: 16px; border-radius: 8px;">
                        Зображень немає
                    </div>
                    {{-- або замість тексту можете вставити зображення заглушки: --}}
                    {{-- <img src="{{ asset('images/no-image.png') }}" alt="Зображень немає" style="max-height: 130px; object-fit: contain;"> --}}
                @else
                    @foreach ($application->images as $image)
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Зображення заявки" class="img-fluid" style="max-height: 130px; object-fit: cover; display: inline-block">
                    @endforeach
                @endif
            </div>
        </div>
        <div class="card-header-app">
            <h5 class="card-title-app">{{ $application->title }}
                @if($application->is_urgent)
                    <span class="term">Термінова</span>
                @endif
            </h5>
            <h6 class="card-subtitle-app">{{ $application->category->name }}</h6>
        </div>
        <div class="buttons-blocks">
            <a href="javascript:void(0);" class="button-view-info" data-toggle="modal" data-target="#applicationModal{{ $application->id }}">
                Детальніше
                <img src="{{ asset('images/icon/info.svg') }}">
            </a>
            <div class="card-buttons">
                <div class="like-count">
                    <img src="{{ asset('images/icon/likes/like-filled.svg') }}" style="width: 24px; height: 24px;">
                    <span>{{ $application->liked_by_users_count }}</span>
                </div>
                <a href="{{ route('user.military.edit', $application) }}" class="button-actions">
                    <img src="{{ asset('images/icon/edit.svg') }}">
                </a>
                <form action="{{ route('user.military.destroy', $application) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $application->title }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button-actions">
                        <img src="{{ asset('images/icon/delete.svg') }}" style="width: 32px; height: 32px">
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="applicationModal{{ $application->id }}" tabindex="-1" aria-labelledby="applicationModalLabel{{ $application->id }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style="top: 10%; left: 30%;">
        <div class="modal-info-block">
            <div class="modal-status-close">
                <p class="info-status
                    @if ($application->status === 'створено') status-created
                    @elseif ($application->status === 'прийнято') status-accepted
                    @elseif ($application->status === 'відхилено') status-rejected
                    @endif">
                    {{ $application->status }}
                </p>
                <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('images/icon/cancell.svg') }}">
                </button>
            </div>
            @if($application->is_urgent)
                <span style="width: max-content" class="term">Термінова</span>
            @endif
            <div class="modal-text">
                <div class="modal-title">
                    <p class="info-title">{{ $application->title }}</p>
                    <p class="info-category">{{ $application->category->name }}</p>
                </div>
                <div class="modal-description">
                    <p class="info-description">{{ $application->description }}</p>
                </div>
            </div>

            <div class="modal-foto">
                <div class="image-scroll-container" style="overflow-x: auto; white-space: nowrap; margin: 0">
                    @if($application->images->isEmpty())
                        <div class="no-image-placeholder" style="height: 130px; width: 100%; display: flex; justify-content: center; align-items: center; background: #f0f0f0; color: #888; font-size: 16px; border-radius: 8px;">
                            Зображень немає
                        </div>
                    @else
                        @foreach ($application->images as $image)
                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Зображення заявки" class="img-fluid" style="max-height: 130px; object-fit: cover; display: inline-block">
                        @endforeach
                    @endif
                </div>
                <div class="navigation-modal-photo">
                    <a href="{{ route('user.military.images.create', $application) }}" class="button-images" type="button">
                        <img src="{{ asset('images/icon/znak.svg') }}">
                    </a>
                    <a href="{{ route('user.military.images.edit', $application) }}" class="button-images" type="button">
                        <img src="{{ asset('images/icon/edit.svg') }}" style="width: 28px">
                    </a>
                </div>
            </div>

            @if ($application->volunteer)
                <div class="modal-text-volunteers">
                    <p class="info-vol">
                        <strong class="info-vol">Заявку прийняв волонтер:</strong>
                        {{ $application->volunteer->name }}
                    </p>
                    <p class="info-vol">
                        <strong class="info-vol">Коментар:</strong>
                        {{ $application->comment }}
                    </p>
                    @if ($application->status === 'прийнято')
                        <a href="{{ route('military.rate', $application) }}" class="button-report" type="button">
                            Оцінити волонтера
                        </a>
                    @endif
                </div>
            @endif

            <div class="modal-footer">

                <a href="#"
                   class="button-report generate-one-pdf"
                   data-url="{{ route('user.military.pdf', $application->id) }}">
                    <img src="{{ asset('images/icon/pdf.svg') }}">
                    Сформувати .pdf
                </a>
                <div class="card-buttons-f">
                    <div class="like-count">
                        <img src="{{ asset('images/icon/likes/like-filled.svg') }}" style="width: 24px; height: 24px;">
                        <span>{{ $application->liked_by_users_count }}</span>
                    </div>
                    <a href="{{ route('user.military.edit', $application) }}" class="button-actions" type="button">
                        <img src="{{ asset('images/icon/edit.svg') }}" style="width: 32px; height: 32px">
                    </a>
                    <form action="{{ route('user.military.destroy', $application) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $application->title }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button-actions">
                            <img src="{{ asset('images/icon/delete.svg') }}" style="width: 32px; height: 32px">
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        function confirmDelete(title) {
            return confirm(`Видалити заявку "${title}"?`);
        }


        document.addEventListener('click', function (e) {
            const button = e.target.closest('.generate-one-pdf');
            if (!button) return;

            e.preventDefault();

            if (button.disabled) return; // <--- захист від повторних кліків
            button.disabled = true;

            const url = button.getAttribute('data-url');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            showToast('Формується PDF...', 'info');

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('PDF не вдалося згенерувати.');
                    return response.blob();
                })
                .then(blob => {
                    const downloadUrl = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = downloadUrl;
                    a.download = 'Звіт.pdf';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    setTimeout(() => window.URL.revokeObjectURL(downloadUrl), 100);
                    showToast('Файл успішно завантажено', 'success');
                })
                .catch(error => {
                    console.error(error);
                    showToast('Сталася помилка при генерації PDF.', 'error');
                })
                .finally(() => {
                    button.disabled = false;
                });
        });

    </script>
<style>
    .card-application{
        width: calc(25% - 27px);
        display: flex;
        justify-content: flex-end;
        align-items: flex-start;
        flex-direction: column;
        padding: 16px;
        gap: 24px;
        background-color: var(--yellow-my);
        border-radius: 16px;
    }

    .card-foto{
        padding: 0;
    }

    .card-header-app{
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        flex-direction: column;
        gap: 10px;
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

    .term{
        border-radius: 16px;
        font-size: 14px;
        font-weight: 600;
        line-height: 130%;
        background-color: var(--red-100);
        color: var(--red-100-15);
        padding: 4px 8px;
    }

    .card-subtitle-app{
        color: var(--main-green-dark);
        font-size: 16px;
        font-weight: 400;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .image-scroll-container::-webkit-scrollbar {
        height: 8px;
    }

    .image-scroll-container::-webkit-scrollbar-track {
        background: var(--green-light);
    }

    .image-scroll-container::-webkit-scrollbar-thumb {
        background: var(--orange-my);
        border-radius: 10px;
    }

    .image-scroll-container::-webkit-scrollbar-thumb:hover {
        background: var(--orange-my);
    }
    .image-scroll-container img {
        height: 130px;
        width: auto;
        object-fit: cover;
        display: inline-block;
    }

    .like-count{
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 1px;
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

    .card-buttons{
        display: flex;
        align-items: center;
        flex-direction: row;
        padding: 0;
        gap: 16px;
    }

    .button-actions{
        text-decoration: none;
        border: none;
        background-color: transparent;
        padding: 0;
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


    .modal-status-close{
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        padding: 0;
        margin: 0;

    }

    .info-status {
        display: flex;
        padding: 4px 16px;
        margin: 0 !important;
        border-radius: 16px;
        font-size: 14px;
        font-weight: 400;
        line-height: 130%;
        border: 1px solid;
    }

    .status-created {
        border-color: var(--green-100);
        background-color: var(--green-15);
        color: var(--green-100);
    }

    .status-accepted {
        border-color: var(--blue-100);
        background-color: var(--blue-15);
        color: var(--blue-100);
    }

    .status-rejected {
        border-color: var(--red-100);
        background-color: var(--red-15);
        color: var(--red-100);
    }


    .close-button{
        padding: 0;
        margin: 0;
        background-color: transparent;
        border: none;
    }

    .modal-text{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 12px;
    }

    .modal-title, .modal-description{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 0;

    }

    .info-title{
        color: var(--black-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .info-category{
        color: var(--greey-my);
        font-size: 16px;
        font-weight: 400;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .info-description{
        color: var(--green-dark);
        font-size: 16px;
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

    .navigation-modal-photo{
        height: fit-content;
        display: flex;
        justify-content: center;
        padding: 8px 4px;
        flex-direction: column;
        gap: 16px;
        border-radius: 16px;
        background-color: var(--yellow-my);
    }

    .modal-footer{
        width: 100%;
        display: flex;
        align-items: start;
        justify-content: start;
        flex-direction: row;
        gap: 16px;
    }
    .card-buttons-f{
        display: flex;
        align-items: center;
        flex-direction: row;
        padding: 0;
        gap: 16px;
    }

    .modal-text-volunteers{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 0;
    }

    .info-vol{
        color: var(--orange-my);
        font-size: 16px;
        font-weight: 400;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }


    @media (max-width: 768px) {

        .card-application{
            width: calc(50% - 12px);
            gap: 12px;
        }

        .card-title-app {
            font-size: 16px;
        }

        .card-subtitle-app{
            font-size: 12px;
        }

        .image-scroll-container::-webkit-scrollbar {
            height: 4px;
        }

        .image-scroll-container img {
            height: 100px;
        }

        .like-count{
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1px;
        }

        .buttons-blocks{
            display: flex;
            flex-direction: column;
            align-items: start;
            gap: 8px;
        }


        .card-buttons{
            width: 100%;
            justify-content: space-between;
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



        .modal-status-close{
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            padding: 0;
            margin: 0;

        }

        .modal-text{
            display: flex;
            justify-content: start;
            flex-direction: column;
            gap: 12px;
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

        .info-category{
            font-size: 14px;
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

        .card-buttons-f{
            gap: 12px;
        }


        .info-vol{
            font-size: 14px;
        }
    }




</style>

