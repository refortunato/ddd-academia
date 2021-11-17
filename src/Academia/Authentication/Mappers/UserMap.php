<?php

namespace Academia\Authentication\Mappers;

use Academia\Authentication\Domain\Entities\User;
use Academia\Core\ValueObjects\Email;

class UserMap
{
    public static function toArray(User $user): array
    {
        $array = [];
        $array['id'] = $user->getId();
        $array['name'] = $user->getName();
        $array['email'] = (string) $user->getEmail();
        $array['user_level'] = $user->getUserLevel();
        
        return $array;
    }

    public static function toPersistance(User $user): array
    {
        $array = [];
        $array['id'] = $user->getId();
        $array['name'] = $user->getName();
        $array['email'] = (string) $user->getEmail();
        $array['user_level'] = $user->getUserLevel();
        $array['password'] = $user->getHashedPassword();

        return $array;
    }

    public static function toEntity(array $fields): ?User
    {
        return new User(
            $fields['id'],
            new Email($fields['email']),
            $fields['name'],
            $fields['user_level'],
            $fields['password']
        );
    }
}