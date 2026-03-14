<?php

namespace Zainpay\SDK;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Lib\RequestTrait;

class NotificationServiceSubscription
{
    use RequestTrait;

    /**
     * Get the list of subscriptions history.
     *
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=get-subscriptions-history
     */
    public function history(string $zainboxCode): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/service-subscription/subscriptions/all/' . $zainboxCode);
    }

    /**
     * Get the list of active subscriptions.
     *
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=get-active-subscriptions
     */
    public function activeList(string $zainboxCode): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/service-subscription/subscriptions/active/' . $zainboxCode);
    }

    /**
     * Subscribe to a notification service.
     *
     * @param string $zainboxCode
     * @param string $serviceName
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=subscription-subscribe
     */
    public function subscribe(string $zainboxCode, string $serviceName): Response
    {
        return $this->post(
            $this->getModeUrl() . 'zainbox/service-subscription/subscribe',
            $this->buildPayload($zainboxCode, $serviceName)
        );
    }

    /**
     * Unsubscribe from a notification service.
     *
     * @param string $zainboxCode
     * @param string $serviceName
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=subscription-unsubscribe
     */
    public function unsubscribe(string $zainboxCode, string $serviceName): Response
    {
        return $this->post(
            $this->getModeUrl() . 'zainbox/service-subscription/unsubscribe',
            $this->buildPayload($zainboxCode, $serviceName)
        );
    }

    private function buildPayload(string $zainboxCode, string $serviceName): array
    {
        return [
            'zainboxCode' => $zainboxCode,
            'serviceName' => $serviceName,
        ];
    }
}
