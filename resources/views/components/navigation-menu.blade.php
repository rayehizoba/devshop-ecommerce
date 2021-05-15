{{--   actually we want @admin not @auth but we can change this later--}}
@auth
    <x-navigation-menu.admin/>
@else
    <x-navigation-menu.user/>
@endauth
