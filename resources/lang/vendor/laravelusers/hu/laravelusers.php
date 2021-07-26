<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Users Blades Language Lines
    |--------------------------------------------------------------------------
    */

    'showing-all-users'     => 'Orvosok listája',
    'users-menu-alt'        => 'Szerkesztőmenü megjelenítése',
    'create-new-user'       => 'Új orvos felvétele',
    'show-deleted-users'    => 'Törölt orvosok mutatása',
    'editing-user'          => ':name szerkesztése',
    'showing-user'          => ':name mutatása',
    'showing-user-title'    => ':name adatai',

    'users-table' => [
        'caption'   => '{1} :userscount felhasználó|[2,*] :userscount felhasználó',
        'id'        => 'ID',
        'name'      => 'Név',
        'email'     => 'E-mail',
        'role'      => 'Csoport',
        'created'   => 'Létrehozva',
        'updated'   => 'Módosítva',
        'actions'   => 'Akciók',
    ],

    'buttons' => [
        'create-new'    => '<span class="hidden-xs hidden-sm">Új orvos</span>',
        'delete'        => '<i class="far fa-trash-alt fa-fw" aria-hidden="true"></i>  <span class="hidden-xs hidden-sm">Törlés</span>',
        'show'          => '<i class="fas fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Részletek</span>',
        'edit'          => '<i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Szerkesztés</span>',
        'back-to-users' => '<span class="hidden-sm hidden-xs">Lista</span>',
        'back-to-user'  => '<span class="hidden-xs">Felhasználó</span>',
        'delete-user'   => '<i class="far fa-trash-alt fa-fw" aria-hidden="true"></i>  <span class="hidden-xs">Törlés</span>',
        'edit-user'     => '<i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> <span class="hidden-xs">Szerkesztés</span>',
    ],

    'tooltips' => [
        'delete'        => 'Törlés',
        'show'          => 'Részletek',
        'edit'          => 'Szerkesztés',
        'create-new'    => 'Új orvos',
        'back-users'    => 'Vissza az orvosokhoz',
        'email-user'    => 'Levél küldése: :user',
        'submit-search' => 'Keresés',
        'clear-search'  => 'Feltétel törlése',
    ],

    'messages' => [
        'userNameTaken'          => 'Foglalt felhasználónév',
        'userNameRequired'       => 'Hiányzó felhasználónév',
        'fNameRequired'          => 'Keresztnév megadása kötelező',
        'lNameRequired'          => 'Vezetéknév megadása kötelező',
        'emailRequired'          => 'E-mail cím megadása kötelező',
        'emailInvalid'           => 'Helytelen e-mail cím',
        'passwordRequired'       => 'Jelszó megadása kötelező',
        'PasswordMin'            => 'A jelszó legalább 6 karakter kell legyen',
        'PasswordMax'            => 'A jelszó legfeljebb 20 karakter lehet',
        'captchaRequire'         => 'Hiányzó captcha',
        'CaptchaWrong'           => 'Helytelen captcha, próbálja újra!',
        'roleRequired'           => 'Csoport megadása kötelező',
        'user-creation-success'  => 'Orvos felvétele',
        'update-user-success'    => 'Orvosadatai frissítve',
        'delete-success'         => 'Orvos törölve',
        'cannot-delete-yourself' => 'Önmagát nem törölheti',
    ],

    'show-user' => [
        'id'                => 'Azonosító',
        'name'              => 'Felhasználónév',
        'email'             => 'Email <span class="hidden-xs"> cím</span>',
        'role'              => 'Csoport',
        'created'           => 'Létrehozva',
        'updated'           => 'Frissítve',
        'labelRole'         => 'Csoport',
        'labelAccessLevel'  => 'Hozzáférési szint|Hozzáférési szintek',
    ],

    'search'  => [
        'title'         => 'Keresési eredmények',
        'found-footer'  => ' találat',
        'no-results'    => 'Nincs találat',
    ],
];
