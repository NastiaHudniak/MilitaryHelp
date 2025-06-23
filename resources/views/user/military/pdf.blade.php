<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        .modal-info-block {
            width: 100%;
            display: flex;
            justify-content: start;
            flex-direction: column;
            gap: 24px;
            background-color: var(--main-white);
        }

        .modal-status-close {
            display: flex;
            justify-content: flex-start;
            flex-direction: row;
            padding: 0;
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
        .info-status {
            width: fit-content;
            display: inline-block;
            padding: 4px 16px;
            padding-top: 0;
            margin: 0 !important;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 400;
            border: 1px solid;
        }
        .status-created {
            margin: 0 !important;

            border-color: #0BBF0B;
            background-color: rgba(11, 191, 11, 0.15);
            color: #0BBF0B;
        }

        .status-accepted {

            margin: 0 !important;
            border-color: #0B65BF;
            background-color: rgba(11, 101, 191, 0.15);
            color: #0B65BF;
        }

        .status-rejected {

            margin: 0 !important;
            border-color: #FF1D4E;
            background-color: rgba(255, 29, 78, 0.15);
            color: #FF1D4E;
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

        .info-title {
            color: #373737; /* var(--black-my) */
            font-size: 20px;
            font-weight: 600;
            line-height: 30px;
            word-wrap: break-word;
            margin: 0;
        }

        .info-category {
            color: #B8B8B8; /* var(--greey-my) */
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            word-wrap: break-word;
            margin: 0;
        }

        .info-description {
            color: #3A5A40; /* var(--green-dark) */
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            word-wrap: break-word;
        }

        .modal-foto {
            padding: 10px;
            display: inline-block;
            font-size: 0; /* прибирає зайві відступи між inline-block */
        }

        .image-wrapper {
            display: inline-block;
            width: 130px;
            height: 130px;
            margin: 6px;
            overflow: hidden;
            vertical-align: top;
            border: 1px solid transparent;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }




        .modal-text-volunteers{
            display: flex;
            justify-content: start;
            flex-direction: column;
            gap: 0;
        }

        .info-vol{
            color: #D97706;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            word-wrap: break-word;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="modal-info-block">
    <h2>Заявка військового: {{ $fullName }}</h2>
    <p>Дата: {{ $date }}</p>

    <div class="modal-status-close" style="margin-top: 10px">
        <p class="info-status
                @if ($application->status === 'створено') status-created
                @elseif ($application->status === 'прийнято') status-accepted
                @elseif ($application->status === 'відхилено') status-rejected
                @endif">
            {{ $application->status }}
        </p>
    </div>

    <div class="modal-text">
        <div class="modal-title">
            <p class="info-title">Назва заявки "{{ $application->title }}"</p>
            <p class="info-category">{{ $application->category->name }}</p>
        </div>
        @if($application->is_urgent)
            <span class="term">Термінова</span>
        @endif
        <div class="modal-description">
            <p class="info-description">{{ $application->description }}</p>
        </div>
    </div>
    <div class="modal-foto">
        @foreach ($application->images as $image)
            <div class="image-wrapper">
                <img src="{{ public_path('storage/' . $image->image_url) }}" alt="Зображення">
            </div>
        @endforeach
    </div>


@if ($application->volunteer)
        <div class="modal-text-volunteers">
            <p class="info-vol">
                <strong>Заявку прийняв волонтер:</strong> {{ $application->volunteer->name }}
            </p>
            <p class="info-vol">
                <strong>Коментар:</strong> {{ $application->comment ?? 'Немає' }}
            </p>
        </div>
    @endif
</div>
</body>
</html>
