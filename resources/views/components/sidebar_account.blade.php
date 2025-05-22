<div class="sidebar-block-account">
    @if (Auth::user()->role_id == 2)
        <div class="sidebar-navigation-account" id="sidebar-1">
            <a href="{{ route('user.military.view_account') }}"
               class="sidebar-menu {{ request()->routeIs('user.military.view_account') ? 'active' : '' }}">
                <img src="{{ asset(request()->routeIs('user.military.view_account') ? 'images/icon/sidebar/user.svg' : 'images/icon/sidebar/user-g.svg') }}"
                     alt="Кабінет">
                Особистий кабінет
            </a>

            <a href="{{ route('user.military.edit_account', $user) }}"
               class="sidebar-menu {{ request()->routeIs('user.military.edit_account') ? 'active' : '' }}">
                <img src="{{ asset(request()->routeIs('user.military.edit_account') ? 'images/icon/sidebar/edit-w.svg' : 'images/icon/sidebar/edit.svg') }}"
                     alt="Змінити дані">
                Змінити дані
            </a>
        </div>

        <div class="sidebar-navigation-account" id="sidebar-2">
            <a href="{{ route('user.military.create') }}"
               class="sidebar-menu {{ request()->routeIs('user.military.create') ? 'active' : '' }}">
                <img src="{{ asset(request()->routeIs('user.military.create') ? 'images/icon/sidebar/znak-w.svg' : 'images/icon/sidebar/znak.svg') }}"
                     alt="Створити заявку">
                Створити заявку
            </a>

            <a href="{{ route('user.military.view_app') }}"
               class="sidebar-menu {{ request()->routeIs('user.military.view_app') ? 'active' : '' }}">
                <img src="{{ asset(request()->routeIs('user.military.view_app') ? 'images/icon/sidebar/history-w.svg' : 'images/icon/sidebar/history.svg') }}"
                     alt="Заявки">
                Перегляд заявок
            </a>

            <a href="{{ route('user.military.vol.view_volunteer') }}"
               class="sidebar-menu {{ request()->routeIs('user.military.vol.view_volunteer') ? 'active' : '' }}">
                <img src="{{ asset(request()->routeIs('user.military.vol.view_volunteer') ? 'images/icon/sidebar/list-w.svg' : 'images/icon/sidebar/list.svg') }}"
                     alt="Волонтери">
                Перегляд волонтерів
            </a>
        </div>

    @elseif (Auth::user()->role_id == 3)
        <div class="sidebar-navigation-account" id="sidebar-1">
            <a href="{{ route('user.volunteer.view_account') }}"
               class="sidebar-menu {{ request()->routeIs('user.volunteer.view_account') ? 'active' : '' }}">
                <img src="{{ asset(request()->routeIs('user.volunteer.view_account') ? 'images/icon/sidebar/user.svg' : 'images/icon/sidebar/user-g.svg') }}"
                     alt="Кабінет">
                Особистий кабінет
            </a>

            <a href="{{ route('user.volunteer.edit_account', $user) }}"
               class="sidebar-menu {{ request()->routeIs('user.volunteer.edit_account') ? 'active' : '' }}">
                <img src="{{ asset(request()->routeIs('user.volunteer.edit_account') ? 'images/icon/sidebar/edit-w.svg' : 'images/icon/sidebar/edit.svg') }}"
                     alt="Змінити дані">
                Змінити дані
            </a>
        </div>

        <div class="sidebar-navigation-account" id="sidebar-2">
            <a href="{{ route('user.volunteer.view_app') }}"
               class="sidebar-menu {{ request()->routeIs('user.volunteer.view_app') ? 'active' : '' }}">
                <img src="{{ asset(request()->routeIs('user.volunteer.view_app') ? 'images/icon/sidebar/history-w.svg' : 'images/icon/sidebar/history.svg') }}"
                     alt="Заявки">
                Перегляд заявок
            </a>

            <a href="{{ route('user.volunteer.mil.view_military') }}"
               class="sidebar-menu {{ request()->routeIs('user.volunteer.mil.view_military') ? 'active' : '' }}">
                <img src="{{ asset(request()->routeIs('user.volunteer.mil.view_military') ? 'images/icon/sidebar/list-w.svg' : 'images/icon/sidebar/list.svg') }}"
                     alt="Військові">
                Перегляд військових
            </a>
        </div>
    @endif

    <div class="sidebar-navigation-account" id="sidebar-3">
        <form method="POST" action="{{ route('logout') }}" class="sidebar-menu logout-form">
            @csrf
            <img src="{{ asset('images/icon/logout.svg') }}">
            <button type="submit" class="button-log" onclick="return confirmLogout()">
                Вийти з акаунту
            </button>
        </form>
    </div>
</div>

<style>
    .sidebar-block-account{
        background-color: var(--yellow-my);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 300px;
    }

    .sidebar-navigation-account{
        background-color: transparent;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .sidebar-menu {
        display: flex;
        justify-content: left;
        flex-direction: row;
        align-items: start;
        padding: 8px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 16px;
        transition: all 0.3s ease-in-out;
        background-color: transparent;
        color: var(--green-dark);
        gap: 8px;
    }
    .sidebar-menu:hover {
        background-color: var(--green-light);
        color: var(--green-dark);
        text-decoration: none;

    }

    .sidebar-menu:focus {
        background-color: var(--green-light);
        color: var(--green-dark);
        text-decoration: none;

    }

    .sidebar-menu.active {
        background-color: var(--orange-my);
        color: var(--main-white);
        text-decoration: none;
    }

    .button-log{
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0;
        width: 100%;
        display: flex;
        flex-direction: row;
        text-align: left;
        align-items:start;
        font-size: 1rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {

        .sidebar-block-account{

            width: 100%;
        }

    }
</style>


<script>
    function confirmLogout() {
        if (confirm("Ви дійсно бажаєте вийти з акаунта?")) {
            document.querySelector('form').submit();
        }
    }
</script>

