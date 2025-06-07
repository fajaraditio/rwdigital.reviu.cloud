<?php

namespace App\Constants;

class UserDetailConstant
{
    public const GENDER_MALE = "Male";
    public const GENDER_FEMALE = "Female";

    public const GENDER_ENUMS = [
        UserDetailConstant::GENDER_MALE,
        UserDetailConstant::GENDER_FEMALE
    ];

    public const GENDER_LABELS = [
        "Male"      => "Laki-laki",
        "Female"    => "Perempuan",
    ];
}
