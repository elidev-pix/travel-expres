
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
    @php
        $type = $type ?? 'identity';
    @endphp
    <div class="container">
        <div class="head">
            <img src="{{ asset('images/logoTravel.png')}}" alt="logo Travel Express">
            <span>Student management system</span>
            <div class="head-icon">
                <a href="{{ route('document.student-document') }}"><ion-icon name="folder-outline"></ion-icon></a>
                <a href="{{ route('listing.student-list') }}"><ion-icon name="chatbubbles-outline"></ion-icon></a>
                <a href="{{ route('payment.student-payment') }}"><ion-icon name="wallet-outline"></ion-icon></a>
                <a href="{{ route('studentDashboard') }}"><ion-icon name="person-outline"></ion-icon></a>
            </div>
    </div>
        <main>
            <div class="links"><span id="back-link"><ion-icon name="arrow-back-circle-outline"></ion-icon><a id="back" href="#">back</a></span><span id="title">@yield('title')</span></div>
            <div class="main-content">
                <div class="left">
                    @yield('left')
                </div>
                <div class="right">
                    @yield('student_infos')
                    @yield('script')
                </div>
                
            </div>
                
        </main>
        <footer></footer>
       

        <div id="modalUnique" class="modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="contenuFormulaire">
                        <div data-type="identity" style="{{ $type === 'identity' ? '' : 'display:none' }}">
                            @include('profile.partials.register.identity-form', ['type' => 'identity'])
                        </div>
                        <div data-type="personal" style="{{ $type === 'personal' ? '' : 'display:none' }}">
                            @include('profile.partials.register.personal-form', ['type' => 'personal'])
                        </div>
                        <div data-type="identification" style="{{ $type === 'identification' ? '' : 'display:none' }}">
                            @include('profile.partials.register.identification-form', ['type' => 'identification'])
                        </div>
                        <div data-type="health" style="{{ $type === 'health' ? '' : 'display:none' }}">
                            @include('profile.partials.register.health-form', ['type' => 'health'])
                        </div>
                        <div data-type="program" style="{{ $type === 'program' ? '' : 'display:none' }}">
                            @include('profile.partials.register.program-form', ['type' => 'program'])
                        </div>
                        <div data-type="payment" style="{{ $type === 'payment' ? '' : 'display:none' }}">
                            @include('profile.partials.payment.payment-form', ['type' => 'payment'])
                        </div>
                        <div data-type="payment-update" style="{{ $type === 'payment-update' ? '' : 'display:none' }}">
                            @include('profile.partials.payment.payment-update-form', ['type' => 'payment-update'])
                        </div>
                        <div data-type="payment-total" style="{{ $type === 'payment-total' ? '' : 'display:none' }}">
                            @include('profile.partials.payment.payment-total-form', ['type' => 'payment-total'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @stack('scripts')
</body>
</html>