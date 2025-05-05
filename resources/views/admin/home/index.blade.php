@extends('layouts.app')
@include('layouts.header_admin')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head> 
@section('content')

<div class="container" style="max-width: 1300px; padding: 50px 0;">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row mt-4">
        <div class="col-md-4">
            

            <div class="card text-center mb-4 shadow position-relative">
                <div class="card-body" style="background-color: var(--green-400);">
                    <div class="circle-number "style="background-color: var(--yellow-400);">1</div>
                    <h5 class="card-title">Управління користувачами</h5>
                    <p class="card-text">Переглянути всіх користувачів.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn" style="background-color: var(--yellow-500);">Перейти</a>
                </div>
            </div>
            <div class="card text-center mb-4 shadow position-relative">
                <div class="card-body" style="background-color: var(--green-400);">
                    <div class="circle-number " style="background-color: var(--yellow-400);">2</div>
                    <h5 class="card-title">Управління заявками</h5>
                    <p class="card-text">Переглянути всі заявки.</p>
                    <a href="{{ route('admin.applications.index') }}" class="btn btn" style="background-color: var(--yellow-500);">Перейти</a>
                </div>
            </div>
            <div class="card text-center mb-4 shadow position-relative">
                <div class="card-body" style="background-color: var(--green-400);">
                    <div class="circle-number "style="background-color: var(--yellow-400);">3</div>
                    <h5 class="card-title">Управління категоріями</h5>
                    <p class="card-text">Переглянути всі категорії.</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn" style="background-color: var(--yellow-500);">Перейти</a>
                </div>
            </div>
        </div>

        <div class="col-md-8 info-blocks">
            <div class="info-card shadow"style="background-color: var(--yellow-200);">
                <div class="info-icon bg-primary"><i class="fas fa-file-alt"></i></div>
                <div class="info-content">
                    <p class="info-label">Всього заявок</p>
                    <h4 class="info-value">{{ $totalApplications }}</h4>
                </div>
            </div>

            <div class="info-card shadow"style="background-color: var(--yellow-200);">
                <div class="info-icon bg-secondary"><i class="fas fa-users"></i></div>
                <div class="info-content">
                    <p class="info-label">Всього користувачів</p>
                    <h4 class="info-value">{{ $totalUsers }}</h4>
                </div>
            </div>

            <div class="info-card shadow"style="background-color: var(--yellow-200);">
                <div class="info-icon bg-success"><i class="fas fa-hand-holding-heart"></i></div>
                <div class="info-content">
                    <p class="info-label">Волонтерів</p>
                    <h4 class="info-value">{{ $totalVolunteers }}</h4>
                </div>
            </div>

            <div class="info-card shadow"style="background-color: var(--yellow-200);">
                <div class="info-icon bg-warning"><i class="fas fa-user-shield"></i></div>
                <div class="info-content">
                    <p class="info-label">Найбільше заявок у військового</p>
                    <h4 class="info-value">{{ $topMilitaryName }}</h4>
                </div>
            </div>

            <div class="status-cards-container">
    <div class="status-card shadow "style="background-color: var(--yellow-400);">
        <p class="status-label">Заявки зі статусом - створено</p>
        <h4 class="status-value">{{ $applicationsCreated }}</h4>
    </div>
    <div class="status-card shadow "style="background-color: var(--yellow-400);">
        <p class="status-label">Заявки зі статусом - прийнято</p>
        <h4 class="status-value">{{ $applicationsAccepted }}</h4>
    </div>
    <div class="status-card shadow "style="background-color: var(--yellow-400);">
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
    .circle-number {
        position: absolute;
        top: -15px;
        left: -15px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .info-blocks {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .info-card, .status-card {
        display: flex;
        align-items: center;
        padding: 15px;
        border-radius: 10px;
        transition: transform 0.3s;
        position: relative;
        margin-bottom: 20px;
        width: 48%;
    }

    .info-card {
        background-color: #fff;
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
        margin-right: 15px;
    }

    .info-content {
        text-align: left;
    }

    .info-label {
        font-size: 1rem;
        color: #666;
    }

    .info-value {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
    }

    .status-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        padding: 15px;
        width: 100%;
        border-radius: 15px;
    }

    .status-label {
        font-size: 1.2rem;
        color: #555;
    }

    .status-value {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
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
