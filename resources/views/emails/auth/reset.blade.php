@component('mail::message')
# Introduction

Blood Bank Reset Code

@component('mail::button', ['url' => 'https://laravel.com/docs'])
Laravel Docs
@endcomponent


<p>Your reset code is : {{$code}} </p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
