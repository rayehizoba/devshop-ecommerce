{{--   actually we want @admin not @auth but we can change this later--}}
@admin
    <x-navigation-menu.admin/>
@notadmin
    <x-navigation-menu.user :cart="$cart"/>
@endadmin
