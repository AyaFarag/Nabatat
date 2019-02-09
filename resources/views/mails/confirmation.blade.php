@component('mail::message')
<section class="w-100 h-100 d-inline-flex align-items-center">
    <div class="w-100 text-center">
        <div class="col-12 mb-4">
            <img src="{{ asset("/images/logo-color.png") }}"/>
        </div>
        <div class="col-12">
            <h1 class="w-100 font-weight-bold" style="color: #19adb9;">Welcome to Tadawy!</h1>
        </div>
        <div class="col-12">
            <p class="w-100">Hello,<br/>
                We are almost done creating your Nabta account
                You can use this account to log in into Nabta mobile application
                <br/><br/>
                Click the link below to verify this email address.
            </p>
        </div>
        <div class="col-12">
            <a href="{{ $link }}" class="p-3 mx-auto" style="border-radius: 25px; background-color: #6ac5b4; color: #FFF">VERIFY EMAIL
                ADDRESS!
            </a>
        </div>
        <div class="col-12 py-3">
            <p class="w-100">
                If you did not register for an Nabta Account<br/>
                someone may have registered with your information by mistake<br/>
                If you ignore or delete this email, nothing further will happen.
            </p>
        </div>
    </div>
</section>
@endcomponent
