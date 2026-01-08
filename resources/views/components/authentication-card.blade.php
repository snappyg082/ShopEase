<div class="min-h-screen bg-cover bg-center bg-no-repeat">

    @include('layouts.navigation')

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/loginBackground.png') }}'); md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>