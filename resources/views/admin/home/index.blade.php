@extends('layouts.app')
@include('layouts.header_admin')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="main-info">
            @include('components.sidebar_account', ['user' => $user])

            <div class="info">
                <div class="info-blocks">
                    <div class="info-card" style="background-color: var(--blue-100-15);">
                        <div class="info-content">
                            <p class="info-label">Всього заявок</p>
                            <h4 class="info-value" style="color: var(--blue-100);">{{ $totalApplications }}</h4>
                        </div>
                        <div class="info-icon" style="background-color: var(--blue-100);"><i class="fas fa-file-alt"></i></div>
                    </div>

                    <div class="info-card" style="background-color: var(--orange-100-15);">
                        <div class="info-content">
                            <p class="info-label">Всього користувачів</p>
                            <h4 class="info-value" style="color: var(--orange-100);">{{ $totalUsers }}</h4>
                        </div>
                        <div class="info-icon" style="background-color: var(--orange-100);"><i class="fas fa-users"></i></div>
                    </div>

                    <div class="info-card" style="background-color: var(--green-100-15);">
                        <div class="info-content">
                            <p class="info-label">Всього волонтерів</p>
                            <h4 class="info-value" style="color: var(--green-100);">{{ $totalVolunteers }}</h4>
                        </div>
                        <div class="info-icon" style="background-color: var(--green-100);"><i class="fas fa-hand-holding-heart"></i></div>
                    </div>

                    <div class="info-card" style="background-color: var(--red-100-15);">
                        <div class="info-content">
                            <p class="info-label">Найбільше заявок у військового</p>
                            <h4 class="info-value" style="color: var(--red-100);">{{ $topMilitaryName }}</h4>
                        </div>
                        <div class="info-icon" style="background-color: var(--red-100);"><i class="fas fa-user-shield"></i></div>
                    </div>
                </div>
                <div class="status-cards-container">
                    <div class="status-card ">
                        <p class="status-label">Заявки зі статусом - створено</p>
                        <h4 class="status-value">{{ $applicationsCreated }}</h4>
                    </div>
                    <div class="status-card ">
                        <p class="status-label">Заявки зі статусом - прийнято</p>
                        <h4 class="status-value">{{ $applicationsAccepted }}</h4>
                    </div>
                    <div class="status-card ">
                        <p class="status-label">Заявки зі статусом - відхилено</p>
                        <h4 class="status-value">{{ $applicationsRejected }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <canvas id="applicationsChart" width="400" height="200"></canvas>
        </div>
    </div>


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

    .main-info{
        display: flex;
        justify-content: left;
        flex-direction: row;
        align-items: center;
        padding: 64px 80px;
        gap: 80px;
    }

    .info-blocks {
        display: flex;
        flex-direction: row;
        gap: 20px;
    }
    .info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-card, .status-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        border-radius: 16px;
        transition: transform 0.3s;
        position: relative;
    }

    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        margin: 0;
    }

    .info-content {
        text-align: left;
    }

    .info-label {
        color: var(--green-dark) !important;
        font-size: 16px;
        font-weight: 400;
        line-height: 130%;
    }

    .info-value {
        font-size: 22px;
        font-weight: 600;
        line-height: 130%;
    }

    .status-card {
        background-color: var(--white-my);
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        padding: 16px;
        width: 100%;
        border-radius: 16px;

        border: 1px solid var(--orange-my);
    }

    .status-label {
        font-size: 1.2rem;
        color: #555;
    }

    .status-value {
        font-size: 2rem;
        font-weight: bold;
        color: var(--orange-my);
    }

    .status-cards-container {
    display: flex;
    width: 100%;
    gap: 20px;
}

.status-card {
    flex: 1;
    text-align: center;
    padding: 15px;
    border-radius: 15px;
}

.status-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('applicationsChart').getContext('2d');
        const userApplications = @json($userApplications);

        const labels = userApplications.map(data => data.user);
        const dataValues = userApplications.map(data => data.total);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Кількість заявок кожного військового',
                    data: dataValues,
                    backgroundColor: '#8fbc82',
                    borderColor: '#2B4324',
                    borderWidth: 2,
                    borderRadius: 10,
                    hoverBackgroundColor: '#f8f9ab',
                    hoverBorderColor: '#F5F786'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#2B4324',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#2B4324',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Кількість заявок',
                            color: '#555',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            color: '#333',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(200, 200, 200, 0.3)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Користувачі',
                            color: '#555',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            color: '#333',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(200, 200, 200, 0.1)'
                        }
                    }
                }
            }
        });
    });
</script>
