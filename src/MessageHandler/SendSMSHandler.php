<?php

namespace App\MessageHandler;

use App\Message\SendSMS;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Filesystem\Filesystem;
use DateTime;
use DateTimeZone;

class SendSMSHandler implements MessageHandlerInterface
{
    private UserRepository $userRepository;
    private Filesystem $filesystem;

    public function __construct(UserRepository $userRepository, Filesystem $filesystem)
    {
        $this->userRepository = $userRepository;
        $this->filesystem = $filesystem;
    }

    public function __invoke(SendSMS $message)
    {
        $user = $this->userRepository->find($message->getUserID());

        if (!$user) {
            return;
        }

        $phone = $user->getPhone();

        if ($phone) {
            if ($message->getRandomDigit() % 2 == 0) {
                throw new \Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException('Nope Try Again');
            }
            $this->sendSms($phone, $this->getKey());
        } else {
            throw new \Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException('THERE"S NOTHING THERE!');
        }
    }

    public function sendSms(string $phone, int $key): void
    {
        $currentDateTime = new DateTime('now', new DateTimeZone('Europe/Warsaw'));

        $textSms = $currentDateTime->format("Y-m-d H:i:s") . "\n" . $phone . ', twój kod: ' . $key . "\n";

        $fileName = 'sms_' . substr($phone, 3, 9) . '.txt';
        $filePath = 'public/SMS/' . $fileName;

        $this->filesystem->appendToFile($filePath, $textSms, true);
    }

    private function getKey()
    {
        sleep(5);
        return random_int(1000, 9999);
    }
}