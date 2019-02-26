@component('mail::message')
# Introduction

{{ $newsletter_text }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
