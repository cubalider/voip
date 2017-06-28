<?php

namespace Yosmy\Voip;

/**
 * @di\service()
 */
class RegisterProviders
{
    /**
     * @var RegisterProvider[]
     */
    private $registerProviderServices;

    /**
     * @var AddProvider
     */
    private $addProvider;

    /**
     * @param RegisterProvider[] $registerProviderServices
     * @param AddProvider        $addProvider
     *
     * @di\arguments({
     *     registerProviderServices: '#yosmy.voip.register_provider'
     * })
     */
    public function __construct(
        array $registerProviderServices,
        AddProvider $addProvider
    ) {
        $this->registerProviderServices = $registerProviderServices;
        $this->addProvider = $addProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        foreach ($this->registerProviderServices as $registerProviderService) {
            $provider = $registerProviderService->register();

            try {
                $this->addProvider->add(
                    $provider->getCode(),
                    $provider->getName()
                );
            } catch (Provider\ExistentException $e) {
                throw new \LogicException();
            }
        }
    }
}