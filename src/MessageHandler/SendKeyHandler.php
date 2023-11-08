<?php


namespace App\MessageHandler;

use App\Message\SendKey;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use function PHPUnit\Framework\throwException;

#[AsMessageHandler]
class SendKeyHandler
{

    public function __construct(
        private UserRepository $userRepository,
    ){
    }
    public function __invoke(SendKey $message): void
    {

        //throw new RecoverableMessageHandlingException('test');

        $user = $this->userRepository->find($message->getUserId());

        if (!$user)
        {
            return;
        }

        $this->sendEmail($user->getEmail(), $this->getKey());
    }

    public function sendEmail(string $email, int $key)
    {
        file_put_contents('email'.$key.'.txt', $email . ' ' . $key);
    }
    public function getKey()
    {
        sleep(5);
        return random_int(1000, 9999);
    }
}