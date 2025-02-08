<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent()]
final class Alert
{
    #[ExposeInTemplate]
    public string $message = '';

    #[ExposeInTemplate('alert_type')]
    private string $type = 'success';

    #[ExposeInTemplate(name: 'ico', getter: 'fetchIcon')]
    private string $icon;

    #[ExposeInTemplate]
    public bool $dismissable = true;

    public function getMessage(): string {
        return $this->message;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function fetchIcon(): string {
        return match($this->type) {
            'success' => 'bi-bell-fill',
            'danger' => 'bi-exclamation-circle-fill',
            'warning' => 'bi-exclamation-triangle-fill',
            'info' => 'bi-info-circle-fill'
        };
    }

//    #[ExposeInTemplate]
//    public function getAction():array {
//        // code ...
//    }

    #[ExposeInTemplate('dismissable')]
    public function canBeDismissed(): bool {
        return $this->dismissable;
    }

    public function mount(bool $isSuccess = true): void
    {
        $this->type = $isSuccess ? 'success' : 'danger';
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        // validate data
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['type' => 'success']);
        $resolver->setAllowedValues('type', ['success', 'danger', 'warning', 'info']);
        $resolver->setRequired('message');
        $resolver->setAllowedTypes('message', 'string');

        return $resolver->resolve($data);
    }

    #[PostMount]
    public function processAutoChooseType(array $data): array
    {
        if ($data['autoChooseType'] ?? false) {
            if (str_contains($this->message, 'danger')) {
                $this->type = 'danger';
            }

            unset($data['autoChooseType']);
        }

        return $data;
    }
}
