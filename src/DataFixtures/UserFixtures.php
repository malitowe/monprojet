<?php



namespace App\DataFixtures;



use App\Entity\Administrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$username, $password, $email, $fullname, $role]) {
            $user = new Administrator();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setCreatedAt(time());
            $user->setUpdatedAt(time());
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $manager->persist($user);
            $this->addReference($username, $user);

        }
        $manager->flush();
    }



    private function getUserData(): array
    {
        return [
            ['hermann@gmail.com', 'hermann@gmail.com', 'hermann@gmail.com', 'admin admin', ['ROLE_ADMIN']]
        ];
    }
}

