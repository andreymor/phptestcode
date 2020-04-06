<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Database;

class UserUseCase
{
    public function save()
    {
        $user = (new UserEntity())
                ->setName('Andrey Moretti')
                ->setAge(35)
                ->setJobTitle('Team Leader');

        $repo = new UserRepository();
        $repo->save($user);
    }
}
