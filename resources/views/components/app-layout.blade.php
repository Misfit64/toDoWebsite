<x-base-layout>
    <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
        <x-logo />
        ToDoWebsite
        </a>
        <a class="nav-link text-end" href="{{ route('logout') }}">
            Logout
        </a>
    </div>
    </nav>
    {{ $slot }}
</x-base-layout>
